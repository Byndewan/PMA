@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Stat Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white p-5 rounded-lg shadow-sm border-l-4 border-blue-500">
            <h3 class="text-gray-500 text-sm font-medium uppercase tracking-wider">Total Pendapatan</h3>
            <p class="text-2xl font-bold text-gray-900 mt-1">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
            <p class="text-xs text-gray-500 mt-1">Bulan ini</p>
        </div>

        <div class="bg-white p-5 rounded-lg shadow-sm border-l-4 border-green-500">
            <h3 class="text-gray-500 text-sm font-medium uppercase tracking-wider">Total Pesanan</h3>
            <p class="text-2xl font-bold text-gray-900 mt-1">{{ number_format($totalOrders, 0, ',', '.') }}</p>
            <p class="text-xs text-gray-500 mt-1">30 hari terakhir</p>
        </div>

        <!-- Add 2 more cards with consistent styling -->
    </div>

    <!-- Main Content -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Quick Actions -->
        <div class="lg:col-span-1 bg-white p-6 rounded-lg shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Quick Actions</h3>
                <span class="text-sm text-gray-500">Admin Tools</span>
            </div>
            <div class="space-y-3">
                <button onclick="openModal('{{ route('products.create') }}')"
                    class="w-full flex items-center justify-between p-3 rounded-lg border border-gray-200 hover:bg-blue-50 hover:border-blue-200 transition-colors">
                    <span class="text-blue-700">+ Produk Baru</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                </button>
                <!-- Add more action buttons with consistent styling -->
            </div>
        </div>

        <!-- Recent Orders -->
        <div class="lg:col-span-2 bg-white p-6 rounded-lg shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Pesanan Terbaru</h3>
                <a href="{{ route('orders.index') }}" class="text-sm text-blue-600 hover:underline">Lihat Semua</a>
            </div>
            <div class="overflow-x-auto">
                @include('orders._table', [
                    'orders' => $recentOrders,
                    'hideColumns' => ['actions']
                ])
            </div>
        </div>
    </div>
</div>
@endsection
