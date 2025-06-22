@extends('layouts.app')

@section('content')
    <div class="min-h-screen py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Back Button --}}
            <a href="{{ route('products.index') }}" class="inline-flex items-center space-x-2 text-gray-600 hover:text-orange-600 mb-8 transition-colors">
                <x-heroicon-o-arrow-left class="h-5 w-5" />
                <span>Quay lại</span>
            </a>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                {{-- Product Image --}}
                <div class="space-y-4">
                    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-orange-50 to-green-50">
                        <img src="{{ $product['image'] }}" alt="{{ $product['name'] }}" class="w-full h-96 lg:h-[500px] object-cover" />
                        @if($product['originalPrice'])
                            <div class="absolute top-6 left-6 bg-red-500 text-white px-4 py-2 rounded-full font-semibold">
                                Giảm {{ round((($product['originalPrice'] - $product['price']) / $product['originalPrice']) * 100) }}%
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Product Info --}}
                <div class="space-y-6">
                    <div>
                        <span class="text-orange-600 font-medium text-sm">{{ $product['category'] }}</span>
                        <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 mt-2 mb-4">{{ $product['name'] }}</h1>
                        <div class="flex items-center space-x-2 mb-4">
                            <div class="flex items-center space-x-1">
                                @for ($i = 0; $i < 5; $i++)
                                    <x-heroicon-s-star class="h-5 w-5 text-yellow-400" />
                                @endfor
                            </div>
                            <span class="text-gray-600">(128 đánh giá)</span>
                        </div>
                    </div>

                    <div class="flex items-center space-x-4">
                        <span class="text-3xl font-bold text-orange-600">{{ number_format($product['price'], 0, ',', '.') }}đ</span>
                        @if($product['originalPrice'])
                            <span class="text-xl text-gray-400 line-through">{{ number_format($product['originalPrice'], 0, ',', '.') }}đ</span>
                        @endif
                    </div>

                    <p class="text-gray-600 text-lg leading-relaxed">{{ $product['description'] }}</p>

                    {{-- Benefits --}}
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">Lợi ích sức khỏe:</h3>
                        <div class="grid grid-cols-2 gap-2">
                            @foreach ($product['benefits'] as $benefit)
                                <div class="flex items-center space-x-2">
                                    <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                                    <span class="text-gray-600">{{ $benefit }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Origin --}}
                    <div class="bg-orange-50 p-4 rounded-2xl">
                        <h4 class="font-semibold text-gray-900 mb-1">Xuất xứ:</h4>
                        <p class="text-gray-600">{{ $product['origin'] }}</p>
                    </div>

                    {{-- Quantity + Add to cart --}}
                    <div class="space-y-4">
                        <div class="flex items-center space-x-4">
                            <span class="font-semibold text-gray-900">Số lượng:</span>
                            <div class="flex items-center border border-gray-200 rounded-xl">
                                {{-- Giả sử xử lý với Alpine.js --}}
                                <button class="p-3 hover:bg-gray-50" @click="quantity = Math.max(1, quantity - 1)">
                                    <x-heroicon-o-minus class="h-4 w-4" />
                                </button>
                                <span class="px-6 py-3 font-semibold" x-text="quantity">1</span>
                                <button class="p-3 hover:bg-gray-50" @click="quantity = quantity + 1">
                                    <x-heroicon-o-plus class="h-4 w-4" />
                                </button>
                            </div>
                        </div>

                        <div class="flex space-x-4">
                            <button
                                @click="alert('Thêm vào giỏ hàng')"
                                class="flex-1 py-4 rounded-2xl font-semibold transition-all duration-300 flex items-center justify-center space-x-2
                {{ $product['inStock'] ? 'bg-gradient-to-r from-orange-500 to-red-500 text-white hover:from-orange-600 hover:to-red-600' : 'bg-gray-300 text-gray-500 cursor-not-allowed' }}"
                                {{ $product['inStock'] ? '' : 'disabled' }}
                            >
                                <x-heroicon-o-shopping-cart class="h-5 w-5" />
                                <span>{{ $product['inStock'] ? 'Thêm vào giỏ hàng' : 'Hết hàng' }}</span>
                            </button>
                            <button class="px-6 py-4 border border-gray-200 rounded-2xl hover:bg-gray-50 transition-colors">
                                <x-heroicon-o-heart class="h-5 w-5" />
                            </button>
                        </div>
                    </div>

                    {{-- Features --}}
                    <div class="grid grid-cols-2 gap-4 pt-6">
                        <div class="flex items-center space-x-3">
                            <div class="bg-green-100 p-2 rounded-lg">
                                <x-heroicon-o-truck class="h-5 w-5 text-green-600" />
                            </div>
                            <div>
                                <div class="font-semibold text-gray-900">Giao hàng nhanh</div>
                                <div class="text-sm text-gray-600">2-4 giờ</div>
                            </div>
                        </div>

                        <div class="flex items-center space-x-3">
                            <div class="bg-blue-100 p-2 rounded-lg">
                                <x-heroicon-o-shield-check class="h-5 w-5 text-blue-600" />
                            </div>
                            <div>
                                <div class="font-semibold text-gray-900">Đảm bảo chất lượng</div>
                                <div class="text-sm text-gray-600">100% tươi ngon</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
