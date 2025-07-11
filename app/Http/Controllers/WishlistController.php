<?php

namespace App\Http\Controllers;

use App\Services\WishlistService;
use App\Services\ProductService;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function __construct(
        protected ProductService $productService,
        protected WishlistService $wishListService
    ) {}

    public function index()
    {
        $products = $this->wishListService->getWishlistItems();

        return view('pages.wishlist.index', compact('products'));
    }

    public function toggle(Request $request)
    {
        $result = $this->wishListService->toggle($request->input('product_id'));
        return response()->json($result);
    }

    public function updateQuantity(Request $request)
    {
        $result = $this->wishListService->updateQuantity(
            $request->input('product_id'),
            (int) $request->input('quantity')
        );
        return response()->json($result);
    }

    public function delete(string $productId)
    {
        $result = $this->wishListService->destroy($productId);
        return response()->json($result);
    }
}
