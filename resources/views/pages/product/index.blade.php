@extends('layouts.app')

@section('content')
    <div class="min-h-screen py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h1 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-4">Trái cây tươi ngon</h1>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">Khám phá bộ sưu tập trái cây đa dạng với chất lượng cao nhất</p>
            </div>

            <form method="GET" class="mb-8">
                <div class="flex flex-col lg:flex-row gap-4 items-center justify-between">
                    {{-- Search --}}
                    <div class="relative flex-1 max-w-md">
                        <x-heroicon-o-magnifying-glass class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 h-5 w-5" />
                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Tìm kiếm trái cây..."
                            class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-2xl focus:ring-2 focus:ring-orange-500"
                        />
                    </div>

                    {{-- Category --}}
                    <div class="flex items-center space-x-2">
                        <x-heroicon-o-funnel class="h-5 w-5 text-gray-600" />
                        <select
                            name="category"
                            class="px-4 py-3 border border-gray-200 rounded-2xl focus:ring-2 focus:ring-orange-500"
                            onchange="this.form.submit()"
                        >
                            @foreach($categories as $cat)
                                <option value="{{ $cat }}" @selected($selectedCategory === $cat)>
                                    {{ $cat }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </form>

            {{-- Product Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                @forelse($products as $product)
                    <div class="bg-white rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden group">
                        <div class="relative overflow-hidden">
                            <img src="{{ $product->image }}" alt="{{ $product->name }}" class="w-full h-64 object-cover group-hover:scale-110 transition-transform duration-500" />
                            @if($product->originalPrice)
                                <div class="absolute top-4 left-4 bg-red-500 text-white px-3 py-1 rounded-full text-sm font-semibold">
                                    Giảm {{ round((($product->originalPrice - $product->price) / $product->originalPrice) * 100) }}%
                                </div>
                            @endif
                            @unless($product->inStock)
                                <div class="absolute inset-0 bg-black/50 flex items-center justify-center">
                                    <span class="text-white font-semibold">Hết hàng</span>
                                </div>
                            @endunless
                        </div>
                        <div class="p-6">
                            <div class="mb-2">
                                <span class="text-sm text-orange-600 font-medium">{{ $product->category }}</span>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ $product->name }}</h3>
                            <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $product->description }}</p>

                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center space-x-2">
                                    <span class="text-2xl font-bold text-orange-600">{{ number_format($product->price) }}đ</span>
                                    @if($product->originalPrice)
                                        <span class="text-gray-400 line-through text-sm">{{ number_format($product->originalPrice) }}đ</span>
                                    @endif
                                </div>
                            </div>

                            <a
                                href="{{ route('products.show', $product->id) }}"
                                class="w-full block text-center py-3 rounded-2xl font-semibold transition-all duration-300
              {{ $product->inStock ? 'bg-gradient-to-r from-orange-500 to-red-500 text-white hover:from-orange-600 hover:to-red-600' : 'bg-gray-300 text-gray-500 cursor-not-allowed' }}"
                            >
                                {{ $product->inStock ? 'Xem chi tiết' : 'Hết hàng' }}
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-20">
                        <div class="text-gray-400 text-6xl mb-4">🔍</div>
                        <h3 class="text-2xl font-semibold text-gray-600 mb-2">Không tìm thấy sản phẩm</h3>
                        <p class="text-gray-500">Thử thay đổi từ khóa tìm kiếm hoặc danh mục</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection
