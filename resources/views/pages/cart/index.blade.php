@extends('layouts.app')

@section('content')
    <div class="min-h-screen py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if(count($cartItems) === 0)
                <div class="text-center py-20">
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
                            <div class="cart-item bg-white rounded-2xl shadow-lg p-6">
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
                                            <form class="cart-update-form flex items-center space-x-2" data-id="{{ $item->id }}">
                                                <button type="button" class="btn-change-qty p-2 hover:bg-gray-50 transition-colors" data-delta="-1">
                                                    <x-heroicon-o-minus class="h-4 w-4" />
                                                </button>

                                                <input type="number" name="quantity" value="{{ $item->quantity }}" min="1"
                                                       class="w-16 rounded px-2 py-1 text-center border-0 focus:outline-none focus:ring-0 quantity-input">

                                                <button type="button" class="btn-change-qty p-2 hover:bg-gray-50 transition-colors" data-delta="1">
                                                    <x-heroicon-o-plus class="h-4 w-4" />
                                                </button>
                                            </form>
                                        </div>
                                        <button type="button" class="btn-delete-cart-item p-2 text-red-500 hover:bg-red-50 rounded-lg transition-colors"
                                                data-id="{{ $item->id }}">
                                            <x-heroicon-o-trash class="h-5 w-5" />
                                        </button>
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
                                    <span class="font-semibold" id="cart-total-amount">{{ number_format($total) }}đ</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Phí giao hàng:</span>
                                    <span class="font-semibold text-green-600">Miễn phí</span>
                                </div>
                                <div class="border-t border-gray-200 pt-4">
                                    <div class="flex justify-between items-center">
                                        <span class="text-lg font-semibold text-gray-900">Tổng cộng:</span>
                                        <span class="text-2xl font-bold text-orange-600" id="cart-total">{{ number_format($total) }}đ</span>
                                    </div>
                                </div>
                            </div>
                            <a href="{{ route('checkout.index') }}" class="w-full block text-center bg-gradient-to-r from-orange-500 to-red-500 text-white py-4 rounded-2xl font-semibold hover:from-orange-600 hover:to-red-600 transition-all duration-300 mb-4">
                                Thanh toán
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        const formUpdateQuantity = document.querySelectorAll('.cart-update-form');

        formUpdateQuantity.forEach(function (form) {
            const productId = form.dataset.id;
            const input = form.querySelector('.quantity-input');
            const btns = form.querySelectorAll('.btn-change-qty');

            btns.forEach(function (btn) {
                btn.addEventListener('click', function () {
                    let quantity = parseInt(input.value) || 1;
                    const delta = parseInt(btn.dataset.delta);
                    quantity += delta;
                    if (quantity < 1) quantity = 1;
                    input.value = quantity;
                    updateCart(productId, quantity);
                });
            });

            input.addEventListener('change', function () {
                let quantity = parseInt(input.value) || 1;
                if (quantity < 1) quantity = 1;
                input.value = quantity;
                updateCart(productId, quantity);
            });
        });

        function updateCart(productId, quantity) {
            fetch('/cart/' + productId, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ quantity: quantity })
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Request failed');
                    }
                    return response.json();
                })
                .then(data => {
                    const totalElement = document.getElementById('cart-total-amount');
                    const totalCart = document.getElementById('cart-total');

                    if (data.total) {
                        totalElement.textContent = new Intl.NumberFormat('vi-VN').format(data.total) + 'đ';
                        totalCart.textContent = new Intl.NumberFormat('vi-VN').format(data.total) + 'đ';
                    }
                })
                .catch(error => {
                    console.error('Cập nhật thất bại', error);
                });
        }

        const deleteButtons = document.querySelectorAll('.btn-delete-cart-item');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function () {
                const productId = button.dataset.id;

                if (confirm('Bạn có chắc muốn xoá sản phẩm này?')) {
                    fetch('/cart/' + productId, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                        .then(response => {
                            if (!response.ok) throw new Error('Request failed');
                            return response.json();
                        })
                        .then(data => {
                            console.log('Đã xoá thành công', data);
                            button.closest('.cart-item').remove();
                            document.querySelector('#cart-count').textContent = data.cartCount;
                            const remainingItems = document.querySelectorAll('.cart-item');
                            if (remainingItems.length === 0) {
                                location.reload();
                            }
                        })
                        .catch(error => {
                            console.error('Lỗi khi xoá:', error);
                        });
                }
            });
        });
    </script>
@endpush
