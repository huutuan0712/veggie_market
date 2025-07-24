@extends('layouts.app')

@section('content')
    <div class="min-h-screen py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-10">
            @if(empty($products))
                <div class="text-center py-20">
                    <x-heroicon-o-heart class="h-24 w-24 text-gray-300 mx-auto mb-6" />

                    <h2 class="text-3xl font-bold text-gray-900 mb-4">
                        Chưa có sản phẩm yêu thích
                    </h2>
                    <p class="text-gray-600 mb-8">
                        Hãy thêm những trái cây yêu thích vào danh sách để dễ dàng tìm lại
                    </p>

                    <a href="{{ route('products.index') }}"
                       class="bg-gradient-to-r from-orange-500 to-red-500 text-white px-8 py-4 rounded-2xl font-semibold hover:from-orange-600 hover:to-red-600 transition-all duration-300 inline-flex items-center space-x-2">
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
                        <span>Khám phá sản phẩm</span>
                    </a>
                </div>
                @else
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h1 class="text-3xl lg:text-4xl font-bold text-gray-900">Danh sách yêu thích</h1>
                    </div>
                    <a href="{{ route('products.index') }}" class="inline-flex items-center space-x-2 text-gray-600 hover:text-orange-600 transition-colors">
                        <x-heroicon-o-arrow-left class="w-6 h-6 text-gray-500" />
                        <span>Tiếp tục mua sắm</span>
                    </a>
                </div>
                <div class="bg-white rounded-3xl shadow-lg overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50">
                            <tr>
                                <th class="text-left py-4 px-6 font-semibold text-gray-900">Sản phẩm</th>
                                <th class="text-left py-4 px-6 font-semibold text-gray-900">Danh mục</th>
                                <th class="text-left py-4 px-6 font-semibold text-gray-900">Giá</th>
                                <th class="text-left py-4 px-6 font-semibold text-gray-900">Số lượng</th>
                                <th class="text-left py-4 px-6 font-semibold text-gray-900">Trạng thái</th>
                                <th class="text-left py-4 px-6 font-semibold text-gray-900">Thao tác</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($products as $product)
                                @php
                                    $inStock = $product['status'] === \App\Enums\ProductStatus::IN_STOCK;
                                    $image = $product['image']
                                        ? asset('storage/' . $product['image'])
                                        : 'https://via.placeholder.com/300x200?text=No+Image';
                                @endphp
                                <tr class="border-b border-gray-100">
                                    <td class="py-4 px-6">
                                        <div class="flex items-center space-x-4">
                                            <img src="{{ $image }}" alt="{{ $product['name'] }}" class="w-12 h-12 object-cover rounded-xl" />
                                            <div>
                                                <div class="font-semibold text-gray-900">{{ $product['name'] }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-4 px-6 text-gray-600">
                                        {{ $product['category'] }}
                                    </td>
                                    <td class="py-4 px-6">
                                        <div class="font-semibold text-gray-900">{{ number_format($product['price']) }}đ</div>
                                        @if (!empty($product['originalPrice']) && $product['originalPrice'] > 0)
                                            <div class="text-sm text-gray-400 line-through">
                                                {{ number_format($product['originalPrice']) }}đ
                                            </div>
                                        @endif
                                    </td>
                                    <td class="py-4 px-6">
                                        <input type="number" min="1" value="{{ $product['quantity'] ?? 1 }}"
                                               data-product-id="{{ $product['id'] }}"
                                               class="border rounded-lg px-2 py-1 w-20 quantity-input" />
                                    </td>
                                    <td class="py-4 px-6">
                                        <span class="px-3 py-1 rounded-full text-sm font-medium {{ $inStock ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $inStock ? 'Còn hàng' : 'Hết hàng' }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-6">
                                        <div class="flex items-center space-x-2">
                                            <button type="button" class="text-red-600 hover:text-red-700 transition-colors cursor-pointer">
                                                <x-heroicon-o-trash class="w-5 h-5" />
                                            </button>
                                            <button
                                                class="btn-add-to-cart w-full block text-center py-3 rounded-2xl font-semibold transition-all duration-300 cursor-pointer"
                                                data-id="{{ $product['id'] }}"
                                            >
                                                <x-heroicon-o-shopping-cart class="h-6 w-6" />
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        <!-- Modal xóa -->
                        <div id="deleteModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm hidden items-center justify-center z-50">
                            <div class="bg-white rounded-xl p-6 w-full max-w-sm text-center shadow-xl">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Xác nhận xóa?</h3>
                                <p class="text-gray-600 mb-6">Bạn có chắc chắn muốn xóa sản phẩm này?</p>
                                <form id="deleteForm" method="POST" action="">
                                    @csrf
                                    @method('DELETE')
                                    <div class="flex justify-center space-x-3">
                                        <button type="button" onclick="closeModal()" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">Hủy</button>
                                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Xóa</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
@push('scripts')
    @vite([
        'resources/assets/js/home.js',
    ])
@endpush
