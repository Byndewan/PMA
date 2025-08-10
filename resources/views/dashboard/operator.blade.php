@extends('layouts.app')

@section('title', 'Dashboard Operator')

@section('content')
<div class="space-y-6">
    <!-- Welcome Header -->
    <div class="bg-white rounded-xl shadow-sm p-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Halo, {{ Auth::user()->name }}!</h1>
                <p class="text-gray-500 mt-1">Ringkasan aktivitas Anda hari ini</p>
            </div>
            <div class="mt-4 md:mt-0">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                    <i class="fas fa-circle text-xs mr-2"></i> Status: Aktif
                </span>
            </div>
        </div>
    </div>

    <!-- Stat Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
        <!-- Balance Card -->
        <div class="bg-gradient-to-br from-green-600 to-green-500 rounded-xl shadow-lg overflow-hidden">
            <div class="p-6 text-white">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium opacity-90">Saldo Anda</p>
                        <p class="mt-1 text-3xl font-semibold">Rp {{ number_format($stats['balance']) }}</p>
                    </div>
                    <div class="p-3 rounded-lg bg-white bg-opacity-20">
                        <i class="fas fa-coins text-xl"></i>
                    </div>
                </div>
                <a href="{{ route('withdrawals.create') }}" class="mt-4 inline-flex items-center text-sm font-medium text-white opacity-90 hover:opacity-100 transition-opacity">
                    Ajukan Withdrawal
                    <i class="fas fa-arrow-right ml-2 text-xs"></i>
                </a>
            </div>
        </div>

        <!-- Today's Orders Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Pesanan Hari Ini</p>
                        <p class="mt-1 text-3xl font-semibold text-gray-900">{{ number_format($stats['todayOrders']) }}</p>
                    </div>
                    <div class="p-3 rounded-lg bg-blue-100 text-blue-600">
                        <i class="fas fa-clipboard-list text-xl"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm font-medium text-gray-500">
                    <i class="fas fa-bolt mr-1 text-blue-500"></i>
                    <span>{{ $stats['todayOrders'] > 0 ? 'Teruskan kerja bagus!' : 'Ayo mulai bekerja!' }}</span>
                </div>
            </div>
        </div>

        <!-- Pending Orders Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Pesanan Pending</p>
                        <p class="mt-1 text-3xl font-semibold text-gray-900">{{ number_format($stats['pendingOrders']) }}</p>
                    </div>
                    <div class="p-3 rounded-lg bg-amber-100 text-amber-600">
                        <i class="fas fa-clock text-xl"></i>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="{{ route('orders.index') }}" class="inline-flex items-center text-sm font-medium text-amber-600 hover:text-amber-800 transition-colors">
                        <i class="fas fa-tasks mr-1"></i> Proses Sekarang
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Orders Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Pesanan Terbaru Anda</h3>
                <a href="{{ route('orders.index') }}" class="inline-flex items-center text-sm font-medium text-blue-600 hover:text-blue-800 transition-colors">
                    Lihat Semua
                    <i class="fas fa-chevron-right ml-1 text-xs"></i>
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pelanggan</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($recentOrders as $order)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">#{{ $order->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $order->customer_name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">Rp {{ number_format($order->total_price) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @include('partials.status-badge', ['status' => $order->status])
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('orders.show', $order->id) }}" class="inline-flex items-center text-blue-600 hover:text-blue-900 transition-colors">
                                    <i class="fas fa-eye mr-1 text-xs"></i> Detail
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Withdrawal History -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Riwayat Withdrawal</h3>
            </div>

            <div class="space-y-3">
                @forelse($recentWithdrawals as $withdrawal)
                <div class="p-4 rounded-lg border border-gray-100 hover:shadow-xs transition-shadow">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="h-10 w-10 rounded-full bg-gray-100 flex items-center justify-center mr-3">
                                <i class="fas fa-money-bill-wave text-gray-500"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Rp {{ number_format($withdrawal->amount) }}</p>
                                <p class="text-xs text-gray-500">{{ $withdrawal->created_at->format('d M Y, H:i') }}</p>
                            </div>
                        </div>
                        <div>
                            @include('partials.status-badge', ['status' => $withdrawal->status])
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center py-6">
                    <i class="fas fa-piggy-bank text-3xl text-gray-300 mb-2"></i>
                    <p class="text-gray-500">Belum ada riwayat withdrawal</p>
                    <a href="{{ route('withdrawals.create') }}" class="mt-2 inline-flex items-center text-sm font-medium text-green-600 hover:text-green-800 transition-colors">
                        <i class="fas fa-plus-circle mr-1"></i> Ajukan Withdrawal
                    </a>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
