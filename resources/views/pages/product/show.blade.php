@extends('layouts.app')

@section('content')
    @php
        $tabs = [
            ['id' => 'description', 'label' => 'Mô tả'],
            ['id' => 'reviews', 'label' => 'Đánh giá'],
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
            <div class="tabs flex space-x-8 px-8">
                @foreach ($tabs as $tab)
                    <button
                        class="tab-btn py-4 px-2 border-b-2 font-medium text-sm transition-colors
                        {{ $loop->first ? 'border-orange-500 text-orange-600' : 'border-transparent text-gray-500 hover:text-gray-700' }}"
                        data-tab="{{ $tab['id'] }}">
                        {{ $tab['label'] }}
                    </button>
                @endforeach
            </div>

            <!-- Tabs Content -->
            <div class="bg-white rounded-3xl shadow-lg">
                {{-- Tabs Content --}}
                <div class="p-8">
                    @foreach ($tabs as $tab)
                        <div class="tab-pane {{ $loop->first ? '' : 'hidden' }}" data-content="{{ $tab['id'] }}">
                            @if ($tab['id'] === 'description')
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
                            @elseif ($tab['id'] === 'reviews')
                                <div>
                                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
                                        <div class="bg-gray-50 p-6 rounded-2xl text-center">
                                            <div class="text-center mb-6">
                                                <div id="average-rating" class="text-4xl font-bold text-gray-900 mb-2">0.0</div>
                                                <div id="average-stars" class="flex items-center justify-center space-x-1 mb-2"></div>
                                                <div id="rating-count" class="text-gray-600">(0) đánh giá</div>
                                            </div>

                                            <div id="rating-distribution" class="space-y-2 mt-4"></div>
                                        </div>

                                        <div class="lg:col-span-2">
                                            <div class="bg-orange-50 p-6 rounded-2xl mb-6 shadow-md">
                                                <h4 class="text-xl font-semibold text-gray-900 mb-2">Viết đánh giá</h4>
                                                <p class="text-gray-600 mb-4">Chia sẻ trải nghiệm thực tế của bạn về sản phẩm này để giúp người khác.</p>
                                                <button
                                                    class="btn bg-gradient-to-r from-orange-500 to-red-500 text-white px-6 py-2 rounded-xl font-semibold hover:from-orange-600 hover:to-red-600 transition-all duration-300"
                                                    onclick="document.getElementById('review_modal').showModal()">
                                                    Viết đánh giá
                                                </button>
                                            </div>

                                            <!-- Modal -->
                                            <dialog id="review_modal" class="modal">
                                                <div class="modal-box max-w-2xl w-full rounded-xl">
                                                    <div class="flex items-center justify-between mb-4">
                                                        <h3 class="text-2xl font-bold text-gray-800">Viết đánh giá</h3>
                                                        <form method="dialog">
                                                            <button class="btn btn-sm btn-circle btn-ghost">✕</button>
                                                        </form>
                                                    </div>

                                                    <form id="ratingForm" method="POST" class="space-y-6">
                                                        <input type="hidden" name="product_id" value="{{$product->id}}">
                                                    <!-- Rating -->
                                                        <div>
                                                            <label class="block text-sm font-medium text-gray-700 mb-2">Đánh giá của bạn</label>
                                                            <div class="flex space-x-1">
                                                                <div class="rating rating-sm">
                                                                    @for ($i = 1; $i <= 5; $i++)
                                                                        <input type="radio"
                                                                               name="rating"
                                                                               value="{{ $i }}"
                                                                               class="mask mask-star-2 bg-orange-400"
                                                                               required
                                                                        >
                                                                    @endfor
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Comment -->
                                                        <div>
                                                            <label class="block text-sm font-medium text-gray-700 mb-2">Nhận xét</label>
                                                            <textarea name="comment" rows="4" required
                                                                      class="textarea textarea-bordered w-full resize-none"
                                                                      placeholder="Chia sẻ trải nghiệm của bạn về sản phẩm..."></textarea>
                                                        </div>

                                                        <!-- Footer buttons -->
                                                        <div class="flex justify-end space-x-3 pt-4 mt-4">
                                                            <button type="submit" class="btn bg-gradient-to-r from-orange-500 to-red-500 text-white px-6 py-2 rounded-xl font-semibold hover:from-orange-600 hover:to-red-600 transition-all duration-300">
                                                                Gửi đánh giá
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                                <form method="dialog" class="modal-backdrop">
                                                    <button>close</button>
                                                </form>
                                            </dialog>

                                            <dialog id="editRatingModal" class="modal">
                                                <div class="modal-box max-w-2xl w-full rounded-xl">
                                                    <div class="flex items-center justify-between mb-4">
                                                        <h3 class="text-2xl font-bold text-gray-800">Chỉnh sửa đánh giá</h3>
                                                        <form method="dialog">
                                                            <button class="btn btn-sm btn-circle btn-ghost" id="cancelEditBtn">✕</button>
                                                        </form>
                                                    </div>

                                                    <div id="editRatingForm" class="space-y-6">
                                                        <input type="hidden" name="rating_id" id="editRatingId">
                                                        <input type="hidden" name="product_id" id="editProductId" value="{{ $product->id }}">

                                                        <!-- Rating -->
                                                        <div>
                                                            <label class="block text-sm font-medium text-gray-700 mb-2">Đánh giá của bạn</label>
                                                            <div class="flex space-x-1">
                                                                <div class="rating rating-sm" id="editStars">
                                                                    @for ($i = 1; $i <= 5; $i++)
                                                                        <input type="radio"
                                                                               name="rating"
                                                                               value="{{ $i }}"
                                                                               class="mask mask-star-2 bg-orange-400"
                                                                               required
                                                                        >
                                                                    @endfor
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Comment -->
                                                        <div>
                                                            <label class="block text-sm font-medium text-gray-700 mb-2">Nhận xét</label>
                                                            <textarea name="comment" id="editComment" rows="4" required
                                                                      class="textarea textarea-bordered w-full resize-none"
                                                                      placeholder="Chia sẻ trải nghiệm của bạn về sản phẩm..."></textarea>
                                                        </div>

                                                        <!-- Footer -->
                                                        <div class="flex justify-end space-x-3 pt-4 mt-4">
                                                            <button  id="submitEditBtn" class="btn bg-gradient-to-r from-orange-500 to-red-500 text-white px-6 py-2 rounded-xl font-semibold hover:from-orange-600 hover:to-red-600 transition-all duration-300">
                                                                Cập nhật đánh giá
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <form method="dialog" class="modal-backdrop">
                                                    <button>close</button>
                                                </form>
                                            </dialog>

                                            <dialog id="deleteRatingModal" class="modal">
                                                <div class="modal-box rounded-xl max-w-md text-center">
                                                    <h3 class="font-bold text-lg text-gray-800 mb-4">Xác nhận xoá đánh giá</h3>
                                                    <p class="text-sm text-gray-600 mb-6">Bạn có chắc chắn muốn xoá đánh giá này không?</p>

                                                    <input type="hidden" id="deleteRatingId">

                                                    <div class="flex justify-center space-x-4">
                                                        <button id="confirmDeleteBtn" class="btn bg-red-600 text-white hover:bg-red-700">Xoá</button>
                                                        <button id="cancelDeleteBtn" class="btn btn-ghost">Huỷ</button>
                                                    </div>
                                                </div>
                                                <form method="dialog" class="modal-backdrop">
                                                    <button>close</button>
                                                </form>
                                            </dialog>
                                        </div>
                                    </div>


                                    <div class="space-y-6">
                                        <h4 class="text-lg font-semibold text-gray-900">Đánh giá từ khách hàng</h4>
                                        <div id="reviewsContainer" class="space-y-4"></div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    @vite(['resources/assets/js/product-detail.js'])
@endpush
