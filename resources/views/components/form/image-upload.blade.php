@props(['name', 'label' => '', 'value' => null])
<div>
    @if ($label)
        <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ $label }}</h3>
    @endif
    <div class="space-y-4">
        @if ($value)
            <div class="relative">
                <img src="{{ $value }}" class="w-full h-48 object-cover rounded-2xl" alt="Preview">
                <button type="submit" name="remove_image" value="1" class="absolute top-2 right-2 bg-red-500 text-white p-2 rounded-full hover:bg-red-600 transition-colors">&times;</button>
            </div>
        @else
            <div class="border-2 border-dashed border-gray-300 rounded-2xl p-8 text-center">
                <p class="text-gray-600 mb-4">Chọn hình ảnh sản phẩm</p>
                <label class="bg-orange-500 text-white px-4 py-2 rounded-xl hover:bg-orange-600 transition-colors cursor-pointer">
                    Tải lên
                    <input type="file" name="{{ $name }}" accept="image/*" class="hidden">
                </label>
            </div>
        @endif
    </div>
</div>
