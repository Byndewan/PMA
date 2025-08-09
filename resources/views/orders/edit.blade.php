@extends('layouts.app')

@section('page-title', 'Edit Pesanan #' . $order->id)

@section('content')
<form action="{{ route('orders.update', $order->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="space-y-6">
        <!-- Informasi Pesanan -->
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-lg font-medium mb-4">Informasi Pesanan</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-700">Nama Pelanggan</label>
                    <input type="text" name="customer_name" value="{{ $order->customer_name }}" required
                        class="w-full border border-gray-300 rounded-lg px-4 py-2">
                </div>
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-700">Status</label>
                    <select name="status" class="w-full border border-gray-300 rounded-lg px-4 py-2">
                        <option value="queue" {{ $order->status == 'queue' ? 'selected' : '' }}>Antri</option>
                        <option value="process" {{ $order->status == 'process' ? 'selected' : '' }}>Diproses</option>
                        <option value="done" {{ $order->status == 'done' ? 'selected' : '' }}>Selesai</option>
                        <option value="taken" {{ $order->status == 'taken' ? 'selected' : '' }}>Diambil</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Daftar Item -->
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-lg font-medium mb-4">Item Pesanan</h3>

            @foreach($order->items as $item)
            <div class="border border-gray-200 rounded-lg p-4 mb-4">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-700">Produk</label>
                        <p>{{ $item->product->name }}</p>
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-700">Jumlah</label>
                        <p>{{ $item->quantity }}</p>
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-700">Harga Satuan</label>
                        <p>Rp {{ number_format($item->price_per_unit) }}</p>
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-700">File</label>
                        <a href="{{ asset('storage/'.$item->file_path) }}" target="_blank" class="text-blue-600 hover:underline">
                            Lihat File
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Tombol Aksi -->
    <div class="mt-6 flex justify-end space-x-3">
        <a href="{{ route('orders.index') }}" class="btn-secondary">
            Batal
        </a>
        <button type="submit" class="btn-primary">
            Update Pesanan
        </button>
    </div>
</form>
@endsection
