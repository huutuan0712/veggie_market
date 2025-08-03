@extends('layouts.app')

@section('content')
    <div class="min-h-screen py-20 bg-gradient-to-br from-orange-50 via-white to-green-50">
        <div class="max-w-3xl mx-auto bg-white rounded-3xl shadow-2xl p-8">

        <h2 class="text-2xl font-bold text-gray-900 mb-6">
            {{ isset($category) ? 'Chỉnh sửa danh mục' : 'Thêm danh mục mới' }}
        </h2>

        <form method="POST" action="{{ isset($category) ? route('categories.update', $category->id) : route('categories.store') }}"
              enctype="multipart/form-data" class="space-y-6">
            @csrf
            @if(isset($category))
                @method('PUT')
            @endif

            {{-- Tên danh mục --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tên danh mục *</label>
                <input type="text" name="name" value="{{ old('name', $category->name ?? '') }}"
                       class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                       required placeholder="Nhập tên danh mục">
            </div>

            {{-- Mô tả --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Mô tả</label>
                <textarea name="description"
                          class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                          rows="3" placeholder="Mô tả về danh mục...">{{ old('description', $category->description ?? '') }}</textarea>
            </div>

            {{-- Nút hành động --}}
            <div class="flex space-x-4 pt-6">
                <button type="submit"
                        class="flex-1 bg-orange-500 hover:bg-orange-600 text-white py-3 rounded-2xl font-semibold transition">
                    {{ isset($category) ? 'Cập nhật' : 'Tạo danh mục' }}
                </button>
                <a href="{{ route('admin.dashboard', ['tab' => 'categories']) }}"
                   class="flex-1 border border-gray-300 text-gray-700 py-3 rounded-2xl font-semibold hover:bg-gray-100 text-center transition">
                    Quay lại
                </a>
            </div>
        </form>
    </div>
    </div>
@endsection
