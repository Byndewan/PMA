@extends('layouts.app')

@section('page-title', 'Edit Produk')

@section('content')
<form action="{{ route('products.update', $product->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Field sama dengan create, tapi dengan value -->
        <div>
            <label for="name" class="block mb-1">Nama Produk</label>
            <input type="text" id="name" name="name" value="{{ $product->name }}" required class="w-full border rounded p-2">
        </div>

        <!-- ... (field lainnya) ... -->
    </div>

    <div class="mt-6 flex justify-end space-x-3">
        <a href="{{ route('products.index') }}" class="btn-secondary">
            Batal
        </a>
        <button type="submit" class="btn-primary">
            Update Produk
        </button>
    </div>
</form>
@endsection
