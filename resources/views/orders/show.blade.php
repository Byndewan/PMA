@extends('layouts.app')

@section('page-title', 'Detail Pesanan #' . $order->id)

    <a href="{{ route('orders.index') }}" class="btn-secondary flex items-center">
        <i class="fas fa-arrow-left mr-2"></i> Kembali
    </a>
    @if($order->status != 'taken')
        <a href="{{ route('orders.edit', $order->id) }}" class="btn-primary flex items-center">
            <i class="fas fa-edit mr-2"></i> Edit
        </a>
    @endif

@section('content')
<div class="space-y-6">
    <!-- Order Header -->
    <div class="bg-white rounded-xl shadow-sm p-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Pesanan #{{ $order->id }}</h1>
                <div class="mt-2 flex items-center">
                    @include('partials.status-badge', ['status' => $order->status])
                    <span class="ml-3 text-sm text-gray-500">
                        Dibuat pada {{ $order->created_at->format('d M Y H:i') }}
                    </span>
                </div>
            </div>
            <div class="mt-4 md:mt-0">
                <div class="text-right">
                    <p class="text-sm text-gray-500">Operator</p>
                    <p class="font-medium">{{ $order->user->name }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Customer Information -->
    <div class="bg-white rounded-xl shadow-sm p-6">
        <h3 class="text-xl font-semibold mb-4 text-gray-900 border-b pb-2">Informasi Pelanggan</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <p class="text-sm font-medium text-gray-500">Nama</p>
                <p class="mt-1 font-medium">{{ $order->customer_name }}</p>
            </div>
            @if($order->customer_phone)
            <div>
                <p class="text-sm font-medium text-gray-500">Telepon</p>
                <p class="mt-1 font-medium">{{ $order->customer_phone }}</p>
            </div>
            @endif
            <div>
                <p class="text-sm font-medium text-gray-500">Waktu Pesanan</p>
                <p class="mt-1 font-medium">{{ $order->created_at->format('d M Y H:i') }}</p>
            </div>
        </div>
    </div>

    <!-- Order Summary -->
    <div class="bg-white rounded-xl shadow-sm p-6">
        <h3 class="text-xl font-semibold mb-4 text-gray-900 border-b pb-2">Ringkasan Biaya</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-blue-50 p-4 rounded-lg">
                <p class="text-sm font-medium text-gray-500">Total Harga</p>
                <p class="mt-1 text-2xl font-bold">Rp {{ number_format($order->total_price) }}</p>
            </div>
            <div class="bg-green-50 p-4 rounded-lg">
                <p class="text-sm font-medium text-gray-500">Total Fee Operator</p>
                <p class="mt-1 text-2xl font-bold">Rp {{ number_format($order->operator_fee_total) }}</p>
            </div>
            <div class="bg-amber-50 p-4 rounded-lg">
                <p class="text-sm font-medium text-gray-500">Estimasi Selesai</p>
                <p class="mt-1 text-2xl font-bold">
                    @if($order->estimated_completion_time)
                        {{ $order->estimated_completion_time->format('d M Y H:i') }}
                    @else
                        -
                    @endif
                </p>
            </div>
        </div>
    </div>

    <!-- Order Items -->
    <div class="bg-white rounded-xl shadow-sm p-6">
        <h3 class="text-xl font-semibold mb-4 text-gray-900 border-b pb-2">Detail Item</h3>

        <div class="space-y-4">
            @foreach($order->items as $item)
            <div class="border border-gray-200 rounded-lg p-5 bg-gray-50">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Produk</p>
                        <p class="mt-1 font-medium">{{ $item->product->name }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Jumlah</p>
                        <p class="mt-1 font-medium">{{ $item->quantity }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Harga</p>
                        <p class="mt-1 font-medium">Rp {{ number_format($item->price_per_unit) }} x {{ $item->quantity }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">File</p>
                        <a href="{{ asset('storage/'.$item->file_path) }}" target="_blank"
                           class="mt-1 text-blue-600 hover:text-blue-800 transition-colors flex items-center">
                            <i class="fas fa-download mr-2"></i> Download
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Status Update (For Operator) -->
    @if(auth()->user()->isOperator() && $order->status != 'taken')
    <div class="bg-white rounded-xl shadow-sm p-6">
        <h3 class="text-xl font-semibold mb-4 text-gray-900 border-b pb-2">Update Status</h3>
        <form action="{{ route('orders.update-status', $order->id) }}" method="POST">
            @csrf
            <div class="flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-3">
                <select name="status" class="flex-1 border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                    <option value="process" {{ $order->status == 'process' ? 'selected' : '' }}>Diproses</option>
                    <option value="done" {{ $order->status == 'done' ? 'selected' : '' }}>Selesai</option>
                    <option value="taken" {{ $order->status == 'taken' ? 'selected' : '' }}>Diambil</option>
                </select>
                <button type="submit" class="btn-primary flex items-center justify-center">
                    <i class="fas fa-sync-alt mr-2"></i> Update Status
                </button>
            </div>
        </form>
    </div>
    @endif
</div>
@endsection
