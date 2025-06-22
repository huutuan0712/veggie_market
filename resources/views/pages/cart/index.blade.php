@extends('layouts.app')

@section('content')
    <div class="min-h-screen py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if(count($cartItems) === 0)
                <div class="text-center py-20">
                    <x-heroicon-o-shopping-cart class="w-6 h-6 text-orange-600" />
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">Giỏ hàng của bạn đang trống</h2>
                    <p class="text-gray-600 mb-8">Hãy thêm một số trái cây tươi ngon vào giỏ hàng</p>
                    <a href="{{ route('products.index') }}" class="bg-gradient-to-r from-orange-500 to-red-500 text-white px-8 py-4 rounded-2xl font-semibold hover:from-orange-600 hover:to-red-600 transition-all duration-300 inline-flex items-center space-x-2">
                        <span>Mua sắm ngay</span>
                    </a>
                </div>
            @else
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h1 class="text-3xl lg:text-4xl font-bold text-gray-900">Giỏ hàng</h1>
                        <p class="text-gray-600 mt-2">{{ $cartItems->sum('quantity') }} sản phẩm</p>
                    </div>
                    <a href="{{ route('products.index') }}" class="inline-flex items-center space-x-2 text-gray-600 hover:text-orange-600 transition-colors">
                        <x-heroicon-o-arrow-left class="w-6 h-6 text-gray-500" />
                        <span>Tiếp tục mua sắm</span>
                    </a>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    {{-- Cart Items --}}
                    <div class="lg:col-span-2 space-y-4">
                        @foreach($cartItems as $item)
                            <div class="bg-white rounded-2xl shadow-lg p-6">
                                <div class="flex items-center space-x-4">
                                    <div class="flex-shrink-0">
                                        <img src="{{ $item->image }}" alt="{{ $item->name }}" class="w-20 h-20 object-cover rounded-xl">
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="text-lg font-semibold text-gray-900">{{ $item->name }}</h3>
                                        <p class="text-orange-600 font-semibold">{{ number_format($item->price) }}đ</p>
                                    </div>
                                    <div class="flex items-center space-x-3">
                                        <div class="flex items-center border border-gray-200 rounded-xl">
                                            <form method="POST" action="{{ route('cart.update', $item->id) }}">
                                                @csrf
                                                @method('PUT')
                                                <button name="action" value="decrease" class="p-2 hover:bg-gray-50 transition-colors">
                                                    <x-heroicon-o-minus class="h-4 w-4" />
                                                </button>
                                                <span class="px-4 py-2 font-semibold">{{ $item->quantity }}</span>
                                                <button name="action" value="increase" class="p-2 hover:bg-gray-50 transition-colors">
                                                    <x-heroicon-o-plus class="h-4 w-4" />
                                                </button>
                                            </form>
                                        </div>
                                        <form method="POST" action="{{ route('cart.destroy', $item->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition-colors">
                                                <x-heroicon-o-trash class="h-5 w-5" />
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                <div class="mt-4 pt-4 border-t border-gray-100">
                                    <div class="flex justify-between items-center">
                                        <span class="text-gray-600">Tổng cộng:</span>
                                        <span class="text-xl font-bold text-gray-900">{{ number_format($item->price * $item->quantity) }}đ</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Order Summary --}}
                    <div class="lg:col-span-1">
                        <div class="bg-white rounded-2xl shadow-lg p-6 sticky top-24">
                            <h3 class="text-xl font-semibold text-gray-900 mb-6">Tổng đơn hàng</h3>
                            <div class="space-y-4 mb-6">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Tạm tính:</span>
                                    <span class="font-semibold">{{ number_format($total) }}đ</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Phí giao hàng:</span>
                                    <span class="font-semibold text-green-600">Miễn phí</span>
                                </div>
                                <div class="border-t border-gray-200 pt-4">
                                    <div class="flex justify-between items-center">
                                        <span class="text-lg font-semibold text-gray-900">Tổng cộng:</span>
                                        <span class="text-2xl font-bold text-orange-600">{{ number_format($total) }}đ</span>
                                    </div>
                                </div>
                            </div>
                            <a href="{{ route('checkout.index') }}" class="w-full block text-center bg-gradient-to-r from-orange-500 to-red-500 text-white py-4 rounded-2xl font-semibold hover:from-orange-600 hover:to-red-600 transition-all duration-300 mb-4">
                                Thanh toán
                            </a>
                            <div class="text-center text-sm text-gray-500">
                                Miễn phí giao hàng cho đơn hàng trên 200.000đ
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
