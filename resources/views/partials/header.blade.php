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
                        if (Auth::check()) {
                             $cartCount = \App\Models\CartItem::where('user_id', Auth::id())->count();
                        } else {
                             $cartCount = count(session('cart', []));
                        }
                    @endphp

                    <span id="cart-count" class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                        {{ $cartCount }}
                    </span>
                </a>

                {{-- User --}}
                @auth
                    <details class="dropdown">
                        <summary class="m-1 flex items-center space-x-3 cursor-pointer">
                            <div class="avatar">
                                <div class="ring-primary ring-offset-base-100 w-9 rounded-full ring-2 ring-offset-2">
                                    <img src="{{ Auth::user()->image ?? 'https://images.pexels.com/photos/1239291/pexels-photo-1239291.jpeg?auto=compress&cs=tinysrgb&w=200' }}" />
                                </div>
                            </div>
                            <span class="text-base font-medium text-gray-800">{{ Auth::user()->username }}</span>
                        </summary>


                        <ul class="menu dropdown-content bg-base-100 rounded-box z-1 w-52 p-2 shadow-sm">
                            <li>
                                <a href="{{ route('account', ['tab' => 'profile'])}}"
                                   class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    Hồ sơ
                                </a>
                            </li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button
                                    type="submit"
                                    class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:rounded-lg"
                                >
                                    Đăng xuất
                                </button>
                            </form>
                        </ul>
                    </details>
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
                    <svg id="menuIcon" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg id="closeIcon" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
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

@push('scripts')
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
@endpush

