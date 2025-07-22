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
                            <option value="tat-ca" @selected($selectedCategory === 'tat-ca')>Tất cả</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->slug }}" @selected($selectedCategory === $cat->slug)>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </form>

            {{-- Product Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                @forelse($products->data as $product)
                    <x-product-card :product="$product" />
                @empty
                    <div class="col-span-full text-center py-20">
                        <div class="text-gray-400 text-6xl mb-4">🔍</div>
                        <h3 class="text-2xl font-semibold text-gray-600 mb-2">Không tìm thấy sản phẩm</h3>
                        <p class="text-gray-500">Thử thay đổi từ khóa tìm kiếm hoặc danh mục</p>
                    </div>
                @endforelse
            </div>
            @if ($products->meta['last_page'] > 1)
                <x-pagination :meta="$products->meta" />
            @endif
        </div>
    </div>
@endsection
@push('scripts')
    @vite(['resources/assets/js/product.js'])
@endpush

