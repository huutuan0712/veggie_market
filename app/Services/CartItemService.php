<?php

namespace App\Services;

use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class CartItemService extends BaseService
{
    /**
     * @var CartItem|Builder
     */
    protected Model|Builder $model;
    protected Product $product;

    public function __construct(CartItem $model, Product $product)
    {
        $this->model = $model;
        $this->product = $product;
    }

    public function getCartItemsAndTotal()
    {
        $user = Auth::user();

        if ($user) {
            return $this->getAuthenticatedCart($user->id);
        } else {
            return $this->getGuestCart();
        }
    }

    private function getAuthenticatedCart($userId)
    {
        $cartItems = $this->model->with(['product.images'])
            ->where('user_id', $userId)
                ->get()
                ->map(function ($item) {
                    return (object)[
                        'id' => $item->product->id,
                        'name' => $item->product->name,
                        'image' => $item->product->images->first()?->path,
                'price' => $item->product->price,
                'quantity' => $item->quantity,
            ];
        });

        $total = $cartItems->sum(fn($item) => $item->price * $item->quantity);

        return compact('cartItems', 'total');

    }

    private function getGuestCart()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return [
                'cartItems' => collect(),
                'total' => 0
            ];
        }

        $productIds = array_keys($cart);

        $products = $this->product->with('images')->whereIn('id', $productIds)->get();

        $cartItems = $products->map(function ($product) use ($cart) {
            return (object)[
                'id' => $product->id,
                'name' => $product->name,
                'image' => $product->images->first()?->path,
                'price' => $product->price,
                'quantity' => $cart[$product->id]
            ];
        });

        $total = $cartItems->sum(fn($item) => $item->price * $item->quantity);

        return compact('cartItems', 'total');
    }

    public function addToCart($data): array
    {
        $productId = $data->product_id;
        $quantity = $data->quantity;

        $user = auth()->user();

        if (!$user) {
            $cart = session()->get('cart', []);
            $cart[$productId] = ($cart[$productId] ?? 0) + $quantity;
            session()->put('cart', $cart);

            $totalCount = collect($cart)->count();

            return [
                'cartCount' => $totalCount,
            ];
        }

        // Nếu có session cart, merge vào database
        $sessionCart = session()->pull('cart', []);

        foreach ($sessionCart as $productIdFromSession => $qty) {
            $cartItem = $this->model->where('user_id', $user->id)
                ->where('product_id', $productIdFromSession)
                ->first();

            if ($cartItem) {
                $cartItem->increment('quantity', $qty);
            } else {
                $this->model->create([
                    'user_id' => $user->id,
                    'product_id' => $productIdFromSession,
                    'quantity' => $qty,
                ]);
            }
        }

        $cartItem = $this->model->where('user_id', $user->id)
            ->where('product_id', $productId)
            ->first();

        if ($cartItem) {
            $cartItem->increment('quantity', $quantity);
        } else {
            $this->model->create([
                'user_id' => $user->id,
                'product_id' => $productId,
                'quantity' => $quantity,
            ]);
        }

        $totalCount = $this->model->where('user_id', $user->id)->count();

        return [
            'cartCount' => $totalCount,
        ];
    }

   public function updateCartQuantity(int|string $productId, int $quantity): array
    {
        $user = auth()->user();
        $quantity = max($quantity, 1);

        if ($user) {
            $cartItem = $this->model->where('user_id', $user->id)
                ->where('product_id', $productId)
                ->first();

            if ($cartItem) {
                $cartItem->update(['quantity' => $quantity]);
            } else {
                $this->model->create([
                    'product_id' => $productId,
                    'user_id' => $user->id,
                    'quantity' => $quantity
                ]);
            }

            $cartItems = $this->model->with('product')
                ->where('user_id', $user->id)
                ->get();

            $total = $cartItems->sum(fn ($item) => $item->product?->price * $item->quantity);
        } else {
            $cart = session()->get('cart', []);
            $cart[$productId] = $quantity;
            session()->put('cart', $cart);

            $productIds = array_keys($cart);
            $products = \App\Models\Product::whereIn('id', $productIds)->get();

            $total = $products->sum(fn ($product) => ($cart[$product->id] ?? 0) * $product->price);
        }

        return [
            'quantity' => $quantity,
            'total' => number_format($total),
        ];
    }


    public function deleteCart(string $productId)
    {
        $user = auth()->user();
        if($user)
        {
            $this->model->where('user_id', $user->id)->where('product_id',$productId)->delete();
            $cartCount = $this->model->where('user_id', $user->id)->count();

            $cartItems = $this->model->where('user_id', $user->id)->get();
            $total = $cartItems->sum(fn ($item) => $item->product?->price * $item->quantity);
        } else {
            $cart = session()->get('cart', []);
            unset($cart[$productId]);
            session()->put('cart', $cart);

            $cartCount = count($cart);
            $total = 0;

            foreach ($cart as $item) {
                $total += $item['price'] * $item['quantity'];
            }
        }

        return [
            'cartCount' => $cartCount,
            'total' => number_format($total)
        ];
    }

}
