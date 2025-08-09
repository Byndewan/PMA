@extends('layouts.app')

@section('page-title', 'Detail Produk: ' . $product->name)

@section('page-actions')
    <a href="{{ route('products.index') }}" class="btn-secondary">
        Kembali
    </a>
    <a href="{{ route('products.edit', $product->id) }}" class="btn-primary">
        Edit
    </a>
@endsection

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <!-- Header -->
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-medium text-gray-900">
                    {{ $product->name }}
                </h3>
                <span class="px-3 py-1 rounded-full text-xs font-medium {{ $product->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                    {{ $product->is_active ? 'Aktif' : 'Nonaktif' }}
                </span>
            </div>
        </div>

        <!-- Body -->
        <div class="px-6 py-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Informasi Produk -->
                <div>
                    <h4 class="font-medium text-gray-500 mb-2">Informasi Produk</h4>
                    <dl class="space-y-3">
                        <div>
                            <dt class="text-sm text-gray-500">Format/Ukuran</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $product->format }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm text-gray-500">Harga Satuan</dt>
                            <dd class="mt-1 text-sm text-gray-900">Rp {{ number_format($product->price) }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm text-gray-500">Fee Operator</dt>
                            <dd class="mt-1 text-sm text-gray-900">Rp {{ number_format($product->operator_fee) }}</dd>
                        </div>
                    </dl>
                </div>

                <!-- Statistik -->
                <div>
                    <h4 class="font-medium text-gray-500 mb-2">Statistik</h4>
                    <dl class="space-y-3">
                        <div>
                            <dt class="text-sm text-gray-500">Estimasi Pengerjaan</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $product->estimate_time }} menit</dd>
                        </div>
                        <div>
                            <dt class="text-sm text-gray-500">Total Pesanan</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $product->order_items_count ?? 0 }} kali</dd>
                        </div>
                        <div>
                            <dt class="text-sm text-gray-500">Dibuat Pada</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $product->created_at->format('d M Y H:i') }}</dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
            <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-600 hover:text-red-900 flex items-center" onclick="return confirm('Hapus produk ini?')">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                    Hapus Produk
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
