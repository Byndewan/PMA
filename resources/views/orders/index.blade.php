@extends('layouts.app')

@section('page-title', 'Daftar Pesanan')

@section('page-actions')
    <a href="{{ route('orders.create') }}" class="btn-primary">
        + Pesanan Baru
    </a>
@endsection

@section('content')
<div class="mb-4 flex items-center space-x-4">
    <div class="flex-1">
        <input
            type="text"
            placeholder="Cari pesanan..."
            class="w-full border rounded-lg px-4 py-2"
            id="search-input"
        >
    </div>
    <div>
        <select id="status-filter" class="border rounded-lg px-4 py-2">
            <option value="">Semua Status</option>
            <option value="queue">Antri</option>
            <option value="process">Diproses</option>
            <option value="done">Selesai</option>
            <option value="taken">Diambil</option>
        </select>
    </div>
</div>

<div class="overflow-x-auto bg-white rounded-lg shadow">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pelanggan</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @foreach($orders as $order)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 whitespace-nowrap">#{{ $order->id }}</td>
                <td class="px-6 py-4 whitespace-nowrap">{{ $order->customer_name }}</td>
                <td class="px-6 py-4 whitespace-nowrap">{{ $order->created_at->format('d M Y H:i') }}</td>
                <td class="px-6 py-4 whitespace-nowrap">Rp {{ number_format($order->total_price) }}</td>
                <td class="px-6 py-4 whitespace-nowrap">
                    @include('partials.status-badge', ['status' => $order->status])
                </td>
                <td class="px-6 py-4 whitespace-nowrap space-x-2">
                    <a href="{{ route('orders.show', $order->id) }}" class="text-blue-600 hover:text-blue-900">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                            <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                        </svg>
                    </a>
                    @if($order->status != 'taken')
                    <a href="{{ route('orders.edit', $order->id) }}" class="text-yellow-600 hover:text-yellow-900">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                        </svg>
                    </a>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $orders->links() }}
</div>

<script>
    // Live search functionality
    document.getElementById('search-input').addEventListener('input', function(e) {
        // Implement AJAX search or filter
    });

    // Status filter
    document.getElementById('status-filter').addEventListener('change', function(e) {
        const status = e.target.value;
        window.location.href = "{{ route('orders.index') }}?status=" + status;
    });
</script>
@endsection
