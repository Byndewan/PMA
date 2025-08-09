@extends('layouts.app')

@section('page-title', 'Daftar Produk')

@section('page-actions')
    <a href="{{ route('products.create') }}" class="btn-primary">
        + Tambah Produk
    </a>
@endsection

@section('content')
<div class="overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left">Nama</th>
                <th class="px-6 py-3 text-left">Format</th>
                <th class="px-6 py-3 text-left">Harga</th>
                <th class="px-6 py-3 text-left">Status</th>
                <th class="px-6 py-3 text-left">Aksi</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @foreach($products as $product)
            <tr>
                <td class="px-6 py-4">{{ $product->name }}</td>
                <td class="px-6 py-4">{{ $product->format }}</td>
                <td class="px-6 py-4">Rp {{ number_format($product->price) }}</td>
                <td class="px-6 py-4">
                    @include('partials.status-badge', [
                        'status' => $product->is_active ? 'active' : 'inactive'
                    ])
                </td>
                <td class="px-6 py-4 space-x-2">
                    <a href="{{ route('products.edit', $product->id) }}" class="text-blue-600 hover:text-blue-900">
                        Edit
                    </a>
                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-900">
                            Hapus
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Pagination -->
<div class="mt-4">
    {{ $products->links() }}
</div>
@endsection
