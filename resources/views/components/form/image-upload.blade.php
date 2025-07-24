@props(['name', 'label' => '', 'value' => null, 'productId' => null])
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
            @foreach ($value as $index => $image)
                @php
                    $imageId = $image['id'] ?? $image['image_id'] ?? $index;
                    $imagePath = $image['path'] ?? $image['image_path'] ?? $image;
                @endphp
                <div class="relative group" data-image-id="{{ $imageId }}">
                    <img src="{{ asset('storage/' . $imagePath) }}" alt="Ảnh"
                         class="w-full h-32 object-cover rounded-2xl" />
                    <button type="button"
                            class="delete-image-btn absolute top-1 right-1 bg-red-500 text-white p-1 rounded-full text-xs cursor-pointer hover:bg-red-600 hidden group-hover:block"
                            data-image-id="{{ $imageId }}"
                            data-image-path="{{ $imagePath }}"
                            data-product-id="{{ $productId }}">
                        &times;
                    </button>
                    <input type="hidden" name="existing_images[]" value="{{ $imagePath }}" data-image-id="{{ $imageId }}">
                </div>
            @endforeach
        @endif
    </div>

    {{-- Loading indicator --}}
    <div id="deleteLoader" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white p-4 rounded-lg">
            <div class="flex items-center space-x-2">
                <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-orange-500"></div>
                <span>Đang xóa...</span>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const input = document.getElementById('imageInput');
            const container = document.getElementById('imageContainer');
            const deleteLoader = document.getElementById('deleteLoader');

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

            // Handle existing image deletion via API
            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('delete-image-btn')) {
                    e.preventDefault();

                    const imageId = e.target.dataset.imageId;
                    const productId = e.target.dataset.productId;
                    const imageWrapper = e.target.closest('[data-image-id]');

                    if (!imageId || !productId) {
                        showNotification('Thông tin hình ảnh không hợp lệ', 'error');
                        return;
                    }

                    if (confirm('Bạn có chắc chắn muốn xóa hình ảnh này?')) {
                        deleteImage(imageId, productId, imageWrapper);
                    }
                }
            });

            function deleteImage(imageId, productId, imageWrapper) {
                deleteLoader.classList.remove('hidden');

                const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
                    || document.querySelector('input[name="_token"]')?.value;

                fetch(`/products/${productId}/images/${imageId}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token,
                        'Accept': 'application/json',
                    }
                })
                    .then(response => {
                        return response.json();
                    })
                    .then(data => {
                        deleteLoader.classList.add('hidden');

                        if (data.success) {
                            if (imageWrapper) {

                                setTimeout(() => {
                                    imageWrapper.remove();

                                    document.querySelectorAll(`div[data-image-id="${imageId}"]`).forEach(input => {
                                        input.remove();
                                    });

                                }, 300);
                            }

                        }
                    })
                    .catch(error => {
                        deleteLoader.classList.add('hidden');
                        console.error('Error:', error);
                    });
            }
        });
    </script>
@endpush
