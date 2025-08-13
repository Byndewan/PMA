@extends('layouts.app')

@section('title', 'Dashboard Pelanggan')

@section('content')
    <style>
        a {
            text-decoration: none !important;
        }
    </style>
    <div class="space-y-6">
        <!-- Welcome Header - Style lebih sederhana -->
        <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-100">
            <div class="flex flex-col md:flex-row md:items-center gap-4">
                <div class="flex-1">
                    <h1 class="text-2xl font-semibold text-gray-800">Halo, {{ auth()->user()->name }}</h1>
                    <p class="text-gray-500 text-sm mt-1">Status akun Anda aktif</p>
                </div>
                <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Stat Cards - Lebih sederhana tanpa background circles -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <!-- Total Orders -->
            <div class="bg-white rounded-lg p-5 shadow-sm border border-gray-100">
                <div class="flex items-center">
                    <div class="p-2 rounded-lg bg-blue-100 text-blue-600 mr-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Pesanan</p>
                        <p class="text-xl font-semibold text-gray-800">{{ $orders->count() }}</p>
                    </div>
                </div>
            </div>

            <!-- Pending Orders -->
            <div class="bg-white rounded-lg p-5 shadow-sm border border-gray-100">
                <div class="flex items-center">
                    <div class="p-2 rounded-lg bg-amber-100 text-amber-600 mr-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Dalam Proses</p>
                        <p class="text-xl font-semibold text-gray-800">{{ $orders->where('status', 'pending')->count() }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Completed Orders -->
            <div class="bg-white rounded-lg p-5 shadow-sm border border-gray-100">
                <div class="flex items-center">
                    <div class="p-2 rounded-lg bg-green-100 text-green-600 mr-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Selesai</p>
                        <p class="text-xl font-semibold text-gray-800">{{ $orders->where('status', 'completed')->count() }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Orders - Tabel lebih sederhana -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-4 py-3 border-b border-gray-100">
                <h3 class="text-lg font-semibold text-gray-800">Pesanan Terakhir</h3>
            </div>

            <div class="divide-y divide-gray-100">
                @forelse($orders->take(5) as $order)
                    <div class="p-4 hover:bg-gray-50 transition-colors">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                            <div>
                                <div class="flex items-center gap-3">
                                    <div class="text-blue-500">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                            </path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-800">#{{ $order->order_number }}</p>
                                        <p class="text-sm text-gray-500">{{ $order->created_at->format('d M Y H:i') }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center gap-4">
                                <div>
                                    <span
                                        class="px-2.5 rounded-full text-xs font-medium
                                @if ($order->status == 'pending') bg-amber-100 text-amber-800
                                @elseif($order->status == 'completed') bg-green-100 text-green-800
                                @else bg-gray-100 text-gray-800 @endif">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </div>
                                <div class="text-right mt-3">
                                    <p class="font-semibold text-gray-800">Rp
                                        {{ number_format($order->total_price, 0, ',', '.') }}</p>
                                </div>
                                <a href="{{ route('customer.orders.show', $order) }}"
                                    class="text-blue-500 hover:text-blue-700">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                            </path>
                        </svg>
                        <p class="mt-2 text-gray-500">Belum ada pesanan</p>
                        <a href="{{ route('customer.products.index') }}"
                            class="mt-4 inline-flex items-center px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors">
                            Pesan Sekarang
                        </a>
                    </div>
                @endforelse
            </div>

            @if ($orders->count() > 0)
                <div class="p-4 border-t border-gray-100 text-right">
                    <a href="{{ route('customer.orders.index') }}"
                        class="text-sm font-medium text-blue-500 hover:text-blue-700">
                        Lihat semua pesanan
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection
