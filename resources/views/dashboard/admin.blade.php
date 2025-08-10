@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="space-y-6">
    <!-- Welcome Header -->
    <div class="bg-white rounded-xl shadow-sm p-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Selamat Datang, Admin!</h1>
                <p class="text-gray-500 mt-1">Ringkasan aktivitas sistem hari ini</p>
            </div>
            <div class="mt-4 md:mt-0">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                    <i class="fas fa-circle text-xs mr-2"></i> Status: Online
                </span>
            </div>
        </div>
    </div>

    <!-- Stat Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Revenue Card -->
        <div class="bg-gradient-to-br from-blue-600 to-blue-500 rounded-xl shadow-lg overflow-hidden">
            <div class="p-6 text-white">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium opacity-90">Total Pendapatan</p>
                        <p class="mt-1 text-3xl font-semibold">Rp {{ number_format($stats['totalRevenue']) }}</p>
                    </div>
                    <div class="p-3 rounded-lg bg-white bg-opacity-20">
                        <i class="fas fa-wallet text-xl"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm font-medium opacity-90">
                    <i class="fas fa-arrow-up mr-1"></i>
                    <span>12% dari bulan lalu</span>
                </div>
            </div>
        </div>

        <!-- Total Orders Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Pesanan</p>
                        <p class="mt-1 text-3xl font-semibold text-gray-900">{{ number_format($stats['totalOrders']) }}</p>
                    </div>
                    <div class="p-3 rounded-lg bg-green-100 text-green-600">
                        <i class="fas fa-shopping-cart text-xl"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm font-medium text-gray-500">
                    <i class="fas fa-arrow-up mr-1 text-green-500"></i>
                    <span>8 pesanan hari ini</span>
                </div>
            </div>
        </div>

        <!-- Total Products Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Produk</p>
                        <p class="mt-1 text-3xl font-semibold text-gray-900">{{ number_format($stats['totalProducts']) }}</p>
                    </div>
                    <div class="p-3 rounded-lg bg-purple-100 text-purple-600">
                        <i class="fas fa-boxes text-xl"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm font-medium text-gray-500">
                    <i class="fas fa-plus-circle mr-1 text-purple-500"></i>
                    <span>5 produk baru bulan ini</span>
                </div>
            </div>
        </div>

        <!-- Total Operators Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Operator</p>
                        <p class="mt-1 text-3xl font-semibold text-gray-900">{{ number_format($stats['totalOperators']) }}</p>
                    </div>
                    <div class="p-3 rounded-lg bg-amber-100 text-amber-600">
                        <i class="fas fa-users-cog text-xl"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm font-medium text-gray-500">
                    <i class="fas fa-user-clock mr-1 text-amber-500"></i>
                    <span>3 aktif hari ini</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Two Column Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Orders -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Pesanan Terbaru</h3>
                    <a href="{{ route('orders.index') }}" class="inline-flex items-center text-sm font-medium text-blue-600 hover:text-blue-800 transition-colors">
                        Lihat Semua
                        <i class="fas fa-chevron-right ml-1 text-xs"></i>
                    </a>
                </div>

                <div class="space-y-4">
                    @foreach($recentOrders as $order)
                    <div class="flex items-center p-3 rounded-lg hover:bg-gray-50 transition-colors border border-gray-100">
                        <div class="flex-shrink-0 h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600">
                            <i class="fas fa-receipt"></i>
                        </div>
                        <div class="ml-4 flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 truncate">#{{ $order->id }} - {{ $order->customer_name }}</p>
                            <p class="text-sm text-gray-500">{{ $order->created_at->diffForHumans() }}</p>
                        </div>
                        <div class="ml-4">
                            @include('partials.status-badge', ['status' => $order->status])
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Pending Withdrawals -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Withdrawal Pending</h3>
                    <a href="{{ route('withdrawals.index') }}" class="inline-flex items-center text-sm font-medium text-blue-600 hover:text-blue-800 transition-colors">
                        Lihat Semua
                        <i class="fas fa-chevron-right ml-1 text-xs"></i>
                    </a>
                </div>

                <div class="space-y-3">
                    @forelse($pendingWithdrawals as $withdrawal)
                    <div class="p-4 rounded-lg border border-gray-100 hover:shadow-xs transition-shadow">
                        <div class="flex items-center justify-between">
                            <div>
                                <div class="flex items-center">
                                    <div class="h-8 w-8 rounded-full bg-gray-200 flex items-center justify-center mr-3">
                                        <span class="text-xs font-medium text-gray-600">{{ substr($withdrawal->user->name, 0, 1) }}</span>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">{{ $withdrawal->user->name }}</p>
                                        <p class="text-xs text-gray-500">{{ $withdrawal->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-semibold text-gray-900">Rp {{ number_format($withdrawal->amount) }}</p>
                                <form action="{{ route('withdrawals.approve', $withdrawal->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="text-xs font-medium text-green-600 hover:text-green-800 transition-colors mt-1 inline-flex items-center">
                                        <i class="fas fa-check-circle mr-1"></i> Approve
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-6">
                        <i class="fas fa-check-circle text-3xl text-gray-300 mb-2"></i>
                        <p class="text-gray-500">Tidak ada withdrawal pending</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
