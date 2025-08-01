<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Kjmtrue\VietnamZone\Models\Province;

class CheckOutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user_id = Auth::id();
        $user = User::with('shippingAddress')->find($user_id);
        $cartItems = CartItem::with('product.images')
            ->where('user_id', $user_id)
            ->get();

        $subtotal = $cartItems->sum(function ($item) {
            return $item->quantity * $item->product->price;
        });

        $shippingFee = 0; // Free shipping
        $total = $subtotal + $shippingFee;
        $discountAmount = 0;
        $provinces = Province::get();

        return view('pages.checkout.index', compact('cartItems', 'subtotal', 'shippingFee', 'discountAmount', 'total', 'user', 'provinces'));
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
    public function store(Request $request)
    {
        //
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
