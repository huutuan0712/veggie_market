@extends('layouts.app')

@section('content')
    @if ($cartItems->isEmpty() && !$orderComplete)
        <div class="min-h-screen py-20">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center py-20">
                    <div class="text-gray-400 text-6xl mb-4">🛒</div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">
                        Giỏ hàng trống
                    </h2>
                    <p class="text-gray-600 mb-8">
                        Vui lòng thêm sản phẩm vào giỏ hàng trước khi thanh toán
                    </p>
                    <a
                        href="{{ route('products.index') }}"
                        class="bg-gradient-to-r from-orange-500 to-red-500 text-white px-8 py-4 rounded-2xl font-semibold hover:from-orange-600 hover:to-red-600 transition-all duration-300"
                    >
                        Mua sắm ngay
                    </a>
                </div>
            </div>
        </div>
    @else
        <div class="min-h-screen py-20 bg-gradient-to-br from-orange-50 via-white to-green-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Header -->
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h1 class="text-3xl lg:text-4xl font-bold text-gray-900">Thanh toán</h1>
                        <p class="text-gray-600 mt-2">Hoàn tất đơn hàng của bạn</p>
                    </div>
                    <a href="{{ route('cart.index') }}" class="inline-flex items-center space-x-2 text-gray-600 hover:text-orange-600 transition-colors">
                        <x-heroicon-o-arrow-left class="h-5 w-5" />
                        <span>Quay lại giỏ hàng</span>
                    </a>
                </div>
                @php
                    $steps = [1, 2, 3];
                @endphp

                <div class="mb-8">
                    <div class="flex items-center justify-center space-x-8">
                        @foreach ($steps as $step)
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-full flex items-center justify-center font-semibold
                              {{ $currentStep >= $step ? 'bg-orange-500 text-white' : 'bg-gray-200 text-gray-600' }}">
                                    {{ $step }}
                                </div>
                                <span class="ml-2 font-medium
                              {{ $currentStep >= $step ? 'text-orange-600' : 'text-gray-500' }}">
                              @if ($step === 1)
                                        Thông tin giao hàng
                                    @elseif ($step === 2)
                                        Thanh toán
                                    @else
                                        Xác nhận
                                    @endif
                            </span>

                                @if ($step < 3)
                                    <div
                                        class="w-16 h-1 mx-4 {{ $currentStep > $step ? 'bg-orange-500' : 'bg-gray-200' }}"></div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Nội dung -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Thông tin thanh toán -->
                    <div class="lg:col-span-2 space-y-8">
                        <form action="{{ route('checkout.store') }}" method="POST">
                            @csrf
                            <div class="bg-white rounded-3xl shadow-lg p-8">
                                <div class="flex items-center space-x-3 mb-6">
                                    <x-heroicon-o-truck class="h-6 w-6 text-orange-600" />
                                    <h2 class="text-2xl font-bold text-gray-900">Thông tin giao hàng</h2>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Họ và tên *</label>
                                        <input type="text" name="fullName" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent" required />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Số điện thoại *</label>
                                        <input type="tel" name="phone" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent" required />
                                    </div>
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                                        <input type="email" name="email" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent" required />
                                    </div>
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Địa chỉ *</label>
                                        <textarea name="address" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent" rows="3" required></textarea>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Tỉnh/Thành phố *</label>
                                        <select name="city" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent" required>
                                            <option>TP. Hồ Chí Minh</option>
                                            <option>Hà Nội</option>
                                            <option>Đà Nẵng</option>
                                            <option>Cần Thơ</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Quận/Huyện *</label>
                                        <input type="text" name="district" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent" required />
                                    </div>
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Phường/Xã *</label>
                                        <input type="text" name="ward" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent" required />
                                    </div>
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Ghi chú</label>
                                        <textarea name="notes" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent" rows="3"></textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- Thanh toán -->
                            <div class="bg-white rounded-3xl shadow-lg p-8 mt-8">
                                <div class="flex items-center space-x-3 mb-6">
                                    <x-heroicon-o-credit-card class="h-6 w-6 text-orange-600" />
                                    <h2 class="text-2xl font-bold text-gray-900">Phương thức thanh toán</h2>
                                </div>

                                <div class="space-y-4 mb-6">
                                    <label class="flex items-center space-x-3">
                                        <input type="radio" name="payment_method" value="cod" checked class="text-orange-600" />
                                        <span class="text-gray-700">Thanh toán khi nhận hàng (COD)</span>
                                    </label>
                                    <label class="flex items-center space-x-3">
                                        <input type="radio" name="payment_method" value="banking" class="text-orange-600" />
                                        <span class="text-gray-700">Chuyển khoản ngân hàng</span>
                                    </label>
                                </div>

                                <div class="text-right">
                                    <button type="submit" class="bg-gradient-to-r from-orange-500 to-red-500 text-white px-8 py-3 rounded-2xl font-semibold hover:from-orange-600 hover:to-red-600 transition-all duration-300">
                                        Đặt hàng
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Tóm tắt đơn hàng -->
                    <div class="lg:col-span-1">
                        <div class="bg-white rounded-3xl shadow-lg p-6 sticky top-24">
                            <h3 class="text-xl font-semibold text-gray-900 mb-6">Tóm tắt đơn hàng</h3>
                            <div class="space-y-4 mb-6">
                                @foreach($cartItems as $item)
                                    <div class="flex items-center space-x-3">
                                        <img src="{{ $item->image }}" alt="{{ $item->name }}" class="w-12 h-12 object-cover rounded-lg" />
                                        <div class="flex-1">
                                            <div class="font-medium text-gray-900 text-sm">{{ $item->name }}</div>
                                            <div class="text-gray-600 text-xs">x{{ $item->quantity }}</div>
                                        </div>
                                        <div class="font-semibold text-gray-900 text-sm">{{ number_format($item->price * $item->quantity) }}đ</div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="space-y-3 mb-6 pt-4 border-t border-gray-200">
                                <div class="flex justify-between text-gray-600">
                                    <span>Tạm tính:</span>
                                    <span>{{ number_format($total) }}đ</span>
                                </div>
                                <div class="flex justify-between text-gray-600">
                                    <span>Phí giao hàng:</span>
                                    <span class="text-green-600 font-semibold">Miễn phí</span>
                                </div>
                                <div class="flex justify-between items-center text-lg font-bold text-gray-900 pt-3 border-t border-gray-200">
                                    <span>Tổng cộng:</span>
                                    <span class="text-orange-600">{{ number_format($total) }}đ</span>
                                </div>
                            </div>

                            <div class="text-center text-sm text-gray-500">
                                🎉 Bạn được miễn phí giao hàng!
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

@endsection
