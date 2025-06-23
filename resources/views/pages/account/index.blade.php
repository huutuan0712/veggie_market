@extends('layouts.app')

@section('content')
    <!-- resources/views/account.blade.php -->
    <div class="min-h-screen py-20 bg-gradient-to-br from-orange-50 via-white to-green-50">
        <div class="max-w-7xl mx-auto pt-4 px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h1 class="text-3xl lg:text-4xl font-bold text-gray-900">Tài khoản của tôi</h1>
                    <p class="text-gray-600 mt-2">Quản lý thông tin cá nhân và đơn hàng</p>
                </div>
                <a href="{{ route('home') }}" class="inline-flex items-center space-x-2 text-gray-600 hover:text-orange-600 transition-colors">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                    </svg>
                    <span>Về trang chủ</span>
                </a>
            </div>

            <!-- Success Message -->
            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-2xl mb-6">
                    {{ session('success') }}
                </div>
        @endif

        <!-- Tabs -->
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                <!-- Sidebar -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-3xl shadow-lg p-6">
                        <!-- Avatar -->
                        <div class="text-center mb-6">
                            <div class="relative inline-block">
                                <img src="{{ Auth::user()->image ?? 'https://images.pexels.com/photos/1239291/pexels-photo-1239291.jpeg?auto=compress&cs=tinysrgb&w=200' }}" alt="Avatar" class="w-20 h-20 rounded-full object-cover border-4 border-orange-100" />
                            </div>
                            <h3 class="font-semibold text-gray-900 mt-3">{{ Auth::user()->username }}</h3>
                            <p class="text-gray-600 text-sm">{{ Auth::user()->email }}</p>
                        </div>

                        <!-- Navigation -->
                        <nav class="space-y-2">
                            <a href="?tab=profile" class="block w-full px-4 py-3 rounded-xl text-left {{ request('tab', 'profile') == 'profile' ? 'bg-orange-50 text-orange-600 border border-orange-200' : 'text-gray-600 hover:bg-gray-50' }}">
                                Thông tin cá nhân
                            </a>
                            <a href="?tab=orders" class="block w-full px-4 py-3 rounded-xl text-left {{ request('tab') == 'orders' ? 'bg-orange-50 text-orange-600 border border-orange-200' : 'text-gray-600 hover:bg-gray-50' }}">
                                Đơn hàng
                            </a>
                            <a href="?tab=favorites" class="block w-full px-4 py-3 rounded-xl text-left {{ request('tab') == 'favorites' ? 'bg-orange-50 text-orange-600 border border-orange-200' : 'text-gray-600 hover:bg-gray-50' }}">
                                Yêu thích
                            </a>
                            <a href="?tab=security" class="block w-full px-4 py-3 rounded-xl text-left {{ request('tab') == 'security' ? 'bg-orange-50 text-orange-600 border border-orange-200' : 'text-gray-600 hover:bg-gray-50' }}">
                                Bảo mật
                            </a>
                        </nav>
                    </div>
                </div>

                <!-- Content -->
                <div class="lg:col-span-3">
                    @if(request('tab', 'profile') === 'profile')
                        @include('pages.account.tabs.profile')
                    @elseif(request('tab') === 'orders')
                        @include('pages.account.tabs.orders')
                    @elseif(request('tab') === 'favorites')
                        @include('pages.account.tabs.favorites')
                    @elseif(request('tab') === 'security')
                        @include('pages.account.tabs.security')
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection
