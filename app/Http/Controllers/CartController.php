<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
