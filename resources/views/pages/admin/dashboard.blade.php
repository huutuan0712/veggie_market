@extends('layouts.app')

@section('content')
    <div class="min-h-screen py-20 bg-gradient-to-br from-orange-50 via-white to-green-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Header --}}
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h1 class="text-3xl lg:text-4xl font-bold text-gray-900">
                        Dashboard Quản trị
                    </h1>
                    <p class="text-gray-600 mt-2">
                        Chào mừng trở lại, {{ auth()->user()->name }}
                    </p>
                </div>
                <a href="{{ url('/') }}"
                   class="inline-flex items-center space-x-2 text-gray-600 hover:text-orange-600 transition-colors">
                    <x-heroicon-o-arrow-left class="h-5 w-5"/>
                    <span>Về trang chủ</span>
                </a>
            </div>

            {{-- Navigation Tabs --}}
            <div class="mb-8">
                <div class="border-b border-gray-200">
                    <nav class="flex space-x-8">
                        @php
                            $activeTab = request('tab', 'overview');

                            $tabs = [
                                ['id' => 'overview', 'label' => 'Tổng quan', 'icon' => 'bar-chart-3'],
                                ['id' => 'products', 'label' => 'Sản phẩm', 'icon' => 'package'],
                                ['id' => 'categories', 'label' => 'Danh mục', 'icon' => 'funnel'],
                                ['id' => 'orders', 'label' => 'Đơn hàng', 'icon' => 'shopping-cart'],
                                ['id' => 'users', 'label' => 'Khách hàng', 'icon' => 'users'],
                            ];

                        @endphp

                        @foreach ($tabs as $tab)
                            <a href="{{ request()->fullUrlWithQuery(['tab' => $tab['id']]) }}"
                               class="flex items-center space-x-2 py-4 px-2 border-b-2 font-medium text-sm transition-colors
                                {{ $activeTab === $tab['id'] ? 'border-orange-500 text-orange-600' : 'border-transparent text-gray-500 hover:text-gray-700' }}">

                                {{-- Icons --}}
                                @switch($tab['icon'])
                                    @case('bar-chart-3')
                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                         viewBox="0 0 24 24"
                                         stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M3 3v18h18M9 17V9m4 8V5m4 8v-2"/>
                                    </svg>
                                    @break

                                    @case('package')
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                         stroke-linejoin="round"
                                         class="icon icon-tabler icons-tabler-outline icon-tabler-package">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <path d="M12 3l8 4.5l0 9l-8 4.5l-8 -4.5l0 -9l8 -4.5"/>
                                        <path d="M12 12l8 -4.5"/>
                                        <path d="M12 12l0 9"/>
                                        <path d="M12 12l-8 -4.5"/>
                                        <path d="M16 5.25l-8 4.5"/>
                                    </svg>
                                    @break

                                    @case('funnel')
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                         stroke-linejoin="round"
                                         class="icon icon-tabler icons-tabler-outline icon-tabler-filter">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <path
                                            d="M4 4h16v2.172a2 2 0 0 1 -.586 1.414l-4.414 4.414v7l-6 2v-8.5l-4.48 -4.928a2 2 0 0 1 -.52 -1.345v-2.227z"/>
                                    </svg>
                                    @break

                                    @case('shopping-cart')
                                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                         viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"
                                         data-slot="icon">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z"></path>
                                    </svg>
                                    @break

                                    @case('users')
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                         stroke-linejoin="round"
                                         class="icon icon-tabler icons-tabler-outline icon-tabler-users">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"/>
                                        <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"/>
                                        <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                                        <path d="M21 21v-2a4 4 0 0 0 -3 -3.85"/>
                                    </svg>
                                    @break
                                @endswitch

                                <span>{{ $tab['label'] }}</span>
                            </a>
                        @endforeach
                    </nav>
                </div>
            </div>

            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-2xl mb-6">
                    {{ session('success') }}
                </div>
            @endif

            @if ($activeTab === 'overview')
                <div class="space-y-8">
                    {{-- Stats Cards --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        {{-- Tổng sản phẩm --}}
                        <div class="bg-white rounded-3xl shadow-lg p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-gray-600 text-sm">Tổng sản phẩm</p>
                                    <p class="text-3xl font-bold text-gray-900">{{ $stats['totalProducts'] }}</p>
                                </div>
                                <div class="bg-blue-100 p-3 rounded-2xl">
                                    {{-- Heroicon: Package --}}
                                    <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M3 7.5L12 3l9 4.5M3 7.5v9l9 4.5m0-13.5l9-4.5m-9 4.5v13.5m9-13.5v9l-9 4.5" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        {{-- Tổng đơn hàng --}}
                        <div class="bg-white rounded-3xl shadow-lg p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-gray-600 text-sm">Tổng đơn hàng</p>
                                    <p class="text-3xl font-bold text-gray-900">{{ $stats['totalOrders'] }}</p>
                                </div>
                                <div class="bg-green-100 p-3 rounded-2xl">
                                    {{-- Heroicon: Shopping Cart --}}
                                    <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M2.25 3h1.5l1.5 9h12l1.5-6h-15m3 9a1.5 1.5 0 110 3 1.5 1.5 0 010-3zm9 0a1.5 1.5 0 110 3 1.5 1.5 0 010-3z" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        {{-- Doanh thu --}}
                        <div class="bg-white rounded-3xl shadow-lg p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-gray-600 text-sm">Doanh thu</p>
                                    <p class="text-3xl font-bold text-gray-900">
                                        {{ number_format($stats['totalRevenue']) }}đ
                                    </p>
                                </div>
                                <div class="bg-orange-100 p-3 rounded-2xl">
                                    {{-- Heroicon: Dollar Sign --}}
                                    <svg class="h-6 w-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M12 3v18m0 0a4.5 4.5 0 004.5-4.5v-.75a1.5 1.5 0 00-1.5-1.5H9a1.5 1.5 0 01-1.5-1.5V9A4.5 4.5 0 0112 4.5" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        {{-- Tăng trưởng --}}
                        <div class="bg-white rounded-3xl shadow-lg p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-gray-600 text-sm">Tăng trưởng</p>
                                    <p class="text-3xl font-bold text-gray-900">+{{ $stats['monthlyGrowth'] }}%</p>
                                </div>
                                <div class="bg-purple-100 p-3 rounded-2xl">
                                    {{-- Heroicon: Trending Up --}}
                                    <svg class="h-6 w-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M3 17l6-6 4 4 8-8" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Recent Orders --}}
                    <div class="bg-white rounded-3xl shadow-lg p-8">
                        <h3 class="text-xl font-bold text-gray-900 mb-6">Đơn hàng gần đây</h3>
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead>
                                <tr class="border-b border-gray-200">
                                    <th class="text-left py-3 px-4 font-semibold text-gray-900">Mã đơn</th>
                                    <th class="text-left py-3 px-4 font-semibold text-gray-900">Khách hàng</th>
                                    <th class="text-left py-3 px-4 font-semibold text-gray-900">Ngày</th>
                                    <th class="text-left py-3 px-4 font-semibold text-gray-900">Trạng thái</th>
                                    <th class="text-left py-3 px-4 font-semibold text-gray-900">Tổng tiền</th>
                                    <th class="text-left py-3 px-4 font-semibold text-gray-900">Thao tác</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($recentOrders as $order)
                                    <tr class="border-b border-gray-100">
                                        <td class="py-4 px-4 font-medium text-gray-900">#{{ $order->id }}</td>
                                        <td class="py-4 px-4 text-gray-600">{{ $order->customer }}</td>
                                        <td class="py-4 px-4 text-gray-600">{{ $order->date }}</td>
                                        <td class="py-4 px-4">
                                                    <span class="px-3 py-1 rounded-full text-sm font-medium {{ getStatusColor($order->status) }}">
                                                        {{ $order->status }}
                                                    </span>
                                        </td>
                                        <td class="py-4 px-4 font-semibold text-gray-900">
                                            {{ number_format($order->total) }}đ
                                        </td>
                                        <td class="py-4 px-4">
                                            <a href="#"
                                               class="text-orange-600 hover:text-orange-700 transition-colors">
                                                {{-- Heroicon: Eye --}}
                                                <x-heroicon-o-eye class="w-5 h-5" />
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif

            @if ($activeTab === 'products')
                <div class="space-y-6">
                    {{-- Products Header --}}
                    <form method="GET" action="{{ request()->url() }}" class="mb-8">
                        <div class="flex flex-col lg:flex-row gap-4 items-center justify-between">
                            <div class="flex flex-col sm:flex-row gap-4 flex-1">
                                    {{-- Search --}}
                                    <div class="relative flex-1 max-w-md">
                                        <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M11 18a7 7 0 100-14 7 7 0 000 14z"/>
                                        </svg>
                                        <input type="hidden" name="tab" value="{{ request('tab', $activeTab) }}">
                                        <input
                                            type="text"
                                            name="search"
                                            value="{{ request('search') }}"
                                            placeholder="Tìm kiếm trái cây..."
                                            class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-2xl focus:ring-2 focus:ring-orange-500"
                                        />
                                    </div>

                                    {{-- Category filter --}}
                                    <select
                                        name="category"
                                        class="px-4 py-3 border border-gray-200 rounded-2xl focus:ring-2 focus:ring-orange-500"
                                        onchange="this.form.submit()"
                                    >
                                        <option value="tat-ca" @selected($selectedCategory === 'tat-ca')>Tất cả</option>
                                        @foreach($categories as $cat)
                                            <option value="{{ $cat->slug }}" @selected($selectedCategory === $cat->slug)>
                                                {{ $cat->name }}
                                            </option>
                                        @endforeach
                                    </select>
                            </div>

                            {{-- Add Product Button --}}
                            <a href="{{ route('products.create') }}"
                               class="bg-gradient-to-r from-orange-500 to-red-500 text-white px-6 py-3 rounded-2xl font-semibold hover:from-orange-600 hover:to-red-600 transition-all duration-300 flex items-center space-x-2">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                                </svg>
                                <span>Thêm sản phẩm</span>
                            </a>
                        </div>
                    </form>

                    {{-- Products Table --}}
                    <div class="bg-white rounded-3xl shadow-lg overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead class="bg-gray-50">
                                <tr>
                                    <th class="text-left py-4 px-6 font-semibold text-gray-900">Sản phẩm</th>
                                    <th class="text-left py-4 px-6 font-semibold text-gray-900">Danh mục</th>
                                    <th class="text-left py-4 px-6 font-semibold text-gray-900">Giá</th>
                                    <th class="text-left py-4 px-6 font-semibold text-gray-900">Trạng thái</th>
                                    <th class="text-left py-4 px-6 font-semibold text-gray-900">Thao tác</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse ($products->data as $product)
                                    @php
                                        $inStock = $product->status === \App\Enums\ProductStatus::IN_STOCK;
                                        $image = is_array($product->images) && count($product->images) > 0
                                                ? asset('storage/' . $product->images[0]['path'])
                                                : 'https://via.placeholder.com/300x200?text=No+Image';
                                    @endphp
                                    <tr class="border-b border-gray-100">
                                        <td class="py-4 px-6">
                                            <div class="flex items-center space-x-4">
                                                <img src="{{ $image }}" alt="{{ $product->name }}" class="w-12 h-12 object-cover rounded-xl" />
                                                <div>
                                                    <div class="font-semibold text-gray-900">{{ $product->name }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-4 px-6 text-gray-600">{{ $product->category->name }}</td>
                                        <td class="py-4 px-6">
                                            <div class="font-semibold text-gray-900">{{ number_format($product->price) }}đ</div>
                                            @if ($product->original_price)
                                                <div class="text-sm text-gray-400 line-through">
                                                    {{ number_format($product->original_price) }}đ
                                                </div>
                                            @endif
                                        </td>
                                        <td class="py-4 px-6">
                                    <span class="px-3 py-1 rounded-full text-sm font-medium
                                        {{ $inStock ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $inStock ? 'Còn hàng' : 'Hết hàng' }}
                                    </span>
                                        </td>
                                        <td class="py-4 px-6">
                                            <div class="flex items-center space-x-2">
                                                <a href="{{ route('products.edit', $product->id) }}"
                                                   class="text-orange-600 hover:text-orange-700 transition-colors cursor-pointer">
                                                    {{-- Edit Icon --}}
                                                    <x-heroicon-o-pencil-square class="w-5 h-5" />
                                                </a>
                                                <button
                                                    type="button"
                                                    data-product-btn
                                                    data-product-id="{{ $product->id }}"
                                                    class="text-red-600 hover:text-red-700 transition-colors cursor-pointer"
                                                >
                                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-6 text-gray-500">Không có sản phẩm nào.</td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>

                            <!-- Modal xóa -->
                            <div id="deleteProductModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm hidden items-center justify-center z-50">
                            <div class="bg-white rounded-xl p-6 w-full max-w-sm text-center shadow-xl">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Xác nhận xóa?</h3>
                                    <p class="text-gray-600 mb-6">Bạn có chắc chắn muốn xóa sản phẩm này?</p>
                                    <form id="deleteProductForm" method="POST" action="">
                                        @csrf
                                        @method('DELETE')
                                        <div class="flex justify-center space-x-3">
                                            <button type="button" id="btn-close-product" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">Hủy</button>
                                            <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Xóa</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if ($products->meta['last_page'] > 1)
                        <x-pagination :meta="$products->meta" />
                    @endif
                </div>
            @endif
            {{-- Danh sách danh mục --}}
            @if ($activeTab === 'categories')
                <div class="space-y-6">
                    <form method="GET" action="{{ request()->url() }}" class="mb-8" id="filterForm">
                        <div class="flex flex-col lg:flex-row gap-4 items-center justify-between">
                            <div class="flex flex-col sm:flex-row gap-4 flex-1">
                                {{-- Search --}}
                                <div class="relative flex-1 max-w-md">
                                    <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M11 18a7 7 0 100-14 7 7 0 000 14z"/>
                                    </svg>
                                    <input type="hidden" name="tab" value="{{ request('tab', $activeTab) }}">
                                    <input
                                        type="text"
                                        name="search"
                                        value="{{ request('search') }}"
                                        placeholder="Tìm kiếm danh mục..."
                                        class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-2xl focus:ring-2 focus:ring-orange-500"
                                    />
                                </div>

                                {{-- Category filter --}}
                                <select
                                    name="category"
                                    onchange="this.form.submit()"
                                    class="px-4 py-3 border border-gray-200 rounded-2xl focus:ring-2 focus:ring-orange-500"
                                >
                                    <option value="tat-ca" {{ $selectedCategory === 'tat-ca' ? 'selected' : '' }}>Tất cả</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->slug }}" {{ $selectedCategory === $cat->slug ? 'selected' : '' }}>
                                            {{ $cat->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Add Category Button --}}
                            <a href="{{ route('categories.create') }}"
                               class="bg-gradient-to-r from-orange-500 to-red-500 text-white px-6 py-3 rounded-2xl font-semibold hover:from-orange-600 hover:to-red-600 transition-all duration-300 flex items-center space-x-2">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                                </svg>
                                <span>Thêm danh mục</span>
                            </a>
                        </div>
                    </form>

                    <div class="bg-white rounded-3xl shadow-lg overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead class="bg-gray-50">
                                <tr>
                                    <th class="text-left py-4 px-6 font-semibold text-gray-900">Tên danh mục</th>
                                    <th class="text-left py-4 px-6 font-semibold text-gray-900">Slug</th>
                                    <th class="text-left py-4 px-6 font-semibold text-gray-900">Mô tả</th>
                                    <th class="text-left py-4 px-6 font-semibold text-gray-900">Thao tác</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse ($categoriesList->data as $category)
                                    <tr class="border-b border-gray-100">
                                        <td class="py-4 px-6 text-gray-900 font-medium">{{ $category->name }}</td>
                                        <td class="py-4 px-6 text-gray-700">{{ $category->slug }}</td>
                                        <td class="py-4 px-6 text-gray-600">{{ $category->description ?? '-' }}</td>
                                        <td class="py-4 px-6">
                                            <div class="flex items-center space-x-2">
                                                <a href="{{ route('categories.edit', $category->id) }}"
                                                   class="text-orange-600 hover:text-orange-700 transition-colors">
                                                    <x-heroicon-o-pencil-square class="w-5 h-5" />
                                                </a>
                                                <button type="button"
                                                        data-category-btn
                                                        data-category-id="{{ $category->id }}"
                                                        class="text-red-600 hover:text-red-700 transition-colors">
                                                    <svg class="h-5 w-5" fill="none" stroke="currentColor"
                                                         viewBox="0 0 24 24" stroke-width="1.5">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                              d="M6 18L18 6M6 6l12 12"/>
                                                    </svg>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-6 text-gray-500">Không có danh mục nào.
                                        </td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>

                        @if ($categoriesList->meta['last_page'] > 1)
                            <x-pagination :meta="$categoriesList->meta" />
                        @endif
                        <div id="deleteCategoryModal"
                             class="fixed inset-0 bg-black/50 backdrop-blur-sm hidden z-50 flex items-center justify-center">
                            <div class="bg-white rounded-xl p-6 w-full max-w-sm text-center shadow-xl max-h-[90vh] overflow-y-auto">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Xác nhận xóa?</h3>
                                <p class="text-gray-600 mb-6">Bạn có chắc chắn muốn xóa danh mục này?</p>
                                <form id="deleteCategoryForm" method="POST" action="">
                                    @csrf
                                    @method('DELETE')
                                    <div class="flex justify-center space-x-3">
                                        <button type="button" id="btn-close-category"
                                                class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">Hủy
                                        </button>
                                        <button type="submit"
                                                class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Xóa
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if($activeTab === 'orders')
                <div class="space-y-6">
                    {{-- Orders Header --}}
                    <div class="flex flex-col lg:flex-row gap-4 items-center justify-between">
                        <h2 class="text-2xl font-bold text-gray-900">Quản lý đơn hàng</h2>
                        <div class="flex flex-col sm:flex-row gap-4 items-center">
                            <form method="GET" action="{{ request()->url() }}" class="relative">
                                <x-heroicon-o-magnifying-glass class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 h-5 w-5" />
                                <input
                                    type="text"
                                    name="search"
                                    placeholder="Tìm kiếm đơn hàng..."
                                    value="{{ request('search') }}"
                                    class="pl-10 pr-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                                />
                                <input type="hidden" name="tab" value="{{ request('tab', $activeTab) }}">

                                <select
                                    name="status"
                                    onchange="this.form.submit()"
                                    class="px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent bg-white"
                                >
                                    <option value="all">Tất cả trạng thái</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Chờ xử lý</option>
                                    <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Đã xác nhận</option>
                                    <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Đang xử lý</option>
                                    <option value="shipping" {{ request('status') == 'shipping' ? 'selected' : '' }}>Đang giao</option>
                                    <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Đã giao</option>
                                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
                                </select>
                            </form>

                            <a href="{{ route('orders.export') }}" class="bg-green-500 text-white px-4 py-2 rounded-xl hover:bg-green-600 transition-colors flex items-center space-x-2">
                                <x-heroicon-o-arrow-down-tray class="w-4 h-4" />
                                <span>Xuất Excel</span>
                            </a>
                        </div>
                    </div>

                    {{-- Orders Table --}}
                    <div class="bg-white rounded-3xl shadow-lg overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead class="bg-gray-50">
                                <tr>
                                    <th class="text-left py-4 px-6 font-semibold text-gray-900">Mã đơn</th>
                                    <th class="text-left py-4 px-6 font-semibold text-gray-900">Khách hàng</th>
                                    <th class="text-left py-4 px-6 font-semibold text-gray-900">Ngày đặt</th>
                                    <th class="text-left py-4 px-6 font-semibold text-gray-900">Sản phẩm</th>
                                    <th class="text-left py-4 px-6 font-semibold text-gray-900">Trạng thái</th>
                                    <th class="text-left py-4 px-6 font-semibold text-gray-900">Tổng tiền</th>
                                    <th class="text-left py-4 px-6 font-semibold text-gray-900">Thao tác</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($orders as $order)
                                    <tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors">
                                        <td class="py-4 px-6 font-medium text-gray-900">#{{ $order->id }}</td>
                                        <td class="py-4 px-6">
                                            <div class="flex items-center space-x-3">
                                                <img src="{{ $order->customer->avatar }}" alt="{{ $order->customer->name }}" class="w-8 h-8 rounded-full object-cover" />
                                                <div>
                                                    <div class="font-medium text-gray-900">{{ $order->customer->name }}</div>
                                                    <div class="text-sm text-gray-600">{{ $order->customer->email }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-4 px-6 text-gray-600">
                                            <div>{{ $order->date->format('d/m/Y') }}</div>
                                            <div class="text-sm text-gray-500">{{ $order->date->format('H:i') }}</div>
                                        </td>
                                        <td class="py-4 px-6 text-gray-600">{{ count($order->items) }} sản phẩm</td>
                                        <td class="py-4 px-6">
{{--                                          <span class="inline-flex items-center space-x-1 px-3 py-1 rounded-full text-sm font-medium {{ getStatusColor($order->status) }}">--}}
{{--                                            {!! getStatusIcon($order->status) !!}--}}
{{--                                            <span>{{ getStatusText($order->status) }}</span>--}}
{{--                                          </span>--}}
                                        </td>
                                        <td class="py-4 px-6 font-semibold text-gray-900">
                                            {{ number_format($order->total) }}đ
                                        </td>
                                        <td class="py-4 px-6">
                                            <div class="flex items-center space-x-2">
                                                <a href="{{ route('orders.show', $order->id) }}" class="text-blue-600 hover:text-blue-700 transition-colors" title="Xem chi tiết">
                                                    <x-heroicon-o-eye class="w-5 h-5" />
                                                </a>
                                                <a href="{{ route('orders.edit', $order->id) }}" class="text-orange-600 hover:text-orange-700 transition-colors" title="Chỉnh sửa">
                                                    <x-heroicon-o-pencil-square class="w-5 h-5" />
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>
@endsection
@push('scripts')
    @vite(['resources/assets/js/dashboard.js'])
@endpush
