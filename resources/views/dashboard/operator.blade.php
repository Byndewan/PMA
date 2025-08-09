@extends('layouts.app')

@section('title', 'Operator Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Balance Section -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-white p-5 rounded-lg shadow-sm border-l-4 border-green-500">
            <div class="flex justify-between items-start">
                <div>
                    <h3 class="text-gray-500 text-sm font-medium uppercase tracking-wider">Saldo Anda</h3>
                    <p class="text-2xl font-bold text-gray-900 mt-1">Rp {{ number_format(auth()->user()->balance, 0, ',', '.') }}</p>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <button onclick="openModal('/withdrawals/create')"
                class="mt-4 w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Tarik Dana
            </button>
        </div>

        <!-- Add 2 more cards if needed -->
    </div>

    <!-- Order Management -->
    <div class="bg-white p-6 rounded-lg shadow-sm">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4 gap-3">
            <h3 class="text-lg font-semibold text-gray-900">Manajemen Pesanan</h3>
            <div class="flex space-x-2">
                <button onclick="openModal('{{ route('orders.create') }}')"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Pesanan Baru
                </button>
                <!-- Add filter/sort buttons if needed -->
            </div>
        </div>

        <div class="overflow-x-auto">
            @include('orders._table', [
                'orders' => $orders,
                'showStatus' => true,
                'showCustomer' => true
            ])
        </div>

        <!-- Pagination if needed -->
        @if($orders->hasPages())
        <div class="mt-4">
            {{ $orders->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
