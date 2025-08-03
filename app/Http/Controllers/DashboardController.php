<?php

namespace App\Http\Controllers;

use App\Models\Voucher;
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

        $categoriesList = $this->categoryService->getPaginatedList($params);

        $orders = collect([
            (object)[
                'id' => 1001,
                'customer' => (object)[
                    'name' => 'Nguyễn Văn A',
                    'email' => 'nguyenvana@example.com',
                    'avatar' => 'https://i.pravatar.cc/80?img=1',
                ],
                'date' => now()->subDays(1),
                'status' => 'processing',
                'total' => 250000,
                'items' => [
                    ['name' => 'Sản phẩm A', 'quantity' => 1],
                    ['name' => 'Sản phẩm B', 'quantity' => 2],
                ]
            ],
            (object)[
                'id' => 1002,
                'customer' => (object)[
                    'name' => 'Trần Thị B',
                    'email' => 'tranthib@example.com',
                    'avatar' => 'https://i.pravatar.cc/80?img=2',
                ],
                'date' => now()->subDays(2),
                'status' => 'delivered',
                'total' => 185000,
                'items' => [
                    ['name' => 'Sản phẩm C', 'quantity' => 1],
                ]
            ],
            (object)[
                'id' => 1003,
                'customer' => (object)[
                    'name' => 'Phạm Văn C',
                    'email' => 'phamvanc@example.com',
                    'avatar' => 'https://i.pravatar.cc/80?img=3',
                ],
                'date' => now()->subDays(3),
                'status' => 'cancelled',
                'total' => 0,
                'items' => []
            ],
        ]);


        $search = $request->input('search');
        $status = $request->input('status', 'all');
        $type = $request->input('type', 'all');

        $vouchers = Voucher::query()
            ->when($search, fn($q) => $q->where('name', 'like', "%$search%")->orWhere('code', 'like', "%$search%"))
            ->when($status !== 'all', fn($q) => $q->where('is_active', $status === 'active'))
            ->when($status === 'expired', fn($q) => $q->where('expires_at', '<', now()))
            ->when($type !== 'all', fn($q) => $q->where('type', $type))
            ->latest()
            ->get();

        return view('pages.admin.dashboard', compact(
            'stats',
            'recentOrders',
            'categories',
            'categoriesList',
            'products',
            'selectedCategory',
            'orders',
            'vouchers',
            'search', 'status', 'type'
        ));
    }

}
