@extends('layouts.app')

@section('page-title', 'Edit Pesanan #' . $order->id)

@section('content')
<form action="{{ route('orders.update', $order->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="space-y-6">
        <!-- Order Information -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="text-xl font-semibold mb-6 text-gray-900 border-b pb-2">Informasi Pesanan</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-700">Nama Pelanggan</label>
                    <input type="text" name="customer_name" value="{{ $order->customer_name }}" required
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                </div>
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-700">Status</label>
                    <select name="status" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                        <option value="queue" {{ $order->status == 'queue' ? 'selected' : '' }}>Antri</option>
                        <option value="process" {{ $order->status == 'process' ? 'selected' : '' }}>Diproses</option>
                        <option value="done" {{ $order->status == 'done' ? 'selected' : '' }}>Selesai</option>
                        <option value="taken" {{ $order->status == 'taken' ? 'selected' : '' }}>Diambil</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Order Items -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="text-xl font-semibold mb-6 text-gray-900 border-b pb-2">Item Pesanan</h3>

            @foreach($order->items as $item)
            <div class="border border-gray-200 rounded-lg p-5 mb-4 bg-gray-50">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-500">Produk</label>
                        <p class="font-medium text-gray-900">{{ $item->product->name }}</p>
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-500">Jumlah</label>
                        <p class="font-medium text-gray-900">{{ $item->quantity }}</p>
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-500">Harga Satuan</label>
                        <p class="font-medium text-gray-900">Rp {{ number_format($item->price_per_unit) }}</p>
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-500">File</label>
                        <a href="{{ asset('storage/'.$item->file_path) }}" target="_blank"
                           class="text-blue-600 hover:text-blue-800 transition-colors flex items-center">
                            <i class="fas fa-download mr-2"></i> Download
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="mt-8 flex justify-end space-x-3">
        <a href="{{ route('orders.index') }}" class="btn-secondary flex items-center">
            <i class="fas fa-times mr-2"></i> Batal
        </a>
        <button type="submit" class="btn-primary flex items-center">
            <i class="fas fa-save mr-2"></i> Update Pesanan
        </button>
    </div>
</form>
@endsection
