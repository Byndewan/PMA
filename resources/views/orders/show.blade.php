@extends('layouts.app')

@section('page-title', 'Detail Pesanan #' . $order->id)

@section('page-actions')
    <a href="{{ route('orders.index') }}" class="btn-secondary">
        Kembali
    </a>
    @if($order->status != 'taken')
        <a href="{{ route('orders.edit', $order->id) }}" class="btn-primary">
            Edit
        </a>
    @endif
@endsection

@section('content')
<div class="space-y-6">
    <!-- Informasi Utama -->
    <div class="bg-white p-6 rounded-lg shadow">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <h4 class="font-medium text-gray-500">Pelanggan</h4>
                <p class="mt-1">{{ $order->customer_name }}</p>
            </div>
            <div>
                <h4 class="font-medium text-gray-500">Status</h4>
                <p class="mt-1">
                    @include('partials.status-badge', ['status' => $order->status])
                </p>
            </div>
            <div>
                <h4 class="font-medium text-gray-500">Tanggal</h4>
                <p class="mt-1">{{ $order->created_at->format('d M Y H:i') }}</p>
            </div>
        </div>
    </div>

    <!-- Ringkasan Biaya -->
    <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-medium mb-4">Ringkasan Biaya</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <h4 class="font-medium text-gray-500">Total Harga</h4>
                <p class="text-xl font-semibold">Rp {{ number_format($order->total_price) }}</p>
            </div>
            <div>
                <h4 class="font-medium text-gray-500">Fee Operator</h4>
                <p class="text-xl font-semibold">Rp {{ number_format($order->operator_fee_total) }}</p>
            </div>
            <div>
                <h4 class="font-medium text-gray-500">Operator</h4>
                <p class="text-xl font-semibold">{{ $order->user->name }}</p>
            </div>
        </div>
    </div>

    <!-- Detail Item -->
    <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-medium mb-4">Detail Item</h3>

        <div class="space-y-4">
            @foreach($order->items as $item)
            <div class="border border-gray-200 rounded-lg p-4">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <h4 class="font-medium text-gray-500">Produk</h4>
                        <p>{{ $item->product->name }}</p>
                    </div>
                    <div>
                        <h4 class="font-medium text-gray-500">Jumlah</h4>
                        <p>{{ $item->quantity }}</p>
                    </div>
                    <div>
                        <h4 class="font-medium text-gray-500">Harga</h4>
                        <p>Rp {{ number_format($item->price_per_unit) }} x {{ $item->quantity }}</p>
                    </div>
                    <div>
                        <h4 class="font-medium text-gray-500">File</h4>
                        <a href="{{ asset('storage/'.$item->file_path) }}" target="_blank" class="text-blue-600 hover:underline">
                            Download File
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Update Status (Untuk Operator) -->
    @if(auth()->user()->isOperator() && $order->status != 'taken')
    <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-medium mb-4">Update Status</h3>
        <form action="{{ route('orders.update-status', $order->id) }}" method="POST">
            @csrf
            <div class="flex space-x-2">
                <select name="status" class="flex-1 border rounded-lg px-4 py-2">
                    <option value="process" {{ $order->status == 'process' ? 'selected' : '' }}>Diproses</option>
                    <option value="done" {{ $order->status == 'done' ? 'selected' : '' }}>Selesai</option>
                    <option value="taken" {{ $order->status == 'taken' ? 'selected' : '' }}>Diambil</option>
                </select>
                <button type="submit" class="btn-primary">
                    Update
                </button>
            </div>
        </form>
    </div>
    @endif
</div>
@endsection
