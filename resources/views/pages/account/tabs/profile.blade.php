<div class="bg-white rounded-3xl shadow-lg p-8">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold text-gray-900">Thông tin cá nhân</h2>
        <button id="toggleEdit"
                class="flex items-center space-x-2 text-orange-600 hover:text-orange-700 transition-colors">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 20h9" />
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M16.5 3.5a2.121 2.121 0 013 3L7 19l-4 1 1-4 12.5-12.5z" />
            </svg>
            <span id="editLabel">Chỉnh sửa</span>
        </button>
    </div>
    @if (session('status'))
        <div class="text-green-600 mb-4">{{ session('status') }}</div>
    @endif

    @if ($errors->any())
        <div class="text-red-600 mb-4">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form method="POST" action="{{ route('account.update') }}">
        @method('PUT')
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Họ và tên</label>
                <input type="text" name="name" value="{{ old('name', $profile->name) }}"
                       data-editable disabled
                       class="w-full px-4 py-3 border border-gray-200 rounded-xl bg-gray-50 focus:ring-2 focus:ring-orange-500" />
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                <input type="email" name="email" value="{{ old('email', $profile->email) }}"
                       data-editable disabled
                       class="w-full px-4 py-3 border border-gray-200 rounded-xl bg-gray-50 focus:ring-2 focus:ring-orange-500" />
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Số điện thoại</label>
                <input type="tel" name="phone" value="{{ old('phone', $profile->phone) }}"
                       data-editable disabled
                       class="w-full px-4 py-3 border border-gray-200 rounded-xl bg-gray-50 focus:ring-2 focus:ring-orange-500" />
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Ngày sinh</label>
                <input type="date" name="date_of_birth" value="{{ old('date_of_birth', $profile->date_of_birth) }}"
                       data-editable disabled
                       class="w-full px-4 py-3 border border-gray-200 rounded-xl bg-gray-50 focus:ring-2 focus:ring-orange-500" />
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Giới tính</label>
                <select name="gender" data-editable disabled
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl bg-gray-50 focus:ring-2 focus:ring-orange-500">
                    <option value="Nam" {{ $profile->gender === 'Nam' ? 'selected' : '' }}>Nam</option>
                    <option value="Nữ" {{ $profile->gender === 'Nữ' ? 'selected' : '' }}>Nữ</option>
                    <option value="Khác" {{ $profile->gender === 'Khác' ? 'selected' : '' }}>Khác</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tỉnh/Thành phố</label>
                <select name="city" data-editable disabled
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl bg-gray-50 focus:ring-2 focus:ring-orange-500">
                    <option value="TP. Hồ Chí Minh" {{ $profile->city === 'TP. Hồ Chí Minh' ? 'selected' : '' }}>TP. Hồ Chí Minh</option>
                    <option value="Hà Nội" {{ $profile->city === 'Hà Nội' ? 'selected' : '' }}>Hà Nội</option>
                    <option value="Đà Nẵng" {{ $profile->city === 'Đà Nẵng' ? 'selected' : '' }}>Đà Nẵng</option>
                    <option value="Cần Thơ" {{ $profile->city === 'Cần Thơ' ? 'selected' : '' }}>Cần Thơ</option>
                </select>
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Địa chỉ</label>
                <textarea name="address" rows="3" data-editable disabled
                          class="w-full px-4 py-3 border border-gray-200 rounded-xl bg-gray-50 focus:ring-2 focus:ring-orange-500">{{ old('address', $profile->address) }}</textarea>
            </div>
        </div>

        <div class="flex justify-end mt-8 hidden" id="saveSection">
            <button type="submit"
                    class="bg-gradient-to-r from-orange-500 to-red-500 text-white px-8 py-3 rounded-2xl font-semibold hover:from-orange-600 hover:to-red-600 transition-all duration-300">
                Lưu thay đổi
            </button>
        </div>
    </form>
</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toggleBtn = document.getElementById('toggleEdit');
            const editLabel = document.getElementById('editLabel');
            const editableFields = document.querySelectorAll('[data-editable]');
            const saveSection = document.getElementById('saveSection');

            let isEditing = false;

            toggleBtn.addEventListener('click', function () {
                isEditing = !isEditing;

                editableFields.forEach(el => {
                    el.disabled = !isEditing;
                    el.classList.toggle('bg-gray-50', !isEditing);
                });

                saveSection.classList.toggle('hidden', !isEditing);
                editLabel.innerText = isEditing ? 'Hủy' : 'Chỉnh sửa';
            });
        });
    </script>
@endpush
