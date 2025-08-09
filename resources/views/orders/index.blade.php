@extends('layouts.app')

@section('title', 'Daftar Pesanan')

@section('content')
<div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
        <div>
            <h1 class="text-xl font-semibold text-gray-800">Daftar Pesanan</h1>
            <p class="text-sm text-gray-500 mt-1">Total {{ $orders->total() }} pesanan ditemukan</p>
        </div>

        @if(auth()->user()->isOperator())
        <button onclick="openModal('{{ route('orders.create') }}')"
            class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Buat Pesanan
        </button>
        @endif
    </div>

    <div class="bg-white">
        @include('orders._table', ['orders' => $orders])
    </div>

    @if($orders->hasPages())
    <div class="px-6 py-3 border-t border-gray-100 bg-gray-50">
        {{ $orders->links() }}
    </div>
    @endif
</div>
@endsection
