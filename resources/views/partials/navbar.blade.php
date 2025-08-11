@auth
    <nav class="bg-blue-500 text-white shadow-sm" x-data="{ open: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <!-- Logo Section -->
                <div class="flex items-center">
                    <div class="flex-shrink-0 flex items-center">
                        <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                            </path>
                        </svg>
                        <span class="ml-2 text-xl font-semibold">Print Management</span>
                    </div>

                    <!-- Desktop Navigation -->
                    <div class="hidden sm:ml-8 sm:flex sm:space-x-2">
                        <a href="{{ route('dashboard') }}" style="text-decoration: none;!important"
                            class="{{ request()->routeIs('dashboard') ? 'bg-blue-600 text-white' : 'hover:bg-blue-600 text-white' }} px-3 py-2 rounded-md text-sm font-medium transition-colors flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                                </path>
                            </svg>
                            Dashboard
                        </a>

                        @if (Auth::check() && in_array(Auth::user()->role, ['admin', 'operator']))
                            <a href="{{ route('orders.index') }}" style="text-decoration: none;!important"
                                class="{{ request()->routeIs('orders.*') ? 'bg-blue-600 text-white' : 'hover:bg-blue-600 text-white' }} px-3 py-2 rounded-md text-sm font-medium transition-colors flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                    </path>
                                </svg>
                                Pesanan
                            </a>
                        @endif

                        @if (Auth::check() && Auth::user()->role === 'admin')
                            <a href="{{ route('products.index') }}" style="text-decoration: none;!important"
                                class="{{ request()->routeIs('products.*') ? 'bg-blue-600 text-white' : 'hover:bg-blue-600 text-white' }} px-3 py-2 rounded-md text-sm font-medium transition-colors flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                                Produk
                            </a>
                        @endif

                        @if (Auth::check() && Auth::user()->role === 'admin')
                            <a href="{{ route('users.index') }}" style="text-decoration: none;!important"
                                class="{{ request()->routeIs('users.*') ? 'bg-blue-600 text-white' : 'hover:bg-blue-600 text-white' }} px-3 py-2 rounded-md text-sm font-medium transition-colors flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                                    </path>
                                </svg>
                                Pengguna
                            </a>
                        @endif

                        @if (Auth::check() && Auth::user()->role === 'admin')
                            <a href="{{ route('withdrawals.index') }}" style="text-decoration: none;!important"
                                class="{{ request()->routeIs('withdrawals.*') ? 'bg-blue-600 text-white' : 'hover:bg-blue-600 text-white' }} px-3 py-2 rounded-md text-sm font-medium transition-colors flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                    </path>
                                </svg>
                                Withdrawal
                            </a>
                        @endif
                    </div>
                </div>

                <!-- User Profile -->
                <div class="hidden sm:ml-6 sm:flex sm:items-center">
                    <div class="ml-3 relative" x-data="{ open: false }">
                        <button @click="open = !open"
                            class="flex items-center text-sm rounded-full focus:outline-none transition-all">
                            <div class="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center">
                                <span class="text-blue-600 font-medium">
                                    {{ strtoupper(substr(auth()->user()?->name ?? '', 0, 1)) }}
                                </span>
                            </div>
                            <span class="ml-2 text-white font-medium">{{ auth()->user()->name ?? '' }}</span>
                            <svg class="ml-1 h-4 w-4 text-white transform transition-transform duration-200"
                                :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                                </path>
                            </svg>
                        </button>

                        <!-- Dropdown Menu -->
                        <div x-show="open" x-transition @click.away="open = false"
                            class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-50">
                            <div class="py-1">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                            </path>
                                        </svg>
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Mobile Menu Button -->
                <div class="-mr-2 flex items-center sm:hidden">
                    <button @click="open = !open"
                        class="inline-flex items-center justify-center p-2 rounded-md text-blue-200 hover:text-white hover:bg-blue-700 focus:outline-none transition-colors">
                        <span class="sr-only">Open main menu</span>
                        <svg class="block h-6 w-6" :class="{ 'hidden': open, 'block': !open }" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                        <svg class="hidden h-6 w-6" :class="{ 'block': open, 'hidden': !open }" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div class="sm:hidden" x-show="open" x-transition>
            <div class="pt-2 pb-3 space-y-1">
                <a href="{{ route('dashboard') }}" style="text-decoration: none;!important"
                    class="{{ request()->routeIs('dashboard') ? 'bg-blue-600 text-white' : 'text-white hover:bg-blue-600' }} block px-3 py-2 rounded-md text-base no-underline font-medium transition-colors flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                        </path>
                    </svg>
                    Dashboard
                </a>

                @if (Auth::check() && in_array(Auth::user()->role, ['admin', 'operator']))
                    <a href="{{ route('orders.index') }}" style="text-decoration: none;!important"
                        class="{{ request()->routeIs('orders.*') ? 'bg-blue-600 text-white' : 'text-white hover:bg-blue-600' }} block px-3 py-2 rounded-md text-base no-underline font-medium transition-colors flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                            </path>
                        </svg>
                        Pesanan
                    </a>
                @endif

                @if (Auth::check() && Auth::user()->role === 'admin')
                    <a href="{{ route('products.index') }}" style="text-decoration: none;!important"
                        class="{{ request()->routeIs('products.*') ? 'bg-blue-600 text-white' : 'text-white hover:bg-blue-600' }} block px-3 py-2 rounded-md text-base no-underline font-medium transition-colors flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                        Produk
                    </a>
                @endif

                @if (Auth::check() && Auth::user()->role === 'admin')
                    <a href="{{ route('users.index') }}" style="text-decoration: none;!important"
                        class="{{ request()->routeIs('users.*') ? 'bg-blue-600 text-white' : 'text-white hover:bg-blue-600' }} block px-3 py-2 rounded-md text-base no-underline font-medium transition-colors flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                            </path>
                        </svg>
                        Pengguna
                    </a>
                @endif

                @if (Auth::check() && Auth::user()->role === 'admin')
                    <a href="{{ route('withdrawals.index') }}" style="text-decoration: none;!important"
                        class="{{ request()->routeIs('withdrawals.*') ? 'bg-blue-600 text-white' : 'text-white hover:bg-blue-600' }} block px-3 py-2 rounded-md text-base no-underline font-medium transition-colors flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                            </path>
                        </svg>
                        Withdrawal
                    </a>
                @endif
            </div>
            <div class="pt-4 pb-3 border-t border-blue-700">
                <div class="flex items-center px-5">
                    <div class="flex-shrink-0">
                        <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                            <span class="text-blue-600 font-medium">
                                {{ strtoupper(substr(auth()->user()?->name ?? '', 0, 1)) }}
                            </span>
                        </div>
                    </div>
                    <div class="ml-3">
                        <div class="text-base font-medium text-white">{{ auth()->user()->name ?? '' }}</div>
                        <div class="text-sm font-medium text-blue-200">{{ ucfirst(auth()->user()?->role ?? '') }}</div>
                    </div>
                </div>
                <div class="mt-3 px-2 space-y-1">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="block w-full text-left px-3 py-2 rounded-md text-base no-underline font-medium text-white hover:bg-blue-700 transition-colors flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                </path>
                            </svg>
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>
@endauth
