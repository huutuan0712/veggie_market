<div class="bg-white rounded-3xl shadow-lg p-8">
    <h2 class="text-2xl font-bold text-gray-900 mb-6">Bảo mật tài khoản</h2>

    <div class="space-y-6">
        <!-- Đổi mật khẩu -->
        <div class="border border-gray-200 rounded-2xl p-6">
            <h3 class="font-semibold text-gray-900 mb-2">Đổi mật khẩu</h3>
            <p class="text-gray-600 mb-4">Cập nhật mật khẩu để bảo vệ tài khoản</p>

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

            <form action="{{ route('account.password.update') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label for="current_password" class="block text-sm font-medium text-gray-700 mb-1">Mật khẩu hiện tại</label>
                    <input type="password" name="current_password" id="current_password"
                           class="w-full px-4 py-2 border rounded-xl border-gray-200 focus:ring-2 focus:ring-orange-500 focus:outline-none" required>
                </div>

                <div>
                    <label for="new_password" class="block text-sm font-medium text-gray-700 mb-1">Mật khẩu mới</label>
                    <input type="password" name="new_password" id="new_password"
                           class="w-full px-4 py-2 border rounded-xl border-gray-200 focus:ring-2 focus:ring-orange-500 focus:outline-none" required>
                </div>

                <div>
                    <label for="new_password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Xác nhận mật khẩu mới</label>
                    <input type="password" name="new_password_confirmation" id="new_password_confirmation"
                           class="w-full px-4 py-2 border rounded-xl border-gray-200 focus:ring-2 focus:ring-orange-500 focus:outline-none" required>
                </div>

                <div class="pt-4">
                    <button type="submit"
                            class="bg-gradient-to-r from-orange-500 to-red-500 text-white px-6 py-2 rounded-xl font-semibold hover:from-orange-600 hover:to-red-600 transition-all duration-300">
                        Cập nhật mật khẩu
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
