@extends('layouts.app')

@section('title', 'Dashboard Operator')

@section('content')
<div class="space-y-6">
    <!-- Welcome Header -->
    <div class="bg-white rounded-xl p-6 shadow-xs border border-gray-100">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-semibold text-gray-800">Halo, {{ Auth::user()->name }}!</h1>
                <p class="text-gray-500 text-sm mt-1">Ringkasan aktivitas Anda hari ini</p>
            </div>
            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-green-50 text-green-700 text-sm font-medium">
                <span class="w-2 h-2 rounded-full bg-green-500"></span>
                Status: Aktif
            </div>
        </div>
    </div>

    <!-- Stat Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <!-- Balance Card -->
        <div class="bg-white rounded-xl p-5 shadow-xs border border-gray-100 relative overflow-hidden">
            <div class="absolute -right-4 -top-4 w-20 h-20 rounded-full bg-green-100 opacity-20"></div>
            <div class="relative">
                <p class="text-sm font-medium text-gray-500">Saldo Anda</p>
                <p class="mt-1 text-2xl font-semibold text-gray-800">Rp {{ number_format($stats['balance']) }}</p>
                @if ($stats['balance'] > 10000)
                    <a href="{{ route('withdrawals.create') }}" style="text-decoration: none;!important" class="mt-3 inline-flex items-center text-sm font-medium text-green-600 hover:text-green-800 transition-colors">
                        Ajukan Withdrawal
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                    </a>
                @endif
            </div>
            <div class="absolute right-5 bottom-5 p-2 rounded-lg bg-green-100 text-green-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>

        <!-- Today's Orders Card -->
        <div class="bg-white rounded-xl p-5 shadow-xs border border-gray-100 relative overflow-hidden">
            <div class="absolute -right-4 -top-4 w-20 h-20 rounded-full bg-blue-100 opacity-20"></div>
            <div class="relative">
                <p class="text-sm font-medium text-gray-500">Pesanan Hari Ini</p>
                <p class="mt-1 text-2xl font-semibold text-gray-800">{{ number_format($stats['todayOrders']) }}</p>
                <div class="mt-3 flex items-center text-sm text-blue-600">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                    <span>{{ $stats['todayOrders'] > 0 ? 'Teruskan kerja bagus!' : 'Ayo mulai bekerja!' }}</span>
                </div>
            </div>
            <div class="absolute right-5 bottom-5 p-2 rounded-lg bg-blue-100 text-blue-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
            </div>
        </div>

        <!-- Pending Orders Card -->
        <div class="bg-white rounded-xl p-5 shadow-xs border border-gray-100 relative overflow-hidden">
            <div class="absolute -right-4 -top-4 w-20 h-20 rounded-full bg-amber-100 opacity-20"></div>
            <div class="relative">
                <p class="text-sm font-medium text-gray-500">Pesanan Pending</p>
                <p class="mt-1 text-2xl font-semibold text-gray-800">{{ number_format($stats['pendingOrders']) }}</p>
                @if ($stats['pendingOrders'] > 0)
                    <a href="{{ route('orders.index') }}" style="text-decoration: none;!important" class="mt-3 inline-flex items-center text-sm font-medium text-amber-600 hover:text-amber-800 transition-colors">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Proses Sekarang
                    </a>
                @endif
            </div>
            <div class="absolute right-5 bottom-5 p-2 rounded-lg bg-amber-100 text-amber-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- Recent Orders Table -->
    <div class="bg-white rounded-xl shadow-xs border border-gray-100 overflow-hidden">
        <div class="p-5">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Pesanan Terbaru Anda</h3>
                <a href="{{ route('orders.index') }}" style="text-decoration: none;!important" class="inline-flex items-center text-sm font-medium text-blue-600 hover:text-blue-800 transition-colors">
                    Lihat Semua
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($recentOrders as $order)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-800">#{{ $order->id }}</td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-800">{{ $order->customer_name }}</td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-800">Rp {{ number_format($order->total_price) }}</td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                @include('partials.status-badge', ['status' => $order->status])
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-left text-sm font-medium">
                                <a href="{{ route('orders.show', $order->id) }}" style="text-decoration: none;!important" class="inline-flex items-center text-blue-600 hover:text-blue-800 transition-colors">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    Detail
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
    <div class="bg-white rounded-xl shadow-xs border border-gray-100 overflow-hidden">
        <div class="p-5">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Riwayat Withdrawal</h3>
            </div>

            <div class="space-y-3">
                @forelse($recentWithdrawals as $withdrawal)
                <div class="p-3 rounded-lg border border-gray-100 hover:shadow-xs transition-shadow">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="h-10 w-10 rounded-lg bg-gray-100 flex items-center justify-center mr-3">
                                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-800">Rp {{ number_format($withdrawal->amount) }}</p>
                                <p class="text-xs text-gray-500">{{ $withdrawal->created_at->format('d M Y, H:i') }}</p>
                            </div>
                        </div>
                        <div>
                            @include('partials.status-badge', ['status' => $withdrawal->status])
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center py-4">
                    <svg class="mx-auto h-10 w-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z"></path>
                    </svg>
                    <p class="text-gray-500 text-sm mt-2">Belum ada riwayat withdrawal</p>
                    <a href="{{ route('withdrawals.create') }}" style="text-decoration: none;!important" style="text-decoration: none;!important" class="mt-2 inline-flex items-center text-sm font-medium text-green-600 hover:text-green-800 transition-colors">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Ajukan Withdrawal
                    </a>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
