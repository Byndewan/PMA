@extends('layouts.app')

@section('page-title', 'Detail Produk: ' . $product->name)

    <a href="{{ route('products.index') }}" class="btn-secondary flex items-center">
        <i class="fas fa-arrow-left mr-2"></i> Kembali
    </a>
    <a href="{{ route('products.edit', $product->id) }}" class="btn-primary flex items-center">
        <i class="fas fa-edit mr-2"></i> Edit
    </a>

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <!-- Header -->
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="flex-shrink-0 h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 mr-3">
                        <i class="fas fa-print"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-medium text-gray-900">
                            {{ $product->name }}
                        </h3>
                        <p class="text-sm text-gray-500 mt-1">
                            {{ $product->format }}
                        </p>
                    </div>
                </div>
                <span class="px-3 py-1 rounded-full text-xs font-medium {{ $product->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                    {{ $product->is_active ? 'Aktif' : 'Nonaktif' }}
                </span>
            </div>
        </div>

        <!-- Body -->
        <div class="px-6 py-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Product Information -->
                <div>
                    <h4 class="font-medium text-gray-500 mb-3 border-b pb-2">Informasi Produk</h4>
                    <dl class="space-y-4">
                        <div>
                            <dt class="text-sm text-gray-500">Harga Satuan</dt>
                            <dd class="mt-1 text-lg font-semibold text-gray-900">Rp {{ number_format($product->price) }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm text-gray-500">Fee Operator</dt>
                            <dd class="mt-1 text-lg font-semibold text-gray-900">Rp {{ number_format($product->operator_fee) }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm text-gray-500">Estimasi Pengerjaan</dt>
                            <dd class="mt-1 text-lg font-semibold text-gray-900">{{ $product->estimate_time }} menit</dd>
                        </div>
                    </dl>
                </div>

                <!-- Product Stats -->
                <div>
                    <h4 class="font-medium text-gray-500 mb-3 border-b pb-2">Statistik Produk</h4>
                    <dl class="space-y-4">
                        <div>
                            <dt class="text-sm text-gray-500">Total Pesanan</dt>
                            <dd class="mt-1 text-lg font-semibold text-gray-900">{{ $product->order_items_count ?? 0 }} kali</dd>
                        </div>
                        <div>
                            <dt class="text-sm text-gray-500">Dibuat Pada</dt>
                            <dd class="mt-1 text-lg font-semibold text-gray-900">{{ $product->created_at->format('d M Y H:i') }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm text-gray-500">Terakhir Diupdate</dt>
                            <dd class="mt-1 text-lg font-semibold text-gray-900">{{ $product->updated_at->format('d M Y H:i') }}</dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-between items-center">
            <form action="{{ route('products.destroy', $product->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-600 hover:text-red-900 transition-colors flex items-center" onclick="return confirm('Hapus produk ini?')">
                    <i class="fas fa-trash-alt mr-2"></i> Hapus Produk
                </button>
            </form>
            <span class="text-xs text-gray-500">ID: {{ $product->id }}</span>
        </div>
    </div>
</div>
@endsection
