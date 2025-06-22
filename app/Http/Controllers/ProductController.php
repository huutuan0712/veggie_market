<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $products = collect([
            (object)[
                'id' => 1,
                'name' => 'Xoài Hòa Lộc',
                'category' => 'Xoài',
                'image' => 'https://images.pexels.com/photos/2294471/pexels-photo-2294471.jpeg?auto=compress&cs=tinysrgb&w=400',
                'description' => 'Xoài ngọt thơm tự nhiên, được trồng tại Tiền Giang.',
                'price' => 50000,
                'originalPrice' => 60000,
                'inStock' => true,
            ],
            (object)[
                'id' => 2,
                'name' => 'Dâu tây Đà Lạt',
                'category' => 'Dâu',
                'image' => 'https://images.pexels.com/photos/1125328/pexels-photo-1125328.jpeg?auto=compress&cs=tinysrgb&w=400',
                'description' => 'Dâu tây tươi, sạch, giàu vitamin C.',
                'price' => 80000,
                'originalPrice' => null,
                'inStock' => false,
            ],
            // Add more fake products here
        ]);

        $categories = ['Tất cả', 'Xoài', 'Dâu', 'Cam', 'Chuối'];

        $searchTerm = $request->get('search');
        $selectedCategory = $request->get('category');

        $filtered = $products->filter(function ($product) use ($searchTerm, $selectedCategory) {
            return (!$searchTerm || str_contains(strtolower($product->name), strtolower($searchTerm)))
                && ($selectedCategory === 'Tất cả' || !$selectedCategory || $product->category === $selectedCategory);
        });

        return view('pages.product.index', [
            'products' => $filtered,
            'categories' => $categories,
            'searchTerm' => $searchTerm,
            'selectedCategory' => $selectedCategory
        ]);
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
        $product = [
            'id' => $id,
            'name' => 'Xoài Hòa Lộc',
            'category' => 'Trái cây nhiệt đới',
            'image' => 'https://images.pexels.com/photos/2294471/pexels-photo-2294471.jpeg?auto=compress&cs=tinysrgb&w=400',
            'price' => 50000,
            'originalPrice' => 65000,
            'description' => 'Xoài Hòa Lộc là loại xoài nổi tiếng với vị ngọt thanh, thơm dịu và ít xơ.',
            'origin' => 'Tiền Giang, Việt Nam',
            'inStock' => true,
            'benefits' => [
                'Tốt cho hệ tiêu hóa',
                'Giàu vitamin C',
                'Tăng cường miễn dịch',
                'Làm đẹp da',
            ],
        ];

        return view('pages.product.show', compact('product'));
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
