<header class="fixed top-0 left-0 right-0 z-50 bg-white/95 backdrop-blur-md shadow-lg border-b border-orange-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">

            {{-- Logo --}}
            <a href="{{ route('home') }}" class="flex items-center space-x-2">
                <div class="bg-gradient-to-r from-orange-500 to-red-500 p-2 rounded-xl">
                    <x-heroicon-s-cube class="h-6 w-6 text-white" />
                </div>
                <span class="text-xl font-bold bg-gradient-to-r from-orange-600 to-red-600 bg-clip-text text-transparent">
                    Fresh Fruits
                </span>
            </a>

            {{-- Desktop Navigation --}}
            <nav class="hidden md:flex items-center space-x-8">
                <a href="{{ route('home') }}" class="text-gray-700 hover:text-orange-600 font-medium transition-colors">
                    Trang chủ
                </a>
                <a href="{{ route('products.index') }}" class="text-gray-700 hover:text-orange-600 font-medium transition-colors">
                    Trái cây
                </a>
            </nav>

            {{-- Actions --}}
            <div class="flex items-center space-x-4">

                {{-- Cart --}}
                <a href="{{ route('cart.index') }}" class="relative p-2 text-gray-700 hover:text-orange-600 transition-colors">
                    <x-heroicon-o-shopping-cart class="h-6 w-6" />
                    @php
                        $cartCount = session('cart') ? collect(session('cart'))->sum('quantity') : 0;
                    @endphp
                    @if($cartCount > 0)
                        <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                            {{ $cartCount }}
                        </span>
                    @endif
                </a>

                {{-- User --}}
                @auth
                    <div class="flex items-center space-x-2">
                        <span class="hidden sm:block text-sm text-gray-700">
                            {{ Auth::user()->name }}
                        </span>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button
                                class="bg-gradient-to-r from-orange-500 to-red-500 text-white px-4 py-2 rounded-lg hover:from-orange-600 hover:to-red-600 transition-all duration-300 text-sm font-medium"
                            >
                                Đăng xuất
                            </button>
                        </form>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="flex items-center space-x-1 text-gray-700 hover:text-orange-600 transition-colors">
                        <x-heroicon-o-user class="h-5 w-5" />
                        <span class="hidden sm:block">Đăng nhập</span>
                    </a>
                @endauth

                {{-- Mobile Menu Button --}}
                <button
                    id="mobileMenuToggle"
                    class="md:hidden p-2 text-gray-700 hover:text-orange-600 transition-colors"
                >
{{--                    <x-heroicon-o-menu id="menuIcon" class="h-6 w-6 block" />--}}
{{--                    <x-heroicon-o-x id="closeIcon" class="h-6 w-6 hidden" />--}}
                </button>
            </div>
        </div>

        {{-- Mobile Navigation --}}
        <div id="mobileNav" class="hidden md:hidden py-4 border-t border-orange-100">
            <nav class="flex flex-col space-y-2">
                <a
                    href="{{ route('home') }}"
                    class="px-4 py-2 text-gray-700 hover:text-orange-600 hover:bg-orange-50 rounded-lg transition-colors"
                >
                    Trang chủ
                </a>
                <a
                    href="#"
                    class="px-4 py-2 text-gray-700 hover:text-orange-600 hover:bg-orange-50 rounded-lg transition-colors"
                >
                    Trái cây
                </a>
            </nav>
        </div>
    </div>
</header>

<script>
    const toggle = document.getElementById('mobileMenuToggle');
    const menu = document.getElementById('mobileNav');
    const menuIcon = document.getElementById('menuIcon');
    const closeIcon = document.getElementById('closeIcon');

    toggle?.addEventListener('click', () => {
        menu.classList.toggle('hidden');
        menuIcon.classList.toggle('hidden');
        closeIcon.classList.toggle('hidden');
    });
</script>
