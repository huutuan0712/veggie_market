@extends('layouts.app')

@section('content')
    @php
        $activeTab = request('tab', 'description');
        $tabs = [
            ['id' => 'description', 'label' => 'Mô tả'],
            ['id' => 'reviews', 'label' => 'Đánh giá (' . 0 . ')'],
        ];
    @endphp

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
                        @php
                            $inStock = $product->status === \App\Enums\ProductStatus::IN_STOCK;

                            $image = is_array($product->images) && count($product->images) > 0
                                                ? asset('storage/' . $product->images[0]['path'])
                                                : 'https://via.placeholder.com/300x200?text=No+Image';
                        @endphp

                        <img src="{{ $image }}" alt="{{ $product->name }}" class="w-full h-96 lg:h-[500px] object-cover" />

                        @if($product->original_price)
                            <div
                                class="absolute top-6 left-6 bg-red-500 text-white px-4 py-2 rounded-full font-semibold">
                                Giảm {{ round((($product->original_price - $product->price) / $product->original_price) * 100) }}
                                %
                            </div>
                        @endif
                    </div>
                    <div class="grid grid-cols-4 gap-4">
                        @foreach($product->images as $index => $image)
                            <button
                                type="button"
                                class="relative overflow-hidden rounded-xl border-2 border-gray-200 hover:border-orange-300 transition-all"
                            >
                                <img
                                    src="{{ asset('storage/' . $image['path']) }}"
                                    alt="{{ $product->name }} {{ $index + 1 }}"
                                    class="w-full h-20 object-cover"
                                />
                            </button>
                        @endforeach
                    </div>
                </div>

                {{-- Product Info --}}
                <div class="space-y-6">
                    <div>
                        <span class="text-orange-600 font-medium text-sm">{{ $product->category->name }}</span>
                        <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 mt-2 mb-4">{{ $product->name }}</h1>
                        <div class="flex items-center space-x-2 mb-4">
                            <div class="flex items-center space-x-1">
                                @for ($i = 0; $i < 5; $i++)
                                    <x-heroicon-s-star class="h-5 w-5 text-yellow-400"/>
                                @endfor
                            </div>
                            <span class="text-gray-600">(128 đánh giá)</span>
                        </div>
                    </div>

                    <div class="flex items-center space-x-4">
                        <span class="text-3xl font-bold text-orange-600">{{ number_format($product->price, 0, ',', '.') }}đ</span>
                        @if($product->original_price)
                            <span class="text-xl text-gray-400 line-through">{{ number_format($product->original_price, 0, ',', '.') }}đ</span>
                        @endif
                    </div>

                    <p class="text-gray-600 text-lg leading-relaxed">{{ $product->description }}</p>

                    {{-- Benefits --}}
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">Lợi ích sức khỏe:</h3>
                        <div class="grid grid-cols-2 gap-2">
                            @foreach ($product->benefits as $benefit)
                                <div class="flex items-center space-x-2">
                                    <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                                    <span class="text-gray-600">{{ $benefit }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Quantity + Add to cart --}}
                    <div class="space-y-4">
                        <div class="flex items-center space-x-4">
                            <span class="font-semibold text-gray-900">Số lượng:</span>
                            <div class="flex items-center border border-gray-200 rounded-xl">
                                <button type="button" class="p-3 hover:bg-gray-50" id="decreaseQty">
                                    <x-heroicon-o-minus class="h-4 w-4"/>
                                </button>
                                <input
                                    type="number"
                                    id="quantity"
                                    name="quantity"
                                    value="1"
                                    min="1"
                                    class="w-16 text-center font-semibold outline-none border-0 focus:ring-0"
                                />
                                <button type="button" class="p-3 hover:bg-gray-50" id="increaseQty">
                                    <x-heroicon-o-plus class="h-4 w-4"/>
                                </button>
                            </div>
                        </div>

                        <div class="flex space-x-4">
                            <button
                                id="addToCartBtn"
                                data-product-id="{{ $product->id }}"
                                class="flex-1 py-4 rounded-2xl font-semibold transition-all duration-300 flex items-center justify-center space-x-2
                                {{ $inStock ? 'bg-gradient-to-r from-orange-500 to-red-500 text-white hover:from-orange-600 hover:to-red-600' : 'bg-gray-300 text-gray-500 cursor-not-allowed' }}"
                                {{ $inStock ? '' : 'disabled' }}
                            >
                                <x-heroicon-o-shopping-cart class="h-5 w-5"/>
                                <span>{{ $inStock ? 'Thêm vào giỏ hàng' : 'Hết hàng' }}</span>
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

            <div class="bg-white rounded-3xl shadow-lg overflow-hidden">
                {{-- Tab Navigation --}}
                <div class="border-b border-gray-200">
                    <nav class="flex space-x-8 px-8">
                        @foreach ($tabs as $tab)
                            <a href="{{ request()->fullUrlWithQuery(['tab' => $tab['id']]) }}"
                               class="py-4 px-2 border-b-2 font-medium text-sm transition-colors
                          {{ $activeTab === $tab['id']
                              ? 'border-orange-500 text-orange-600'
                              : 'border-transparent text-gray-500 hover:text-gray-700' }}">
                                {{ $tab['label'] }}
                            </a>
                        @endforeach
                    </nav>
                </div>
                <div class="p-8">
                    {{-- Description Tab --}}
                    @if ($activeTab === 'description')
                        <div class="prose max-w-none">
                            <h3 class="text-xl font-semibold text-gray-900 mb-4">Mô tả sản phẩm</h3>
                            <p class="text-gray-600 leading-relaxed mb-6">
                                {{ $product->description }} Được trồng và chăm sóc theo quy trình khép kín, đảm bảo chất lượng từ khâu gieo trồng đến thu hoạch.
                            </p>

                            <h4 class="text-lg font-semibold text-gray-900 mb-3">Đặc điểm nổi bật:</h4>
                            <ul class="list-disc list-inside space-y-2 text-gray-600 mb-6">
                                <li>Trái cây tươi ngon, được hái vào đúng độ chín</li>
                                <li>Không sử dụng chất bảo quản có hại</li>
                                <li>Đóng gói cẩn thận, vận chuyển nhanh chóng</li>
                                <li>Cam kết hoàn tiền 100% nếu không hài lòng</li>
                            </ul>

                            <h4 class="text-lg font-semibold text-gray-900 mb-3">Hướng dẫn sử dụng:</h4>
                            <p class="text-gray-600">
                                Rửa sạch trước khi ăn. Có thể ăn trực tiếp hoặc chế biến thành các món ăn, nước ép theo sở thích.
                            </p>
                        </div>
                    @endif
                    {{-- Reviews Tab --}}
                    @if ($activeTab === 'reviews')
                        <div>
                            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
                                {{-- Rating Summary --}}
                                <div class="bg-gray-50 p-6 rounded-2xl text-center">
                                    <div class="text-4xl font-bold text-gray-900 mb-2">
                                        {{ number_format($averageRating, 1) }}
                                    </div>
                                    <div class="flex items-center justify-center space-x-1 mb-2">
                                        @for ($i = 0; $i < 5; $i++)
                                            <svg class="h-5 w-5 {{ $i < floor($averageRating) ? 'text-yellow-400 fill-current' : 'text-gray-300' }}"
                                                 fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.284 3.943h4.14c.969 0 1.371 1.24.588 1.81l-3.356 2.44 1.285 3.943c.3.921-.755 1.688-1.539 1.118L10 13.348l-3.356 2.44c-.784.57-1.838-.197-1.539-1.118l1.285-3.943-3.356-2.44c-.783-.57-.38-1.81.588-1.81h4.14l1.284-3.943z" />
                                            </svg>
                                        @endfor
                                    </div>
                                    <div class="text-gray-600">{{ count($reviews) }} đánh giá</div>

                                    {{-- Rating Distribution --}}
                                    <div class="space-y-2 mt-4">
                                        @foreach ($ratingDistribution as $item)
                                            <div class="flex items-center space-x-2">
                                                <span class="text-sm text-gray-600 w-8">{{ $item['rating'] }}★</span>
                                                <div class="flex-1 bg-gray-200 rounded-full h-2">
                                                    <div class="bg-yellow-400 h-2 rounded-full" style="width: {{ $item['percentage'] }}%"></div>
                                                </div>
                                                <span class="text-sm text-gray-600 w-8">{{ $item['count'] }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                {{-- Write Review --}}
                                <div class="lg:col-span-2">
                                    <div class="bg-orange-50 p-6 rounded-2xl mb-6">
                                        <h4 class="font-semibold text-gray-900 mb-3">Viết đánh giá</h4>
                                        <p class="text-gray-600 mb-4">Chia sẻ trải nghiệm của bạn về sản phẩm này</p>
                                        <a href="{{ route('reviews.create', ['product_id' => $product->id]) }}"
                                           class="bg-gradient-to-r from-orange-500 to-red-500 text-white px-6 py-2 rounded-xl font-semibold hover:from-orange-600 hover:to-red-600 transition-all duration-300">
                                            Viết đánh giá
                                        </a>
                                    </div>
                                </div>
                            </div>

                            {{-- Review List --}}
                            <div class="space-y-6">
                                <h4 class="text-lg font-semibold text-gray-900">Đánh giá từ khách hàng</h4>
                                @foreach ($reviews as $review)
                                    <div class="border border-gray-200 rounded-2xl p-6">
                                        <div class="flex items-start space-x-4">
                                            <img src="{{ $review['userAvatar'] }}" alt="{{ $review['userName'] }}"
                                                 class="w-12 h-12 rounded-full object-cover">
                                            <div class="flex-1">
                                                <div class="flex items-center justify-between mb-2">
                                                    <div>
                                                        <h5 class="font-semibold text-gray-900">{{ $review['userName'] }}</h5>
                                                        <div class="flex items-center space-x-2">
                                                            <div class="flex items-center space-x-1">
                                                                @for ($i = 0; $i < 5; $i++)
                                                                    <svg class="h-4 w-4 {{ $i < $review['rating'] ? 'text-yellow-400 fill-current' : 'text-gray-300' }}"
                                                                         fill="currentColor" viewBox="0 0 20 20">
                                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.284 3.943h4.14c.969 0 1.371 1.24.588 1.81l-3.356 2.44 1.285 3.943c.3.921-.755 1.688-1.539 1.118L10 13.348l-3.356 2.44c-.784.57-1.838-.197-1.539-1.118l1.285-3.943-3.356-2.44c-.783-.57-.38-1.81.588-1.81h4.14l1.284-3.943z" />
                                                                    </svg>
                                                                @endfor
                                                            </div>
                                                            <span class="text-gray-500 text-sm">{{ $review['date'] }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <p class="text-gray-600 mb-4">{{ $review['comment'] }}</p>

                                                {{-- Review Images --}}
                                                @if (!empty($review['images']))
                                                    <div class="flex space-x-2 mb-4">
                                                        @foreach ($review['images'] as $image)
                                                            <img src="{{ $image }}" alt="Ảnh đánh giá"
                                                                 class="w-16 h-16 object-cover rounded-lg">
                                                        @endforeach
                                                    </div>
                                                @endif

                                                {{-- Helpful Actions --}}
                                                <div class="flex items-center space-x-4">
                                                    <button class="flex items-center space-x-1 text-gray-500 hover:text-green-600 transition-colors">
                                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M14 9V5a3 3 0 00-6 0v4m12 0a6 6 0 11-12 0 6 6 0 0112 0z" /></svg>
                                                        <span class="text-sm">Thích ({{ $review['helpful'] }})</span>
                                                    </button>
                                                    <button class="flex items-center space-x-1 text-gray-500 hover:text-red-600 transition-colors">
                                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M10 14L21 3m0 0L10 14m11-11v7a2 2 0 01-2 2H7a2 2 0 01-2-2v-7" /></svg>
                                                        <span class="text-sm">Không thích </span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const decreaseBtn = document.getElementById('decreaseQty');
            const increaseBtn = document.getElementById('increaseQty');
            const quantityInput = document.getElementById('quantity');
            const addToCartBtn = document.getElementById('addToCartBtn');

            decreaseBtn?.addEventListener('click', function () {
                let qty = parseInt(quantityInput.value);
                if (qty > 1) {
                    quantityInput.value = qty - 1;
                }
            });

            increaseBtn?.addEventListener('click', function () {
                let qty = parseInt(quantityInput.value);
                quantityInput.value = qty + 1;
            });

            addToCartBtn?.addEventListener('click', function (e) {
                e.preventDefault();

                const productId = this.dataset.productId;
                const quantity = parseInt(quantityInput.value);

                fetch("{{ route('cart.store') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        product_id: productId,
                        quantity: quantity
                    })
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            const cartCountEl = document.getElementById('cart-count');
                            if (cartCountEl && data.data.cartCount !== undefined) {
                                cartCountEl.textContent = data.data.cartCount;
                            }
                        } else {
                            alert("Lỗi khi thêm sản phẩm");
                        }
                    })
                    .catch(error => {
                        console.error("Lỗi:", error);
                        alert("Đã xảy ra lỗi.");
                    });
            });
        });
    </script>
@endpush
