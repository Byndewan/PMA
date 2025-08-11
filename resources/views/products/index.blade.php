@extends('layouts.app')

@section('page-title', 'Daftar Produk Cetak')

@section('content')
<div class="space-y-4">
    <!-- Header and Actions -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-semibold text-gray-800">Daftar Produk Cetak</h1>
            <p class="text-sm text-gray-500">Kelola semua produk cetak yang tersedia</p>
        </div>
        <a href="{{ route('products.create') }}" style="text-decoration: none;!important" class="inline-flex items-center px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors shadow-sm">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Produk Baru
        </a>
    </div>

    <!-- Search and Filter -->
    <div class="bg-white rounded-lg border border-gray-100 p-4 shadow-xs">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-3">
            <div class="md:col-span-8">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input type="text" placeholder="Cari produk..." id="search-input"
                        class="block w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                </div>
            </div>
            <div class="md:col-span-4">
                <select id="status-filter" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                    <option value="">Semua Status</option>
                    <option value="active">Aktif</option>
                    <option value="inactive">Nonaktif</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Products Table -->
    <div class="bg-white rounded-lg border border-gray-100 overflow-hidden shadow-xs">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Produk</th>
                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Format</th>
                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga</th>
                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fee Operator</th>
                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($products as $product)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-4 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10 rounded-lg bg-blue-50 flex items-center justify-center text-blue-600 mr-3">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <div class="font-medium text-gray-800">{{ $product->name }}</div>
                                    <div class="text-xs text-gray-500 mt-1">
                                        {{ $product->order_items_count ?? 0 }} pesanan
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $product->format }}
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm font-semibold text-gray-800">
                            Rp {{ number_format($product->price) }}
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">
                            Rp {{ number_format($product->operator_fee) }}
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap">
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-medium {{ $product->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $product->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap text-right text-sm font-medium space-x-1">
                            <a href="{{ route('products.edit', $product->id) }}" style="text-decoration: none;!important" class="inline-flex items-center p-1.5 text-gray-500 hover:text-blue-600 transition-colors rounded-lg hover:bg-blue-50" title="Edit">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </a>
                            <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center p-1.5 text-gray-500 hover:text-red-600 transition-colors rounded-lg hover:bg-red-50" title="Hapus" onclick="return confirm('Hapus produk ini?')">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="px-4 py-3 bg-white rounded-lg border border-gray-100 shadow-xs">
        {{ $products->links() }}
    </div>
</div>

<script>
    // Status filter
    document.getElementById('status-filter').addEventListener('change', function(e) {
        const status = e.target.value;
        window.location.href = "{{ route('products.index') }}?status=" + status;
    });

    // Live search
    const searchInput = document.getElementById('search-input');
    let searchTimer;

    searchInput.addEventListener('input', function(e) {
        clearTimeout(searchTimer);
        searchTimer = setTimeout(() => {
            const query = e.target.value.toLowerCase();
            document.querySelectorAll('tbody tr').forEach(row => {
                const productName = row.querySelector('td:first-child').textContent.toLowerCase();
                row.style.display = productName.includes(query) ? '' : 'none';
            });
        }, 300);
    });
</script>
@endsection
