<?php

namespace App\Http\Controllers;

use App\DTOs\Product\Product;
use App\Services\ProductService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct(
        protected ProductService $productService
    ) {}

    public function index ()
    {
        $featuredProducts = $this->productService->where('featured', 1)->with('images')->get();
        return view('pages.home', compact('featuredProducts'));
    }
}
