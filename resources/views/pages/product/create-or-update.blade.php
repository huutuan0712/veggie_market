@extends('layouts.app')

@section('content')
    <div class="min-h-screen py-20 bg-gradient-to-br from-orange-50 via-white to-green-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Header --}}
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h1 class="text-3xl lg:text-4xl font-bold text-gray-900">
                        {{ isset($product->id) ? 'Chỉnh sửa sản phẩm' : 'Thêm sản phẩm mới' }}
                    </h1>
                    <p class="text-gray-600 mt-2">
                        {{ isset($product->id) ? 'Cập nhật thông tin sản phẩm' : 'Tạo sản phẩm mới cho cửa hàng' }}
                    </p>
                </div>
                <a href="{{ route('dashboard') }}" class="inline-flex items-center space-x-2 text-gray-600 hover:text-orange-600 transition-colors">
                    <x-heroicon-o-arrow-left class="h-5 w-5" />
                    <span>Quay lại Dashboard</span>
                </a>
            </div>

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                    <strong>Đã có lỗi xảy ra:</strong>
                    <ul class="mt-2 list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif


            <form action="{{ isset($product->id) ? route('products.update', $product->id) : route('products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @if(isset($product->id)) @method('PUT') @endif

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    {{-- Main Form --}}
                    <div class="lg:col-span-2 space-y-6">
                        {{-- Basic Info --}}
                        <div class="bg-white rounded-3xl shadow-lg p-8">
                            <h2 class="text-xl font-bold text-gray-900 mb-6">Thông tin cơ bản</h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="md:col-span-2">
                                    <x-form.input name="name" label="Tên sản phẩm *" value="{{ old('name', $product->name ?? '') }}" required />
                                </div>
                                <x-form.input name="price" label="Giá bán *" type="number" value="{{ old('price', $product->price ?? '') }}" required />
                                <x-form.input name="original_price" label="Giá gốc (tùy chọn)" type="number" value="{{ old('original_price', $product->original_price ?? '') }}" />
                                <x-form.select name="category_id" label="Danh mục *" :options="$categories" value="{{ old('category', $product->category_id ?? '') }}" required />
                                <x-form.input name="stock" type="number" label="Số lượng *" value="{{ old('stock', $product->stock ?? '') }}" required />
                                <x-form.input name="unit" label="Đơn vị *" value="{{ old('unit', $product->unit ?? '') }}" required />
                                <div class="md:col-span-2">
                                    <x-form.textarea name="description" label="Mô tả sản phẩm *" rows="4" value="{{ old('description', $product->description ?? '') }}" required />
                                </div>
                            </div>
                        </div>

                        {{-- Benefits --}}
                        @include('components.form.benefits')

                        {{-- Settings --}}
                        <div class="bg-white rounded-3xl shadow-lg p-8">
                            <div class="space-y-2">
                                <h2 class="text-xl font-bold text-gray-900 mb-6">Cài đặt</h2>
                                @php
                                    use App\Enums\ProductStatus;
                                    $isInStock = old('status', $product->status ?? ProductStatus::IN_STOCK) == ProductStatus::IN_STOCK;
                                    $isFeatured = old('featured', $product->featured ?? false);
                                @endphp

                                <input type="hidden" name="status" id="statusInput" value="{{ $isInStock ? ProductStatus::IN_STOCK : ProductStatus::OUT_STOCK }}">

                                <div class="flex items-center justify-between">
                                    <div>
                                        <div class="font-medium text-gray-900">Còn hàng</div>
                                        <div class="text-sm text-gray-600 mt-1 mb-4">Sản phẩm có sẵn để bán</div>
                                    </div>
                                    <label class="relative inline-flex h-6 w-11 items-center rounded-full cursor-pointer">
                                        <input
                                            type="checkbox"
                                            id="toggleInStock"
                                            class="sr-only peer"
                                            {{ $isInStock ? 'checked' : '' }}
                                        >
                                        <span class="absolute h-6 w-11 rounded-full transition-colors bg-gray-300 peer-checked:bg-green-500"></span>
                                        <span class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform peer-checked:translate-x-6 translate-x-1"></span>
                                    </label>
                                </div>

                                <input type="hidden" name="featured" id="featuredInput" value="{{ $isFeatured ? 1 : 0 }}">

                                <div class="flex items-center justify-between">
                                    <div>
                                        <div class="font-medium text-gray-900">Sản phẩm nổi bật</div>
                                        <div class="text-sm text-gray-600 mt-1">Hiển thị trong danh sách nổi bật</div>
                                    </div>
                                    <label class="relative inline-flex h-6 w-11 items-center rounded-full cursor-pointer">
                                        <input
                                            type="checkbox"
                                            id="toggleFeatured"
                                            class="sr-only peer"
                                            {{ $isFeatured ? 'checked' : '' }}
                                        >
                                        <span class="absolute h-6 w-11 rounded-full transition-colors bg-gray-300 peer-checked:bg-orange-500"></span>
                                        <span class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform peer-checked:translate-x-6 translate-x-1"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Sidebar --}}
                    <div class="lg:col-span-1 space-y-6">
                        {{-- Image Upload --}}
                        <x-form.image-upload name="images" label="Hình ảnh sản phẩm" :value="$product->images ?? null" />

                        {{-- Actions --}}
                        <div class="bg-white rounded-3xl shadow-lg p-6">
                            <div class="space-y-3">
                                <x-form.submit class="w-full">{{ isset($product->id) ? 'Cập nhật' : 'Lưu sản phẩm' }}</x-form.submit>
                                <a href="{{ route('dashboard') }}" class="w-full border-2 border-gray-300 text-gray-700 py-3 rounded-2xl font-semibold hover:bg-gray-50 transition-all duration-300 flex items-center justify-center">Hủy</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const checkbox = document.getElementById('toggleInStock');
            const statusInput = document.getElementById('statusInput');

            checkbox.addEventListener('change', function () {
                statusInput.value = this.checked ? '{{ \App\Enums\ProductStatus::IN_STOCK->value }}' : '{{ \App\Enums\ProductStatus::OUT_STOCK->value }}';
            });

            const checkboxFeatured = document.getElementById('toggleFeatured');
            const hiddenInput = document.getElementById('featuredInput');

            checkboxFeatured.addEventListener('change', function () {
                hiddenInput.value = this.checked ? '1' : '0';
            });
        });
    </script>
@endpush
