@php
    $images = $product->images instanceof \Illuminate\Support\Collection
                ? $product->images->toArray()
                : (array) $product->images;

    $image = !empty($images) && isset($images[0]['path'])
        ? asset('storage/' . $images[0]['path'])
        : 'https://via.placeholder.com/300x200?text=No+Image';

    $hasOriginalPrice = isset($product->original_price) && $product->original_price > $product->price;
    $inStock = $product->status === \App\Enums\ProductStatus::IN_STOCK;
@endphp


<div class="bg-white rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden group">
    <div class="relative overflow-hidden">
        <a href="{{ route('products.show', $product->id) }}">
            <img
                src="{{ $image }}"
                alt="{{ $product->name ?? 'Sản phẩm' }}"
                class="w-full h-64 object-cover group-hover:scale-110 transition-transform duration-500"
                loading="lazy"
            />
        </a>
        @if($hasOriginalPrice)
            <div class="absolute top-4 left-4 bg-red-500 text-white px-3 py-1 rounded-full text-sm font-semibold">
                Giảm {{ round((($product->original_price - $product->price) / $product->original_price) * 100) }}%
            </div>
        @endif

        @unless($inStock)
            <div class="absolute inset-0 bg-black/50 flex items-center justify-center">
                <span class="text-white font-semibold">Hết hàng</span>
            </div>
        @endunless
        <button
            id="favorite-btn-{{ $product->id }}"
            data-favorite-btn
            data-product-id="{{ $product->id }}"
            class="absolute top-4 right-4 p-2 rounded-full transition-all duration-300
                                {{ in_array($product->id, $favoriteIds ?? []) ? 'bg-red-500 text-white hover:bg-red-600' : 'bg-white/90 text-gray-600 hover:bg-white hover:text-red-500' }}"
            title="Yêu thích"
        >
            <x-heroicon-o-heart class="w-6 h-6" />
        </button>

    </div>

    <div class="p-6">
        <div class="mb-2">
            <span class="text-sm text-orange-600 font-medium">{{ $product->category->name ?? 'Chưa rõ danh mục' }}</span>
        </div>
        <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ $product->name }}</h3>
        <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $product->description }}</p>

        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center space-x-2">
                <span class="text-2xl font-bold text-orange-600">{{ number_format($product->price) }}đ</span>
                @if($hasOriginalPrice)
                    <span class="text-gray-400 line-through text-sm">{{ number_format($product->original_price) }}đ</span>
                @endif
            </div>
        </div>

        <button
            class="btn-add-to-cart w-full block text-center py-3 rounded-2xl font-semibold transition-all duration-300 cursor-pointer
            {{ $inStock ? 'bg-gradient-to-r from-orange-500 to-red-500 text-white hover:from-orange-600 hover:to-red-600' : 'bg-gray-300 text-gray-500 cursor-not-allowed' }}"
            data-id="{{ $product->id }}"
        >
            {{ $inStock ? 'Mua ngay' : 'Hết hàng' }}
        </button>
    </div>
</div>
