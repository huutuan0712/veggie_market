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
    protected $productService;

    protected $categoryService;

    public function __construct(ProductService $productService, CategoryService $categoryService)
    {
        $this->productService = $productService;
        $this->categoryService = $categoryService;
    }

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

        $selectedCategory = 'Tất cả';

        if ($request->filled('category') && $request->get('category') !== 'Tất cả') {
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
        return view('admin.product.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductFormRequest $request)
    {
        $dto = ProductDTO::fromRequest($request->validated());
        $this->productService->createDTO($dto);

        return redirect()->route('admin.product.index')->with('success', 'Tạo sản phẩm thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = $this->productService->getProductWithRelations($id);

        return view('pages.product.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = $this->productService->getProductWithRelations($id);

        return view('admin.product.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductFormRequest $request, string $id)
    {
        $dto = ProductDTO::fromRequest($request->validated());
        $this->productService->updateDTO($id, $dto);

        return redirect()->route('admin.product.index')->with('success', 'Cật nhật sản phẩm thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->productService->delete($id);
        return redirect()->route('admin.product.index')->with('success', 'Xóa sản phẩm thành công!');
    }
}
