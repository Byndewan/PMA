@extends('layouts.app')

@section('page-title', 'Daftar Produk Cetak')

@section('page-actions')
    <a href="{{ route('products.create') }}" class="btn-primary">
        + Produk Baru
    </a>
@endsection

@section('content')
<div class="mb-4 flex items-center justify-between">
    <div class="flex-1 max-w-md">
        <input
            type="text"
            placeholder="Cari produk..."
            class="w-full border rounded-lg px-4 py-2"
            id="search-input"
        >
    </div>
    <div>
        <select id="status-filter" class="border rounded-lg px-4 py-2">
            <option value="">Semua Status</option>
            <option value="active">Aktif</option>
            <option value="inactive">Nonaktif</option>
        </select>
    </div>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Produk</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Format</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fee Operator</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @foreach($products as $product)
            <tr class="hover:bg-gray-50 transition">
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="font-medium text-gray-900">{{ $product->name }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-gray-500">
                    {{ $product->format }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <span class="font-medium">Rp {{ number_format($product->price) }}</span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-gray-500">
                    Rp {{ number_format($product->operator_fee) }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    @include('partials.status-badge', [
                        'status' => $product->is_active ? 'active' : 'inactive'
                    ])
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                    <div class="flex items-center space-x-2">
                        <a href="{{ route('products.edit', $product->id) }}" class="text-blue-600 hover:text-blue-900 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                            </svg>
                            Edit
                        </a>
                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900 flex items-center" onclick="return confirm('Hapus produk ini?')">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                                Hapus
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $products->links() }}
</div>

<script>
    // Live search functionality
    document.getElementById('search-input').addEventListener('input', function(e) {
        const searchValue = e.target.value.toLowerCase();
        document.querySelectorAll('tbody tr').forEach(row => {
            const productName = row.querySelector('td:first-child').textContent.toLowerCase();
            row.style.display = productName.includes(searchValue) ? '' : 'none';
        });
    });

    // Status filter
    document.getElementById('status-filter').addEventListener('change', function(e) {
        const status = e.target.value;
        window.location.href = "{{ route('products.index') }}?status=" + status;
    });
</script>
@endsection
