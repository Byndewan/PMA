@extends('layouts.app')

@section('page-title', 'Detail Produk: ' . $product->name)

@section('content')
<div class="max-w-3xl mx-auto">
    <!-- Header -->
    <div class="flex items-center justify-between mb-4">
        <div>
            <h1 class="text-2xl font-semibold text-gray-800">Detail Produk</h1>
            <p class="text-sm text-gray-500">Informasi lengkap tentang produk ini</p>
        </div>
        <div class="flex space-x-2">
            <a href="{{ route('products.index') }}" style="text-decoration: none;!important" class="inline-flex items-center px-4 py-2.5 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition-colors shadow-sm">
                Kembali
            </a>
            <a href="{{ route('products.edit', $product->id) }}" style="text-decoration: none;!important" class="inline-flex items-center px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors shadow-sm">
                Edit
            </a>
        </div>
    </div>

    <div class="bg-white rounded-lg border border-gray-100 shadow-xs overflow-hidden">
        <!-- Header -->
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="flex-shrink-0 h-10 w-10 rounded-lg bg-blue-50 flex items-center justify-center text-blue-600 mr-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-medium text-gray-800">
                            {{ $product->name }}
                        </h3>
                        <p class="text-sm text-gray-500 mt-1">
                            {{ $product->format }}
                        </p>
                    </div>
                </div>
                <span class="px-2.5 py-0.5 rounded-full text-xs font-medium {{ $product->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
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
                            <dd class="mt-1 text-lg font-semibold text-gray-800">Rp {{ number_format($product->price) }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm text-gray-500">Fee Operator</dt>
                            <dd class="mt-1 text-lg font-semibold text-gray-800">Rp {{ number_format($product->operator_fee) }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm text-gray-500">Estimasi Pengerjaan</dt>
                            <dd class="mt-1 text-lg font-semibold text-gray-800">{{ $product->estimate_time }} menit</dd>
                        </div>
                    </dl>
                </div>

                <!-- Product Stats -->
                <div>
                    <h4 class="font-medium text-gray-500 mb-3 border-b pb-2">Statistik Produk</h4>
                    <dl class="space-y-4">
                        <div>
                            <dt class="text-sm text-gray-500">Total Pesanan</dt>
                            <dd class="mt-1 text-lg font-semibold text-gray-800">{{ $product->order_items_count ?? 0 }} kali</dd>
                        </div>
                        <div>
                            <dt class="text-sm text-gray-500">Dibuat Pada</dt>
                            <dd class="mt-1 text-lg font-semibold text-gray-800">{{ $product->created_at->format('d M Y H:i') }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm text-gray-500">Terakhir Diupdate</dt>
                            <dd class="mt-1 text-lg font-semibold text-gray-800">{{ $product->updated_at->format('d M Y H:i') }}</dd>
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
                <button type="submit" class="inline-flex items-center text-red-600 hover:text-red-800 transition-colors text-sm" onclick="return confirm('Hapus produk ini?')">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                    Hapus Produk
                </button>
            </form>
            <span class="text-xs text-gray-500">ID: {{ $product->id }}</span>
        </div>
    </div>
</div>
@endsection
