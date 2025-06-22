@extends('layouts.app')

@section('content')
    <div class="min-h-screen py-20 bg-gradient-to-br from-orange-50 via-white to-green-50">
        <div class="max-w-lg mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-3xl shadow-2xl p-8">

                {{-- Logo --}}
                <div class="text-center mb-8">
                    <a href="{{ route('home') }}" class="flex items-center justify-center space-x-2 mb-4">
                        <div class="bg-gradient-to-r from-orange-500 to-red-500 p-2 rounded-xl">
                            <x-heroicon-s-cube class="h-6 w-6 text-white" />
                        </div>
                        <span class="text-xl font-bold bg-gradient-to-r from-orange-600 to-red-600 bg-clip-text text-transparent">
                            Fresh Fruits
                         </span>
                    </a>
                    <h1 class="text-3xl font-bold text-gray-900">Đăng ký</h1>
                    <p class="text-gray-600 mt-2">Tạo tài khoản mới</p>
                </div>

                {{-- Error Message --}}
                @if ($errors->any())
                    <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-xl mb-6">
                        <ul class="list-disc pl-5 text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}" class="space-y-6">
                    @csrf
                    {{-- Name --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Họ và tên</label>
                        <div class="relative">
                            <x-heroicon-o-user class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 h-5 w-5" />
                            <input
                                type="text"
                                name="name"
                                value="{{ old('name') }}"
                                required
                                class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                                placeholder="Nhập họ và tên"
                            />
                        </div>
                    </div>

                    {{-- Email --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <div class="relative">
                            <x-heroicon-o-envelope class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 h-5 w-5" />
                            <input
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                required
                                class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                                placeholder="Nhập email của bạn"
                            />
                        </div>
                    </div>

                    {{-- Password --}}
                    <div x-data="{ show: false }">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Mật khẩu</label>
                        <div class="relative">
                            <x-heroicon-o-lock-closed class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 h-5 w-5" />
                            <input
                                type="password"
                                name="password"
                                required
                                class="w-full pl-10 pr-12 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                                placeholder="Nhập mật khẩu"
                            />
                        </div>
                    </div>

                    {{-- Confirm Password --}}
                    <div x-data="{ show: false }">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Xác nhận mật khẩu</label>
                        <div class="relative">
                            <x-heroicon-o-lock-closed class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 h-5 w-5" />
                            <input
                                type="password"
                                name="password_confirmation"
                                required
                                class="w-full pl-10 pr-12 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                                placeholder="Nhập lại mật khẩu"
                            />
                        </div>
                    </div>

                    {{-- Submit --}}
                    <button
                        type="submit"
                        class="w-full bg-gradient-to-r from-orange-500 to-red-500 text-white py-3 rounded-xl font-semibold hover:from-orange-600 hover:to-red-600 transition-all duration-300"
                    >
                        Đăng ký
                    </button>
                </form>

                {{-- Login Link --}}
                <div class="text-center mt-8 pt-6 border-t border-gray-200">
                    <p class="text-gray-600">
                        Đã có tài khoản?
                        <a href="{{ route('login') }}" class="text-orange-600 hover:text-orange-700 font-medium">
                            Đăng nhập
                        </a>
                    </p>
                </div>

            </div>
        </div>
    </div>
@endsection
