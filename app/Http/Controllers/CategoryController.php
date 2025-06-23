<?php

namespace App\Http\Controllers;

use App\DTOs\Category\Category as CategoryDTO;
use App\Http\Requests\Category\StoreCategoryFormRequest;
use App\Http\Requests\Category\UpdateCategoryFormRequest;
use App\Services\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.categories.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryFormRequest $request)
    {
        $dto = CategoryDTO::fromRequest($request->validated());
        $this->categoryService->createDTO($dto);

        return redirect()->route('admin.categories.index')->with('success', 'Tạo danh mục thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = $this->categoryService->getCategoryWithRelations($id);

        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryFormRequest $request, string $id)
    {
        $dto = CategoryDTO::fromRequest($request->validated());
        $this->categoryService->updateDTO($id, $dto);

        return redirect()->route('admin.categories.index')->with('success', 'Cập nhật danh mục thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->categoryService->delete($id);
        return redirect()->route('admin.categories.index')->with('success', 'Xóa danh mục thành công!');
    }
}
