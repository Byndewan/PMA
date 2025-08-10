
    <nav class="bg-blue-600 text-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <!-- Logo Section -->
                <div class="flex items-center">
                    <div class="flex-shrink-0 flex items-center">
                        <svg class="h-8 w-8 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                            fill="currentColor">
                            <path
                                d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5v-4h14v4zm0-6H5v-4h14v4zm0-6H5V5h14v4z" />
                        </svg>
                        <span class="ml-2 text-xl font-bold tracking-tight">Print Management</span>
                    </div>

                    <!-- Desktop Navigation -->
                    <div class="hidden sm:ml-8 sm:flex sm:space-x-4">
                        <a href="{{ route('dashboard') }}"
                            class="{{ request()->routeIs('dashboard') ? 'bg-white' : 'hover:bg-white' }} px-3 py-2 rounded-md text-sm font-medium text-blue-600 transition-colors duration-200">
                            <i class="fas fa-tachometer-alt mr-2"></i> Dashboard
                        </a>

                        {{-- @can('viewAny', App\Models\Order::class) --}}
                            <a href="{{ route('orders.index') }}"
                                class="{{ request()->routeIs('orders.*') ? 'bg-white' : 'hover:bg-white' }} px-3 py-2 rounded-md text-sm font-medium text-blue-600 transition-colors duration-200">
                                <i class="fas fa-clipboard-list mr-2"></i> Pesanan
                            </a>
                        {{-- @endcan --}}

                        {{-- @can('viewAny', App\Models\Product::class) --}}
                            <a href="{{ route('products.index') }}"
                                class="{{ request()->routeIs('products.*') ? 'bg-white' : 'hover:bg-white' }} px-3 py-2 rounded-md text-sm font-medium text-blue-600 transition-colors duration-200">
                                <i class="fas fa-boxes mr-2"></i> Produk
                            </a>
                        {{-- @endcan --}}

                        {{-- @can('viewAny', App\Models\User::class) --}}
                            <a href="{{ route('users.index') }}"
                                class="{{ request()->routeIs('users.*') ? 'bg-white' : 'hover:bg-white' }} px-3 py-2 rounded-md text-sm font-medium text-blue-600 transition-colors duration-200">
                                <i class="fas fa-users mr-2"></i> Pengguna
                            </a>
                        {{-- @endcan --}}

                        {{-- @can('viewAny', App\Models\Withdrawal::class) --}}
                            <a href="{{ route('withdrawals.index') }}"
                                class="{{ request()->routeIs('withdrawals.*') ? 'bg-white' : 'hover:bg-white' }} px-3 py-2 rounded-md text-sm font-medium text-blue-600 transition-colors duration-200">
                                <i class="fas fa-money-bill-wave mr-2"></i> Withdrawal
                            </a>
                        {{-- @endcan --}}
                    </div>
                </div>

                <!-- User Profile -->
                <div class="hidden sm:ml-6 sm:flex sm:items-center">
                    <div class="ml-3 relative" x-data="{ open: false }">
                        <button @click="open = !open"
                            class="flex items-center text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-blue-600 focus:ring-white transition-all">
                            <div class="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center">
                                <span class="text-blue-600 font-medium">
                                    {{ strtoupper(substr(auth()->user()?->name ?? '', 0, 1)) }}
                                </span>
                            </div>
                            <span class="ml-2 text-white font-medium">{{ auth()->user()->name ?? '' }}</span>
                            <svg class="ml-1 h-4 w-4 text-white transform transition-transform duration-200"
                                :class="{ 'rotate-180': open }" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>

                        <!-- Dropdown Menu -->
                        <div x-show="open" x-transition @click.away="open = false"
                            class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-50">
                            <div class="py-1">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors">
                                        <i class="fas fa-sign-out-alt mr-2"></i> Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Mobile Menu Button -->
                <div class="-mr-2 flex items-center sm:hidden">
                    <button @click="open = !open"
                        class="inline-flex items-center justify-center p-2 rounded-md text-blue-200 hover:text-white hover:bg-white focus:outline-none transition-colors">
                        <span class="sr-only">Open main menu</span>
                        <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div class="sm:hidden" x-show="open" x-transition @click.away="open = false">
            <div class="pt-2 pb-3 space-y-1">
                <a href="{{ route('dashboard') }}"
                    class="{{ request()->routeIs('dashboard') ? 'bg-whitetext-white' : 'text-white hover:bg-white' }} block px-3 py-2 rounded-md text-base text-blue-600 font-medium transition-colors">
                    <i class="fas fa-tachometer-alt mr-2"></i> Dashboard
                </a>

                {{-- @can('viewAny', App\Models\Order::class) --}}
                    <a href="{{ route('orders.index') }}"
                        class="{{ request()->routeIs('orders.*') ? 'bg-whitetext-white' : 'text-white hover:bg-white' }} block px-3 py-2 rounded-md text-base text-blue-600 font-medium transition-colors">
                        <i class="fas fa-clipboard-list mr-2"></i> Pesanan
                    </a>
                {{-- @endcan --}}

                {{-- @can('viewAny', App\Models\Product::class) --}}
                    <a href="{{ route('products.index') }}"
                        class="{{ request()->routeIs('products.*') ? 'bg-whitetext-white' : 'text-white hover:bg-white' }} block px-3 py-2 rounded-md text-base text-blue-600 font-medium transition-colors">
                        <i class="fas fa-boxes mr-2"></i> Produk
                    </a>
                {{-- @endcan --}}

                {{-- @can('viewAny', App\Models\User::class) --}}
                    <a href="{{ route('users.index') }}"
                        class="{{ request()->routeIs('users.*') ? 'bg-whitetext-white' : 'text-white hover:bg-white' }} block px-3 py-2 rounded-md text-base text-blue-600 font-medium transition-colors">
                        <i class="fas fa-users mr-2"></i> Pengguna
                    </a>
                {{-- @endcan --}}

                {{-- @can('viewAny', App\Models\Withdrawal::class) --}}
                    <a href="{{ route('withdrawals.index') }}"
                        class="{{ request()->routeIs('withdrawals.*') ? 'bg-whitetext-white' : 'text-white hover:bg-white' }} block px-3 py-2 rounded-md text-base text-blue-600 font-medium transition-colors">
                        <i class="fas fa-money-bill-wave mr-2"></i> Withdrawal
                    </a>
                {{-- @endcan --}}
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
                            class="block w-full text-left px-3 py-2 rounded-md text-base font-medium text-white hover:bg-white transition-colors">
                            <i class="fas fa-sign-out-alt mr-2"></i> Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

