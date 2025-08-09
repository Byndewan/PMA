@extends('layouts.app')

@section('page-title', 'Edit Produk: ' . $product->name)

@section('content')
<div class="max-w-3xl mx-auto">
    <form action="{{ route('products.update', $product->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="bg-white shadow rounded-lg p-6">
            <div class="space-y-6">
                <!-- Nama Produk -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Produk</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $product->name) }}" required
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <!-- Format & Harga -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="format" class="block text-sm font-medium text-gray-700 mb-1">Format/Ukuran</label>
                        <input type="text" id="format" name="format" value="{{ old('format', $product->format) }}" required
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Harga Satuan (Rp)</label>
                        <input type="number" id="price" name="price" min="0" value="{{ old('price', $product->price) }}" required
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>

                <!-- Fee Operator & Estimasi -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="operator_fee" class="block text-sm font-medium text-gray-700 mb-1">Fee Operator (Rp)</label>
                        <input type="number" id="operator_fee" name="operator_fee" min="0" value="{{ old('operator_fee', $product->operator_fee) }}" required
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label for="estimate_time" class="block text-sm font-medium text-gray-700 mb-1">Estimasi Pengerjaan (menit)</label>
                        <input type="number" id="estimate_time" name="estimate_time" min="1" value="{{ old('estimate_time', $product->estimate_time) }}" required
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>

                <!-- Status Aktif -->
                <div class="flex items-center">
                    <input type="checkbox" id="is_active" name="is_active" value="1"
                        {{ old('is_active', $product->is_active) ? 'checked' : '' }}
                        class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <label for="is_active" class="ml-2 block text-sm text-gray-700">
                        Produk aktif (tersedia untuk dipesan)
                    </label>
                </div>
            </div>

            <!-- Tombol Aksi -->
            <div class="mt-8 flex justify-end space-x-3">
                <a href="{{ route('products.index') }}" class="btn-secondary">
                    Batal
                </a>
                <button type="submit" class="btn-primary">
                    Update Produk
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
