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
                    <h1 class="text-3xl font-bold text-gray-900">Quên mật khẩu</h1>
                    <p class="text-gray-600 mt-2">Nhập email để nhận hướng dẫn đặt lại mật khẩu</p>
                </div>

                {{-- Error / Success --}}
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
                <form method="POST" action="{{ route('password.request') }}" class="space-y-6">
                    @csrf

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

                    {{-- Submit --}}
                    <button
                        type="submit"
                        class="w-full bg-gradient-to-r from-orange-500 to-red-500 text-white py-3 rounded-xl font-semibold hover:from-orange-600 hover:to-red-600 transition-all duration-300"
                    >
                        Gửi hướng dẫn
                    </button>
                </form>

                {{-- Back to login --}}
                <div class="text-center mt-8 pt-6 border-t border-gray-200">
                    <a href="{{ route('login') }}" class="text-gray-600 hover:text-orange-600 font-medium inline-flex items-center space-x-2 transition-colors">
                        <x-heroicon-o-arrow-left class="h-4 w-4" />
                        <span>Quay lại đăng nhập</span>
                    </a>
                </div>

            </div>
        </div>
    </div>
@endsection
