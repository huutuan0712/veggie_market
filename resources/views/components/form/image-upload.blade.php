@props(['name', 'label' => '', 'value' => null])
<div>
    @if ($label)
        <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ $label }}</h3>
    @endif

    {{-- Nút tải ảnh --}}
    <div class="border-2 border-dashed border-gray-300 rounded-2xl p-8 text-center">
        <p class="text-gray-600 mb-4">Chọn hình ảnh sản phẩm</p>
        <label class="bg-orange-500 text-white px-4 py-2 rounded-xl hover:bg-orange-600 transition-colors cursor-pointer">
            Tải lên
            <input type="file" name="{{ $name }}[]" id="imageInput" multiple accept="image/*" class="hidden">
        </label>
    </div>

    {{-- Container chứa cả ảnh cũ và ảnh mới --}}
    <div id="imageContainer" class="grid grid-cols-2 md:grid-cols-3 gap-4 mt-4">
        {{-- Ảnh đã có --}}
        @if (is_array($value))
            @foreach ($value as $image)
                <div class="relative group">
                    <img src="{{ asset('storage/' . $image['path']) }}" alt="Ảnh"
                         class="w-full h-32 object-cover rounded-2xl" />
                    <button type="submit" name="remove_image_ids[]" value="{{ $image['id'] }}"
                            class="absolute top-1 right-1 bg-red-500 text-white p-1 rounded-full text-xs cursor-pointer hover:bg-red-600 hidden group-hover:block">
                        &times;
                    </button>
                    <input type="hidden" name="existing_images[]" value="{{ $image['path'] }}">
                </div>
            @endforeach
        @endif
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const input = document.getElementById('imageInput');
            const container = document.getElementById('imageContainer');

            input?.addEventListener('change', function () {
                Array.from(this.files).forEach(file => {
                    const reader = new FileReader();

                    reader.onload = function (e) {
                        const wrapper = document.createElement('div');
                        wrapper.className = 'relative group';

                        wrapper.innerHTML = `
                            <img src="${e.target.result}" class="w-full h-32 object-cover rounded-2xl" />
                            <div class="absolute top-1 right-1 bg-red-500 text-white p-1 rounded-full text-xs cursor-pointer hover:bg-red-600 hidden group-hover:block">&times;</div>
                        `;

                        wrapper.querySelector('div').addEventListener('click', () => {
                            wrapper.remove();
                        });

                        container.appendChild(wrapper);
                    };

                    reader.readAsDataURL(file);
                });
            });
        });
    </script>
@endpush
