<?php

namespace App\Http\Controllers;

use App\Http\Requests\Cart\AddCartRequest;
use App\Http\Responses\ApiResponse;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        if ($user) {
            $cartItems = CartItem::with('product')
                ->where('user_id', $user->id)
                ->get()
                ->map(function ($item) {
                    return (object)[
                        'id' => $item->product->id,
                        'name' => $item->product->name,
                        'image' => $item->product->image,
                        'price' => $item->product->price,
                        'quantity' => $item->quantity,
                    ];
                });

            $total = $cartItems->sum(fn($item) => $item->price * $item->quantity);
        } else {
            $cart = session()->get('cart', []);

            if (empty($cart)) {
                $cartItems = collect();
                $total = 0;
            } else {
                $productIds = array_keys($cart);

                $products = Product::with('images')->whereIn('id', $productIds)->get();

                $cartItems = $products->map(function ($product) use ($cart) {
                    return (object)[
                        'id' => $product->id,
                        'name' => $product->name,
                        'image' => $product->images->first() ?->path,
                        'price' => $product->price,
                        'quantity' => $cart[$product->id]
                    ];
                });

                $total = $cartItems->sum(fn($item) => $item->price * $item->quantity);
            }
        }

        return view('pages.cart.index', compact('cartItems', 'total'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AddCartRequest $request)
    {
        $data = $request->validated();

        $productId = $data['product_id'];
        $quantity = $data['quantity'];

        $user = Auth::user();

        // Nếu chưa đăng nhập → lưu vào session
        if (!$user) {
            $cart = session()->get('cart', []);
            if (isset($cart[$productId])) {
                $cart[$productId] += $quantity;
            } else {
                $cart[$productId] = $quantity;
            }
            session()->put('cart', $cart);

            $totalCount = collect($cart)->sum();

            return ApiResponse::success(
                'Sản phẩm đã được thêm vào giỏ hàng.',
                ['cartCount' => $totalCount],
                null,
                200
            )->toResponse();
        }

        $sessionCart = session()->pull('cart', []);

        foreach ($sessionCart as $productIdFromSession => $qty) {
            $existing = CartItem::where('user_id', $user->id)
                ->where('product_id', $productIdFromSession)
                ->first();

            if ($existing) {
                $existing->increment('quantity', $qty);
            } else {
                CartItem::create([
                    'user_id' => $user->id,
                    'product_id' => $productIdFromSession,
                    'quantity' => $qty,
                ]);
            }
        }

        $cartItem = CartItem::where('user_id', $user->id)
            ->where('product_id', $productId)
            ->first();

        if ($cartItem) {
            $cartItem->increment('quantity', $quantity);
        } else {
            CartItem::create([
                'user_id' => $user->id,
                'product_id' => $productId,
                'quantity' => $quantity,
            ]);
        }

        $totalCount = CartItem::where('user_id', $user->id)->sum('quantity');

        return ApiResponse::success(
            'Sản phẩm đã được thêm vào giỏ hàng.',
            ['cartCount' => $totalCount],
            null,
            200
        )->toResponse();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $quantity = max((int) $request->input('quantity'), 1);
        $user = Auth::user();

        if ($user) {
            // Đã đăng nhập → update trong DB
            $cartItem = CartItem::where('user_id', $user->id)
                ->where('product_id', $id)
                ->first();

            if ($cartItem) {
                $cartItem->update(['quantity' => $quantity]);
            } else {
                // Nếu chưa có, có thể tạo mới (tùy logic bạn muốn)
                CartItem::create([
                    'user_id' => $user->id,
                    'product_id' => $id,
                    'quantity' => $quantity,
                ]);
            }
        } else {
            // Chưa đăng nhập → update trong session
            $cart = session()->get('cart', []);
            if (isset($cart[$id])) {
                $cart[$id] = $quantity;
                session()->put('cart', $cart);
            } else {
                // Có thể thêm mới nếu cần:
                $cart[$id] = $quantity;
                session()->put('cart', $cart);
            }
        }

        return response()->json([
            'message' => 'Cập nhật giỏ hàng thành công.',
            'quantity' => $quantity,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = Auth::user();

        if ($user) {
            CartItem::where('user_id', $user->id)->where('product_id', $id)->delete();
            $cartCount = CartItem::where('user_id', $user->id)->count();
        } else {
            $cart = session()->get('cart', []);
            unset($cart[$id]);
            session()->put('cart', $cart);
            $cartCount = count($cart);
        }

        return response()->json([
            'message' => 'Đã xoá sản phẩm',
            'cartCount' => $cartCount,
        ]);
    }

}
