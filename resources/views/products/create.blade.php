@extends('layouts.app')

@section('page-title', 'Tambah Produk Baru')

@section('content')
<form action="{{ route('products.store') }}" method="POST">
    @csrf

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Nama Produk -->
        <div>
            <label for="name" class="block mb-1">Nama Produk</label>
            <input type="text" id="name" name="name" required class="w-full border rounded p-2">
        </div>

        <!-- Format -->
        <div>
            <label for="format" class="block mb-1">Format/Ukuran</label>
            <input type="text" id="format" name="format" required class="w-full border rounded p-2">
        </div>

        <!-- Harga -->
        <div>
            <label for="price" class="block mb-1">Harga Satuan</label>
            <input type="number" id="price" name="price" required class="w-full border rounded p-2">
        </div>

        <!-- Fee Operator -->
        <div>
            <label for="operator_fee" class="block mb-1">Fee Operator</label>
            <input type="number" id="operator_fee" name="operator_fee" value="300" required class="w-full border rounded p-2">
        </div>
    </div>

    <!-- Estimasi Waktu -->
    <div class="mt-4">
        <label for="estimate_time" class="block mb-1">Estimasi Pengerjaan (menit)</label>
        <input type="number" id="estimate_time" name="estimate_time" required class="w-full border rounded p-2">
    </div>

    <!-- Status -->
    <div class="mt-4">
        <label class="inline-flex items-center">
            <input type="checkbox" name="is_active" checked class="rounded border-gray-300">
            <span class="ml-2">Aktif</span>
        </label>
    </div>

    <!-- Tombol Submit -->
    <div class="mt-6 flex justify-end space-x-3">
        <a href="{{ route('products.index') }}" class="btn-secondary">
            Batal
        </a>
        <button type="submit" class="btn-primary">
            Simpan Produk
        </button>
    </div>
</form>
@endsection
