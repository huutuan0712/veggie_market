<?php

namespace App\Http\Controllers;

use App\DTOs\Product\Product as ProductDTO;
use App\Http\Requests\Product\StoreProductFormRequest;
use App\Http\Requests\Product\UpdateProductFormRequest;
use App\Services\CategoryService;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(
        protected ProductService $productService,
        protected CategoryService $categoryService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $params = [
            'search' => $request->get('search'),
            'page' => $request->get('page', 1),
            'per_page' => 12,
            'sort_by' => 'name',
            'sort_direction' => 'asc',
        ];

        $selectedCategory = 'tat-ca';

        if ($request->filled('category') && $request->get('category') !== 'tat-ca') {
            $params['category'] = $request->get('category');
            $selectedCategory = $params['category'];
        }

        $products = $this->productService->getPaginatedList($params);
        $categories = $this->categoryService->getAll();

        return view('pages.product.index', [
            'products' => $products,
            'categories' => $categories,
            'selectedCategory' => $selectedCategory
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = $this->categoryService->getAll();

        return view('pages.product.create-or-update', compact(
            'categories'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductFormRequest $request)
    {
        $dto = ProductDTO::fromRequest($request->validated());
        $this->productService->createDTO($dto);

        return redirect()->route('dashboard', ['tab' => 'products'])->with('success', 'Tạo sản phẩm thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id, Request $request)
    {
        $product = $this->productService->getProductWithRelations($id);
        $activeTab = $request->query('tab', 'description');
        $reviews = [
            [
                'id' => 1,
                'userName' => 'Nguyễn Thị Mai',
                'userAvatar' => 'https://images.pexels.com/photos/1239291/pexels-photo-1239291.jpeg?auto=compress&cs=tinysrgb&w=100',
                'rating' => 5,
                'date' => '2024-01-15',
                'comment' => 'Xoài rất ngon, ngọt và thơm. Đóng gói cẩn thận, giao hàng nhanh. Sẽ mua lại!',
                'helpful' => 12,
                'images' => [
                    'https://images.pexels.com/photos/2294471/pexels-photo-2294471.jpeg?auto=compress&cs=tinysrgb&w=200',
                ],
            ],
            [
                'id' => 2,
                'userName' => 'Trần Văn Nam',
                'userAvatar' => 'https://images.pexels.com/photos/1222271/pexels-photo-1222271.jpeg?auto=compress&cs=tinysrgb&w=100',
                'rating' => 4,
                'date' => '2024-01-10',
                'comment' => 'Chất lượng tốt, giá hợp lý. Chỉ có điều một vài quả hơi nhỏ.',
                'helpful' => 8,
            ],
            [
                'id' => 3,
                'userName' => 'Lê Thị Hoa',
                'userAvatar' => 'https://images.pexels.com/photos/1130626/pexels-photo-1130626.jpeg?auto=compress&cs=tinysrgb&w=100',
                'rating' => 5,
                'date' => '2024-01-05',
                'comment' => 'Tuyệt vời! Xoài rất tươi và ngọt. Shop đóng gói rất đẹp.',
                'helpful' => 15,
            ],
        ];
        $averageRating = collect($reviews)->avg('rating');

        $ratingDistribution = collect([5, 4, 3, 2, 1])->map(function ($rating) use ($reviews) {
            $count = collect($reviews)->where('rating', $rating)->count();
            $percentage = $count > 0 ? ($count / count($reviews)) * 100 : 0;
            return [
                'rating' => $rating,
                'count' => $count,
                'percentage' => $percentage,
            ];
        });


        return view('pages.product.show', compact(
            'product',
            'activeTab',
            'reviews',
            'averageRating',
            'ratingDistribution'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = $this->productService->getProductWithRelations($id);
        $categories = $this->categoryService->getAll();

        return view('pages.product.create-or-update', compact(
            'product',
            'categories'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductFormRequest $request, string $id)
    {
        $dto = ProductDTO::fromRequest($request->validated());
        $this->productService->updateDTO($id, $dto);

        return redirect()->route('dashboard', ['tab' => 'products'])->with('success', 'Cập nhật sản phẩm thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->productService->delete($id);
        return redirect()->route('dashboard', ['tab' => 'products'])->with('success', 'Xóa sản phẩm thành công!');
    }
}
