@extends('layouts.app')

@section('content')
    <section class="relative bg-gradient-to-br from-orange-500 via-red-500 to-pink-500 text-white overflow-hidden">
        <div class="absolute inset-0 bg-fruit-pattern opacity-10"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-32">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div class="space-y-8">
                    <div class="space-y-4">
                        <div class="flex items-center space-x-2">
                            <span class="text-yellow-300 font-medium">Trái cây tươi ngon #1</span>
                        </div>
                        <h1 class="text-4xl lg:text-6xl font-bold leading-tight">
                            Trái cây
                            <span class="block text-transparent bg-clip-text bg-gradient-to-r from-yellow-300 to-orange-200">
                                Tươi ngon
                            </span>
                            mỗi ngày
                        </h1>
                        <p class="text-xl text-orange-100 max-w-lg">
                            Khám phá bộ sưu tập trái cây nhiệt đới tươi ngon, được chọn lọc kỹ càng từ những vườn cây uy tín nhất.
                        </p>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="{{ route('products.index') }}"
                           class="bg-white text-orange-600 px-8 py-4 rounded-2xl font-semibold hover:bg-orange-50 transition-all duration-300 flex items-center justify-center space-x-2 shadow-xl">
                            <span>Mua ngay</span>
                            <x-heroicon-o-arrow-right class="h-4 w-4" />
                        </a>
                        <button class="border-2 border-white/30 text-white px-8 py-4 rounded-2xl font-semibold hover:bg-white/10 transition-all duration-300">
                            Tìm hiểu thêm
                        </button>
                    </div>

                    <div class="flex items-center space-x-8 pt-4">
                        <div class="text-center">
                            <div class="text-2xl font-bold">1000+</div>
                            <div class="text-orange-200 text-sm">Khách hàng</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold">50+</div>
                            <div class="text-orange-200 text-sm">Loại trái cây</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold">99%</div>
                            <div class="text-orange-200 text-sm">Hài lòng</div>
                        </div>
                    </div>
                </div>

                {{-- Product cards can be extracted as a Blade component if reused --}}
                <div class="relative">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-4">
                            <x-fruit-card name="Xoài Hòa Lộc" desc="Ngọt thơm tự nhiên" img="https://images.pexels.com/photos/2294471/pexels-photo-2294471.jpeg?auto=compress&cs=tinysrgb&w=400" />
                            <x-fruit-card name="Dâu tây Đà Lạt" desc="Tươi ngon cao cấp" img="https://images.pexels.com/photos/1125328/pexels-photo-1125328.jpeg?auto=compress&cs=tinysrgb&w=400" />
                        </div>
                        <div class="space-y-4 mt-8">
                            <x-fruit-card name="Nho nhập khẩu" desc="Chất lượng quốc tế" img="https://images.pexels.com/photos/708777/pexels-photo-708777.jpeg?auto=compress&cs=tinysrgb&w=400" />
                            <x-fruit-card name="Dưa hấu ngọt" desc="Giải nhiệt mùa hè" img="https://images.pexels.com/photos/1068584/pexels-photo-1068584.jpeg?auto=compress&cs=tinysrgb&w=400" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">
                    Tại sao chọn Fresh Fruits?
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Chúng tôi cam kết mang đến trải nghiệm mua sắm trái cây tốt nhất với chất lượng đảm bảo
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                {{-- Feature 1 --}}
                <div class="text-center group">
                    <div class="bg-gradient-to-br from-green-400 to-green-600 w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                        <x-heroicon-o-shield-check class="h-8 w-8 text-white" />
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">Chất lượng đảm bảo</h3>
                    <p class="text-gray-600">Trái cây được kiểm tra kỹ lưỡng, đảm bảo tươi ngon và an toàn</p>
                </div>

                {{-- Feature 2 --}}
                <div class="text-center group">
                    <div class="bg-gradient-to-br from-orange-400 to-orange-600 w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                        <x-heroicon-o-truck class="h-8 w-8 text-white" />
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">Giao hàng nhanh</h3>
                    <p class="text-gray-600">Giao hàng tận nơi trong 2-4 giờ, đảm bảo độ tươi ngon</p>
                </div>

                {{-- Feature 3 --}}
                <div class="text-center group">
                    <div class="bg-gradient-to-br from-purple-400 to-purple-600 w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                        <x-lucide-heart-handshake class="h-8 w-8 text-white" />
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">Dịch vụ tận tâm</h3>
                    <p class="text-gray-600">Đội ngũ tư vấn chuyên nghiệp, hỗ trợ 24/7</p>
                </div>

                {{-- Feature 4 --}}
                <div class="text-center group">
                    <div class="bg-gradient-to-br from-red-400 to-red-600 w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                        <x-heroicon-o-star class="h-8 w-8 text-white" />
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">Giá cả hợp lý</h3>
                    <p class="text-gray-600">Giá cả cạnh tranh, nhiều ưu đãi hấp dẫn</p>
                </div>
            </div>
        </div>
    </section>
    <section class="py-20 bg-gradient-to-br from-orange-50 to-green-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">
                    Trái cây nổi bật
                </h2>
                <p class="text-xl text-gray-600">
                    Những sản phẩm được yêu thích nhất
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach ($featuredProducts as $product)
                    <div
                        class="bg-white rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden group">
                        <div class="relative overflow-hidden">
                            <a href="{{ route('products.show', ['product' => $product['id']]) }}">
                                <img
                                    src="{{ $product['image'] }}"
                                    alt="{{ $product['name'] }}"
                                    class="w-full h-64 object-cover group-hover:scale-110 transition-transform duration-500"
                                />
                                @if ($product['originalPrice'])
                                    <div
                                        class="absolute top-4 left-4 bg-red-500 text-white px-3 py-1 rounded-full text-sm font-semibold">
                                        Giảm {{ round((($product['originalPrice'] - $product['price']) / $product['originalPrice']) * 100) }}
                                        %
                                    </div>
                                @endif
                            </a>
                        </div>

                        <div class="p-6">
                            <a href="{{ route('products.show', ['product' => $product['id']]) }}">
                                <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ $product['name'] }}</h3>
                            </a>
                            <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $product['description'] }}</p>

                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center space-x-2">
                                <span class="text-2xl font-bold text-orange-600">
                                    {{ number_format($product['price'], 0, ',', '.') }}đ
                                </span>
                                    @if ($product['originalPrice'])
                                        <span class="text-gray-400 line-through text-sm">
                                        {{ number_format($product['originalPrice'], 0, ',', '.') }}đ
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <button
                                class="btn-add-to-cart w-full bg-gradient-to-r from-orange-500 to-red-500 text-white py-3 rounded-2xl font-semibold hover:from-orange-600 hover:to-red-600 transition-all duration-300 flex items-center justify-center space-x-2"
                                data-id="{{ $product->id }}"
                            >
                                <span>Mua ngay</span>
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="text-center mt-12">
                <a
                    href="{{ route('products.index') }}"
                    class="bg-gradient-to-r from-green-500 to-green-600 text-white px-8 py-4 rounded-2xl font-semibold hover:from-green-600 hover:to-green-700 transition-all duration-300 inline-flex items-center space-x-2"
                >
                    <span>Xem tất cả sản phẩm</span>
                    <x-heroicon-o-arrow-right class="h-5 w-5" />
                </a>
            </div>
        </div>
    </section>

@endsection
@push('scripts')
    <script>
        const addToCartButtons = document.querySelectorAll('.btn-add-to-cart');

        addToCartButtons.forEach(button => {
            button.addEventListener('click', function () {
                const productId = button.dataset.id;

                fetch('/cart', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        product_id: productId,
                        quantity: 1
                    })
                })
                    .then(response => {
                        if (!response.ok) throw new Error('Request failed');
                        return response.json();
                    })
                    .then(data => {
                        console.log('Đã thêm vào giỏ hàng', data);
                        const cartCountEl = document.getElementById('cart-count');
                        if (cartCountEl && data.data.cartCount !== undefined) {
                            cartCountEl.textContent = data.data.cartCount;
                        }
                    })
                    .catch(error => {
                        console.error('Lỗi khi thêm vào giỏ hàng:', error);
                    });
            });
        });
    </script>
@endpush
