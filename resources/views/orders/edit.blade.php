@extends('layouts.app')

@section('page-title', 'Edit Pesanan #' . $order->id)

@section('content')
<form action="{{ route('orders.update', $order->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="space-y-4">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-gray-800">Edit Pesanan #{{ $order->id }}</h1>
                <p class="text-sm text-gray-500">Perbarui informasi pesanan</p>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('orders.index') }}" style="text-decoration: none;!important" class="inline-flex items-center px-4 py-2.5 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition-colors shadow-sm">
                    Batal
                </a>
                <button type="submit" class="inline-flex items-center px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors shadow-sm">
                    Simpan Perubahan
                </button>
            </div>
        </div>

        <!-- Order Information -->
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
        </div>

        <!-- Order Items -->
        <div class="bg-white rounded-lg border border-gray-100 p-4 shadow-xs">
            <h3 class="text-lg font-semibold mb-4 text-gray-800">Item Pesanan</h3>

            @foreach($order->items as $item)
            <div class="border border-gray-200 rounded-lg p-4 mb-3 bg-gray-50">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-3">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Produk</p>
                        <p class="mt-1 font-medium text-gray-800">{{ $item->product->name }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Jumlah</p>
                        <p class="mt-1 font-medium text-gray-800">{{ $item->quantity }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Harga Satuan</p>
                        <p class="mt-1 font-medium text-gray-800">Rp {{ number_format($item->price_per_unit) }}</p>
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
</form>
@endsection
