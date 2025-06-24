<?php

namespace App\Http\Controllers;

use App\Http\Requests\Cart\AddCartRequest;
use App\Http\Responses\ApiResponse;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fake cart items as a collection
        $cartItems = collect([
            (object)[
                'id' => 1,
                'name' => 'Xoài Hòa Lộc',
                'image' => 'https://images.pexels.com/photos/2294471/pexels-photo-2294471.jpeg?auto=compress&cs=tinysrgb&w=400',
                'price' => 50000,
                'quantity' => 2,
            ],
            (object)[
                'id' => 2,
                'name' => 'Dâu tây Đà Lạt',
                'image' => 'https://images.pexels.com/photos/1125328/pexels-photo-1125328.jpeg?auto=compress&cs=tinysrgb&w=400',
                'price' => 80000,
                'quantity' => 1,
            ],
        ]);

        $total = $cartItems->sum(fn($item) => $item->price * $item->quantity);

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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
