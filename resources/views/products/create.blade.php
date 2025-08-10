@extends('layouts.app')

@section('page-title', 'Tambah Produk Baru')

@section('content')
<div class="max-w-3xl mx-auto">
    <form action="{{ route('products.store') }}" method="POST">
        @csrf

        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <!-- Header -->
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                <h3 class="text-lg font-medium text-gray-900">
                    Tambah Produk Baru
                </h3>
            </div>

            <!-- Form Content -->
            <div class="p-6 space-y-6">
                <!-- Product Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Produk</label>
                    <input type="text" id="name" name="name" required
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                        placeholder="Contoh: Cetak Foto 2R">
                </div>

                <!-- Format & Price -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="format" class="block text-sm font-medium text-gray-700 mb-1">Format/Ukuran</label>
                        <input type="text" id="format" name="format" required
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                            placeholder="Contoh: 2R (6x8 cm)">
                    </div>
                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Harga Satuan (Rp)</label>
                        <input type="number" id="price" name="price" min="0" required
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                            placeholder="2500">
                    </div>
                </div>

                <!-- Operator Fee & Estimate Time -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="operator_fee" class="block text-sm font-medium text-gray-700 mb-1">Fee Operator (Rp)</label>
                        <input type="number" id="operator_fee" name="operator_fee" min="0" value="300" required
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                    </div>
                    <div>
                        <label for="estimate_time" class="block text-sm font-medium text-gray-700 mb-1">Estimasi Pengerjaan (menit)</label>
                        <input type="number" id="estimate_time" name="estimate_time" min="1" required
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                            placeholder="15">
                    </div>
                </div>

                <!-- Active Status -->
                <div class="flex items-center">
                    <input type="checkbox" id="is_active" name="is_active" value="1" checked
                        class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded transition">
                    <label for="is_active" class="ml-2 block text-sm text-gray-700">
                        Produk aktif (tersedia untuk dipesan)
                    </label>
                </div>
            </div>

            <!-- Footer -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end space-x-3">
                <a href="{{ route('products.index') }}" class="btn-secondary flex items-center">
                    <i class="fas fa-times mr-2"></i> Batal
                </a>
                <button type="submit" class="btn-primary flex items-center">
                    <i class="fas fa-save mr-2"></i> Simpan Produk
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
