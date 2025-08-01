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
        <div class="min-h-screen py-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="mb-8">
                    <h1 class="text-3xl lg:text-4xl font-bold text-gray-900">Thanh toán</h1>
                    <p class="text-gray-600 mt-2">Hoàn tất đơn hàng của bạn</p>
                </div>

                <form action="{{ route('checkout.store') }}" method="POST" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    @csrf

                    {{-- Thông tin giao hàng --}}
                    <div class="lg:col-span-2 space-y-6">
                        <div class="bg-white rounded-2xl shadow-lg p-6">
                            <h3 class="text-xl font-semibold text-gray-900 mb-6">Thông tin giao hàng</h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Họ và tên *</label>
                                    <input type="text" name="shipping_name" value="{{ old('shipping_name', optional($user->shippingAddress)->full_name) }}"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent @error('shipping_name') border-red-500 @enderror">
                                    @error('shipping_name')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                                    <input type="email" name="shipping_email" value="{{ old('shipping_email', $user->email) }}"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent @error('shipping_email') border-red-500 @enderror">
                                    @error('shipping_email')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Số điện thoại *</label>
                                    <input type="tel" name="shipping_phone" value="{{ old('shipping_phone', optional($user->shippingAddress)->phone) }}"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent @error('shipping_phone') border-red-500 @enderror">
                                    @error('shipping_phone')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Tỉnh/Thành phố *</label>
                                    <select name="shipping_province"
                                            class="province-select w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent @error('shipping_province') border-red-500 @enderror">
                                        <option value="">Chọn tỉnh/thành phố</option>
                                        @foreach ($provinces as $province)
                                            <option value="{{ $province->id }}" {{ old('shipping_province') == $province->id ? 'selected' : '' }}>
                                                {{ $province->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('shipping_province')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Quận/Huyện</label>
                                    <select name="shipping_district"
                                            class="district-select w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                                        <option value="">Chọn quận/huyện</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Phường/Xã</label>
                                    <select name="shipping_ward"
                                            class="ward-select w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                                        <option value="">Chọn phường/xã</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mt-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Địa chỉ chi tiết *</label>
                                <textarea name="shipping_address" rows="3"
                                          class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent @error('shipping_address') border-red-500 @enderror"
                                          placeholder="Số nhà, tên đường...">{{ old('shipping_address') }}</textarea>
                                @error('shipping_address')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Phương thức thanh toán --}}
                        <div class="bg-white rounded-2xl shadow-lg p-6">
                            <h3 class="text-xl font-semibold text-gray-900 mb-6">Phương thức thanh toán</h3>
                            <div class="space-y-4">
                                @foreach([
                                    1 => ['Thanh toán khi nhận hàng (COD)', 'Thanh toán bằng tiền mặt khi nhận hàng'],
                                    2 => ['Chuyển khoản ngân hàng', 'Chuyển khoản trực tiếp qua ngân hàng'],
                                    3 => ['VNPay', 'Thanh toán qua ví điện tử VNPay'],
                                ] as $value => [$title, $desc])
                                    <label class="flex items-center p-4 border border-gray-200 rounded-xl cursor-pointer hover:bg-gray-50 transition-colors">
                                        <input type="radio" name="payment_method" value="{{ $value }}"
                                               class="text-orange-600 focus:ring-orange-500" {{ old('payment_method', '1') == $value ? 'checked' : '' }}>
                                        <div class="ml-3">
                                            <div class="font-medium text-gray-900">{{ $title }}</div>
                                            <div class="text-sm text-gray-600">{{ $desc }}</div>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                            @error('payment_method')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Ghi chú --}}
                        <div class="bg-white rounded-2xl shadow-lg p-6">
                            <h3 class="text-xl font-semibold text-gray-900 mb-4">Ghi chú đơn hàng</h3>
                            <textarea name="notes" rows="4"
                                      class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                                      placeholder="Ghi chú thêm cho đơn hàng (tùy chọn)">{{ old('notes') }}</textarea>
                        </div>

                        {{-- Mã giảm giá --}}
                        <div class="bg-white rounded-2xl shadow-lg p-6">
                            <h3 class="text-xl font-semibold text-gray-900 mb-4">Mã giảm giá</h3>
                            <div class="flex space-x-4">
                                <input type="text" id="discount-code" placeholder="Nhập mã giảm giá"
                                       class="flex-1 px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                                <button type="button" onclick="applyDiscount()"
                                        class="px-6 py-3 bg-orange-500 text-white rounded-xl font-semibold hover:bg-orange-600 transition-colors">
                                    Áp dụng
                                </button>
                            </div>
                            <div id="discount-message" class="mt-2 text-sm"></div>
                            <input type="hidden" name="discount_amount" id="discount-amount" value="0">
                        </div>
                    </div>

                    {{-- Tóm tắt đơn hàng --}}
                    <div class="lg:col-span-1">
                        <div class="bg-white rounded-2xl shadow-lg p-6 sticky top-24">
                            <h3 class="text-xl font-semibold text-gray-900 mb-6">Đơn hàng của bạn</h3>

                            {{-- Sản phẩm trong giỏ --}}
                            <div class="space-y-4 mb-6 max-h-64 overflow-y-auto">
                                @foreach($cartItems as $item)
                                    @php
                                        $image = $item->product->images->isNotEmpty()
                                            ? asset('storage/' . $item->product->images->first()->path)
                                            : 'https://via.placeholder.com/300x200?text=No+Image';
                                    @endphp
                                    <div class="flex items-center space-x-3">
                                        <div class="flex-shrink-0">
                                            <img src="{{ $image }}" alt="{{ $item->product->name }}"
                                                 class="w-12 h-12 object-cover rounded-lg">
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <h4 class="text-sm font-medium text-gray-900 truncate">{{ $item->product->name }}</h4>
                                            <p class="text-sm text-gray-600">{{ $item->quantity }} x {{ number_format($item->product->price) }}đ</p>
                                        </div>
                                        <div class="text-sm font-semibold text-gray-900">
                                            {{ number_format($item->product->price * $item->quantity) }}đ
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            {{-- Tóm tắt tổng tiền --}}
                            <div class="space-y-4 mb-6 border-t border-gray-200 pt-4">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Tạm tính:</span>
                                    <span class="font-semibold" id="subtotal">{{ number_format($subtotal) }}đ</span>
                                </div>

                                <div class="flex justify-between" id="discount-row" style="display: none;">
                                    <span class="text-gray-600">Giảm giá:</span>
                                    <span class="font-semibold text-green-600" id="discount-display">0đ</span>
                                </div>

                                <div class="flex justify-between">
                                    <span class="text-gray-600">Phí giao hàng:</span>
                                    <span class="font-semibold text-green-600">{{ $shippingFee == 0 ? 'Miễn phí' : number_format($shippingFee) . 'đ' }}</span>
                                </div>

                                <div class="border-t border-gray-200 pt-4">
                                    <div class="flex justify-between items-center">
                                        <span class="text-lg font-semibold text-gray-900">Tổng cộng:</span>
                                        <span class="text-xl font-bold text-orange-600" id="total">
                                        {{ number_format($subtotal - $discountAmount + $shippingFee) }}đ
                                </span>
                                    </div>
                                </div>
                            </div>

                            <button type="submit"
                                    class="w-full bg-orange-500 hover:bg-orange-600 text-white font-semibold py-3 rounded-xl transition-colors text-center">
                                Đặt hàng
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endif

@endsection
@push('scripts')
    @vite([
        'resources/assets/js/location.js',
    ])
@endpush
<script>
    function applyDiscount() {
        const code = document.getElementById('discount-code').value.trim();
        const discountDisplay = document.getElementById('discount-display');
        const discountRow = document.getElementById('discount-row');
        const discountAmountInput = document.getElementById('discount-amount');
        const subtotal = {{ $subtotal }};
        const shippingFee = {{ $shippingFee }};
        const totalDisplay = document.getElementById('total');

        let discountAmount = 0;

        if (code === 'GIAM10') {
            discountAmount = subtotal * 0.1;
            document.getElementById('discount-message').innerText = 'Áp dụng mã giảm giá thành công!';
            document.getElementById('discount-message').className = 'mt-2 text-sm text-green-600';
        } else {
            discountAmount = 0;
            document.getElementById('discount-message').innerText = 'Mã giảm giá không hợp lệ.';
            document.getElementById('discount-message').className = 'mt-2 text-sm text-red-600';
        }

        discountDisplay.innerText = new Intl.NumberFormat().format(discountAmount) + 'đ';
        discountRow.style.display = discountAmount > 0 ? 'flex' : 'none';
        discountAmountInput.value = discountAmount;

        const total = subtotal - discountAmount + shippingFee;
        totalDisplay.innerText = new Intl.NumberFormat().format(total) + 'đ';
    }

</script>
