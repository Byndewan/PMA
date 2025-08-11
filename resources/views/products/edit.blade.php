@extends('layouts.app')

@section('page-title', 'Edit Produk: ' . $product->name)

@section('content')
<div class="max-w-3xl mx-auto">
    <form action="{{ route('products.update', $product->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="bg-white rounded-lg border border-gray-100 shadow-xs overflow-hidden">
            <!-- Header -->
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                <h3 class="text-lg font-medium text-gray-800">
                    Edit Produk
                </h3>
                <p class="mt-1 text-sm text-gray-500">
                    {{ $product->name }}
                </p>
            </div>

            <!-- Form Content -->
            <div class="p-6 space-y-6">
                <!-- Product Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1.5">Nama Produk</label>
                    <input type="text" id="name" name="name" value="{{ $product->name }}" required
                        class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                </div>

                <!-- Format & Price -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="format" class="block text-sm font-medium text-gray-700 mb-1.5">Format/Ukuran</label>
                        <input type="text" id="format" name="format" value="{{ $product->format }}" required
                            class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                    </div>
                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-700 mb-1.5">Harga Satuan (Rp)</label>
                        <input type="number" id="price" name="price" min="0" value="{{ $product->price }}" required
                            class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                    </div>
                </div>

                <!-- Operator Fee & Estimate Time -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="operator_fee" class="block text-sm font-medium text-gray-700 mb-1.5">Fee Operator (Rp)</label>
                        <input type="number" id="operator_fee" name="operator_fee" min="0" value="{{ $product->operator_fee }}" required
                            class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                    </div>
                    <div>
                        <label for="estimate_time" class="block text-sm font-medium text-gray-700 mb-1.5">Estimasi Pengerjaan (menit)</label>
                        <input type="number" id="estimate_time" name="estimate_time" min="1" value="{{ $product->estimate_time }}" required
                            class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                    </div>
                </div>

                <!-- Active Status -->
                <div class="flex items-center">
                    <input type="checkbox" id="is_active" name="is_active" value="1" {{ $product->is_active ? 'checked' : '' }}
                        class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded transition">
                    <label for="is_active" class="ml-2 block text-sm text-gray-700">
                        Produk aktif (tersedia untuk dipesan)
                    </label>
                </div>
            </div>

            <!-- Footer -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end space-x-3">
                <a href="{{ route('products.index') }}" style="text-decoration: none;!important" class="inline-flex items-center px-4 py-2.5 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition-colors shadow-sm">
                    Batal
                </a>
                <button type="submit" class="inline-flex items-center px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors shadow-sm">
                    Update Produk
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
