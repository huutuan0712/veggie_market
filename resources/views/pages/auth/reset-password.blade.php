@extends('layouts.app')

@section('content')
    <div class="min-h-screen py-20 bg-gradient-to-br from-orange-50 via-white to-green-50">
        <div class="max-w-lg mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-3xl shadow-2xl p-8">

                {{-- Header --}}
                <div class="text-center mb-8">
                    <a href="{{ route('home') }}" class="flex items-center justify-center space-x-2 mb-4">
                        <div class="bg-gradient-to-r from-orange-500 to-red-500 p-2 rounded-xl">
                            <x-heroicon-s-cube class="h-6 w-6 text-white" />
                        </div>
                        <span class="text-xl font-bold bg-gradient-to-r from-orange-600 to-red-600 bg-clip-text text-transparent">
                            Fresh Fruits
                         </span>
                    </a>
                    <h1 class="text-3xl font-bold text-gray-900">Đặt lại mật khẩu</h1>
                    <p class="text-gray-600 mt-2">Nhập mật khẩu mới cho tài khoản của bạn</p>
                </div>

                {{-- Thông báo lỗi --}}
                @if (session('status'))
                    <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-6">
                        {{ session('status') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-xl mb-6">
                        @foreach ($errors->all() as $error)
                            <p class="text-sm">{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                {{-- Form --}}
                <form method="POST" action="{{ route('password.submitRest') }}" class="space-y-6" x-data="{ showPassword: false, showConfirmPassword: false }">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">
                    <input type="hidden" name="email" value="{{ $email }}">

                    {{-- Mật khẩu mới --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Mật khẩu mới
                        </label>
                        <div class="relative">
                            <input
                                type="password"
                                name="password"
                                required
                                class="w-full pl-10 pr-12 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                                placeholder="Nhập mật khẩu mới"
                            />
                        </div>
                    </div>

                    {{-- Xác nhận mật khẩu --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Xác nhận mật khẩu mới
                        </label>
                        <div class="relative">
                            <input
                                type="password"
                                name="password_confirmation"
                                required
                                class="w-full pl-10 pr-12 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                                placeholder="Nhập lại mật khẩu mới"
                            />
                        </div>
                    </div>

                    {{-- Submit --}}
                    <button
                        type="submit"
                        class="w-full bg-gradient-to-r from-orange-500 to-red-500 text-white py-3 rounded-xl font-semibold hover:from-orange-600 hover:to-red-600 transition-all duration-300"
                    >
                        Đặt lại mật khẩu
                    </button>
                </form>

                {{-- Back to login --}}
                <div class="text-center mt-8 pt-6 border-t border-gray-200">
                    <p class="text-gray-600">
                        Nhớ mật khẩu?
                        <a href="{{ route('login') }}" class="text-orange-600 hover:text-orange-700 font-medium">
                            Đăng nhập
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
