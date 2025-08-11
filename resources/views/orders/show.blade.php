@extends('layouts.app')

@section('page-title', 'Detail Pesanan #' . $order->id)

@section('content')
<div class="space-y-4">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-gray-800">Detail Pesanan #{{ $order->id }}</h1>
            <p class="text-sm text-gray-500">Informasi lengkap tentang pesanan ini</p>
        </div>
        <div class="flex space-x-2">
            <a href="{{ route('orders.index') }}" style="text-decoration: none;!important" class="inline-flex items-center px-4 py-2.5 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition-colors shadow-sm">
                Kembali
            </a>
            @if($order->status != 'taken')
            <a href="{{ route('orders.edit', $order->id) }}" style="text-decoration: none;!important" class="inline-flex items-center px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors shadow-sm">
                Edit
            </a>
            @endif
        </div>
    </div>

    <!-- Order Header -->
    <div class="bg-white rounded-lg border border-gray-100 p-4 shadow-xs">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div class="flex items-center space-x-3">
                @include('partials.status-badge', ['status' => $order->status])
                <div>
                    <p class="text-sm text-gray-500">Dibuat pada {{ $order->created_at->format('d M Y H:i') }}</p>
                    <p class="text-sm text-gray-500">Operator: {{ $order->user->name }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Customer Information -->
    <div class="bg-white rounded-lg border border-gray-100 p-4 shadow-xs">
        <h3 class="text-lg font-semibold mb-3 text-gray-800">Informasi Pelanggan</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            {{-- <div>
                <p class="text-sm font-medium text-gray-500">Nama</p>
                <p class="mt-1 text-gray-800">{{ $order->customer_name }}</p>
            </div> --}}
            @if($order->customer_phone)
            <div>
                <p class="text-sm font-medium text-gray-500">Telepon</p>
                <p class="mt-1 text-gray-800">{{ $order->phone }}</p>
            </div>
            @endif
            <div>
                <p class="text-sm font-medium text-gray-500">Waktu Pesanan</p>
                <p class="mt-1 text-gray-800">{{ $order->created_at->format('d M Y H:i') }}</p>
            </div>
        </div>
    </div>

    <!-- Order Summary -->
    <div class="bg-white rounded-lg border border-gray-100 p-4 shadow-xs">
        <h3 class="text-lg font-semibold mb-3 text-gray-800">Ringkasan Biaya</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-blue-50 p-4 rounded-lg">
                <p class="text-sm font-medium text-gray-500">Total Harga</p>
                <p class="mt-1 text-xl font-semibold text-gray-800">Rp {{ number_format($order->total_price) }}</p>
            </div>
            <div class="bg-green-50 p-4 rounded-lg">
                <p class="text-sm font-medium text-gray-500">Total Fee Operator</p>
                <p class="mt-1 text-xl font-semibold text-gray-800">Rp {{ number_format($order->operator_fee_total) }}</p>
            </div>
            <div class="bg-amber-50 p-4 rounded-lg">
                <p class="text-sm font-medium text-gray-500">Estimasi Selesai</p>
                <p class="mt-1 text-xl font-semibold text-gray-800">
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
    <div class="bg-white rounded-lg border border-gray-100 p-4 shadow-xs">
        <h3 class="text-lg font-semibold mb-3 text-gray-800">Detail Item</h3>

        <div class="space-y-3">
            @foreach($order->items as $item)
            <div class="border border-gray-200 rounded-lg p-4 bg-gray-50">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Produk</p>
                        <p class="mt-1 text-gray-800">{{ $item->product->name }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Jumlah</p>
                        <p class="mt-1 text-gray-800">{{ $item->quantity }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Harga</p>
                        <p class="mt-1 text-gray-800">Rp {{ number_format($item->price_per_unit) }} x {{ $item->quantity }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">File</p>
                        <a href="{{ asset('storage/'.$item->file_path) }}" style="text-decoration: none;!important" target="_blank"
                           class="mt-1 text-blue-600 hover:text-blue-800 transition-colors flex items-center text-sm">
                            Download
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Status Update (For Operator) -->
    @if(auth()->user()->isOperator() && $order->status != 'taken')
    <form action="{{ route('orders.update', $order->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="bg-white rounded-lg border border-gray-100 p-4 shadow-xs">
            <h3 class="text-lg font-semibold mb-4 text-gray-800">Informasi Pesanan</h3>
            <div class="grid grid-cols-1 md:grid-cols-1 gap-4">
                <div>
                    <label class="block mb-1.5 text-sm font-medium text-gray-700">Status</label>
                    <select name="status" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                        <option value="queue" {{ $order->status == 'queue' ? 'selected' : '' }}>Antri</option>
                        <option value="process" {{ $order->status == 'process' ? 'selected' : '' }}>Diproses</option>
                        <option value="done" {{ $order->status == 'done' ? 'selected' : '' }}>Selesai</option>
                        <option value="taken" {{ $order->status == 'taken' ? 'selected' : '' }}>Diambil</option>
                    </select>
                </div>
            </div>
            <button type="submit" class="inline-flex items-center mt-3 px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-md transition-colors shadow-sm">
                Simpan Perubahan
            </button>
        </div>
    </form>
    @endif
</div>
@endsection
