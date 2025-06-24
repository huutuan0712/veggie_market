<?php

namespace App\Http\Controllers;

use App\Services\CategoryService;
use App\Services\ProductService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected $categoryService;
    protected $productService;

    public function __construct(CategoryService $categoryService, ProductService $productService)
    {
        $this->categoryService = $categoryService;
        $this->productService = $productService;
    }

    public function index(Request $request)
    {
        $stats = [
            'totalProducts' => 124,
            'totalOrders' => 89,
            'totalRevenue' => 15320000,
            'monthlyGrowth' => 12.5,
        ];

        $recentOrders = [
            (object)[
                'id' => 1001,
                'customer' => 'Nguyễn Văn A',
                'date' => '2025-06-22',
                'status' => 'Đang xử lý',
                'total' => 250000,
            ],
            (object)[
                'id' => 1002,
                'customer' => 'Trần Thị B',
                'date' => '2025-06-21',
                'status' => 'Đã giao',
                'total' => 185000,
            ],
            (object)[
                'id' => 1003,
                'customer' => 'Phạm Văn C',
                'date' => '2025-06-20',
                'status' => 'Đã hủy',
                'total' => 0,
            ],
        ];
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

        return view('pages.admin.dashboard', compact(
            'stats',
            'recentOrders',
            'categories',
            'products',
            'selectedCategory'
        ));
    }

}
