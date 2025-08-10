@extends('layouts.app')

@section('page-title', 'Daftar Pesanan')

@section('content')
<div class="space-y-6">
    <!-- Search and Filter -->
    <div class="bg-white rounded-xl shadow-sm p-4">
        <div class="flex flex-col md:flex-row md:items-center md:space-x-4 space-y-4 md:space-y-0">
            <div class="flex-1 relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-search text-gray-400"></i>
                </div>
                <input
                    type="text"
                    placeholder="Cari pesanan..."
                    class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                    id="search-input"
                >
            </div>
            <div class="w-full md:w-48">
                <select id="status-filter" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                    <option value="">Semua Status</option>
                    <option value="queue">Antri</option>
                    <option value="process">Diproses</option>
                    <option value="done">Selesai</option>
                    <option value="taken">Diambil</option>
                </select>
            </div>
        </div>
    </div>
    <a href="{{ route('orders.create') }}" class="py-2 px-2 bg-blue-600 text-white font-bold rounded-lg flex items-center">
        <i class="fas fa-plus-circle mr-3"></i> Pesanan Baru
    </a>

    <!-- Orders Table -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pelanggan</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($orders as $order)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">#{{ $order->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $order->customer_name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $order->created_at->format('d M Y H:i') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">Rp {{ number_format($order->total_price) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @include('partials.status-badge', ['status' => $order->status])
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                            <a href="{{ route('orders.show', $order->id) }}" class="text-blue-600 hover:text-blue-900 transition-colors" title="Detail">
                                <i class="fas fa-eye"></i>
                            </a>
                            @if($order->status != 'taken')
                            <a href="{{ route('orders.edit', $order->id) }}" class="text-amber-600 hover:text-amber-900 transition-colors" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="px-4 py-3 bg-white rounded-xl shadow-sm">
        {{ $orders->links() }}
    </div>
</div>

<script>
    // Status filter
    document.getElementById('status-filter').addEventListener('change', function(e) {
        const status = e.target.value;
        window.location.href = "{{ route('orders.index') }}?status=" + status;
    });

    // Live search
    const searchInput = document.getElementById('search-input');
    let searchTimer;

    searchInput.addEventListener('input', function(e) {
        clearTimeout(searchTimer);
        searchTimer = setTimeout(() => {
            const query = e.target.value;
            // Implement AJAX search here
        }, 500);
    });
</script>
@endsection
