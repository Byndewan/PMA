@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="space-y-6">
    <!-- Welcome Header -->
    <div class="bg-white rounded-xl p-6 shadow-xs border border-gray-100">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-semibold text-gray-800">Selamat Datang, {{ Auth::guard('web')->user()->name }}</h1>
                <p class="text-gray-500 text-sm mt-1">Ringkasan aktivitas sistem hari ini</p>
            </div>
            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-green-50 text-green-700 text-sm font-medium">
                <span class="w-2 h-2 rounded-full bg-green-500"></span>
                Status: Online
            </div>
        </div>
    </div>

    <!-- Stat Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Total Revenue Card -->
        <div class="bg-white rounded-xl p-5 shadow-xs border border-gray-100 relative overflow-hidden">
            <div class="absolute -right-4 -top-4 w-20 h-20 rounded-full bg-blue-100 opacity-20"></div>
            <div class="relative">
                <p class="text-sm font-medium text-gray-500">Total Pendapatan</p>
                <p class="mt-1 text-2xl font-semibold text-gray-800">Rp {{ number_format($stats['totalRevenue']) }}</p>
                <div class="mt-3 flex items-center text-sm text-blue-600">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
                    </svg>
                    <span>12% dari bulan lalu</span>
                </div>
            </div>
            <div class="absolute right-5 bottom-5 p-2 rounded-lg bg-blue-100 text-blue-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>

        <!-- Total Orders Card -->
        <div class="bg-white rounded-xl p-5 shadow-xs border border-gray-100 relative overflow-hidden">
            <div class="absolute -right-4 -top-4 w-20 h-20 rounded-full bg-green-100 opacity-20"></div>
            <div class="relative">
                <p class="text-sm font-medium text-gray-500">Total Pesanan</p>
                <p class="mt-1 text-2xl font-semibold text-gray-800">{{ number_format($stats['totalOrders']) }}</p>
                <div class="mt-3 flex items-center text-sm text-green-600">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
                    </svg>
                    <span>8 pesanan hari ini</span>
                </div>
            </div>
            <div class="absolute right-5 bottom-5 p-2 rounded-lg bg-green-100 text-green-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
            </div>
        </div>

        <!-- Total Products Card -->
        <div class="bg-white rounded-xl p-5 shadow-xs border border-gray-100 relative overflow-hidden">
            <div class="absolute -right-4 -top-4 w-20 h-20 rounded-full bg-purple-100 opacity-20"></div>
            <div class="relative">
                <p class="text-sm font-medium text-gray-500">Total Produk</p>
                <p class="mt-1 text-2xl font-semibold text-gray-800">{{ number_format($stats['totalProducts']) }}</p>
                <div class="mt-3 flex items-center text-sm text-purple-600">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    <span>5 produk baru bulan ini</span>
                </div>
            </div>
            <div class="absolute right-5 bottom-5 p-2 rounded-lg bg-purple-100 text-purple-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
            </div>
        </div>

        <!-- Total Operators Card -->
        <div class="bg-white rounded-xl p-5 shadow-xs border border-gray-100 relative overflow-hidden">
            <div class="absolute -right-4 -top-4 w-20 h-20 rounded-full bg-amber-100 opacity-20"></div>
            <div class="relative">
                <p class="text-sm font-medium text-gray-500">Total Operator</p>
                <p class="mt-1 text-2xl font-semibold text-gray-800">{{ number_format($stats['totalOperators']) }}</p>
                <div class="mt-3 flex items-center text-sm text-amber-600">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>3 aktif hari ini</span>
                </div>
            </div>
            <div class="absolute right-5 bottom-5 p-2 rounded-lg bg-amber-100 text-amber-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- Two Column Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
        <!-- Recent Orders -->
        <div class="bg-white rounded-xl shadow-xs border border-gray-100 overflow-hidden">
            <div class="p-5">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-800">Pesanan Terbaru</h3>
                    <a href="{{ route('orders.index') }}" style="text-decoration: none;!important" class="inline-flex items-center text-sm font-medium text-blue-600 hover:text-blue-800 transition-colors">
                        Lihat Semua
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>

                <div class="space-y-3">
                    @forelse($recentOrders as $order)
                    <div class="flex items-center p-3 rounded-lg hover:bg-gray-50 transition-colors border border-gray-100">
                        <div class="flex-shrink-0 h-10 w-10 rounded-lg bg-blue-50 flex items-center justify-center text-blue-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </div>
                        <div class="ml-3 flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-800 truncate">#{{ $order->id }} - {{ $order->customer_name }}</p>
                            <p class="text-xs text-gray-500">{{ $order->created_at->diffForHumans() }}</p>
                        </div>
                        <div class="ml-3">
                            @include('partials.status-badge', ['status' => $order->status])
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-4">
                        <svg class="mx-auto h-10 w-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        <p class="text-gray-500 text-sm mt-2">Belum Ada Pesanan</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Pending Withdrawals -->
        <div class="bg-white rounded-xl shadow-xs border border-gray-100 overflow-hidden">
            <div class="p-5">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-800">Withdrawal Pending</h3>
                    <a href="{{ route('withdrawals.index') }}" style="text-decoration: none;!important" class="inline-flex items-center text-sm font-medium text-blue-600 hover:text-blue-800 transition-colors">
                        Lihat Semua
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>

                <div class="space-y-3">
                    @forelse($pendingWithdrawals as $withdrawal)
                    <div class="p-3 rounded-lg border border-gray-100 hover:shadow-xs transition-shadow">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="h-8 w-8 rounded-full bg-gray-100 flex items-center justify-center mr-3">
                                    <span class="text-xs font-medium text-gray-600">{{ substr($withdrawal->user->name, 0, 1) }}</span>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-800">{{ $withdrawal->user->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $withdrawal->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-semibold text-gray-800">Rp {{ number_format($withdrawal->amount) }}</p>
                                <form action="{{ route('withdrawals.approve', $withdrawal->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="text-xs font-medium text-green-600 hover:text-green-800 transition-colors mt-1 inline-flex items-center">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Approve
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-4">
                        <svg class="mx-auto h-10 w-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        <p class="text-gray-500 text-sm mt-2">Tidak ada withdrawal pending</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
