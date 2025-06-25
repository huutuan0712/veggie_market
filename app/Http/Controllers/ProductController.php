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

        return view('pages.product.show', compact('product', 'activeTab'));
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
