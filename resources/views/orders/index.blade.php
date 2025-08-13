@extends('layouts.app')

@section('page-title', 'Daftar Pesanan')

@section('content')
<div class="space-y-4">
    <!-- Header and Actions -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-semibold text-gray-800">Daftar Pesanan</h1>
            <p class="text-sm text-gray-500">Kelola semua pesanan pelanggan</p>
        </div>
        <a href="{{ route('orders.create') }}" style="text-decoration: none;!important" class="inline-flex items-center px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors shadow-sm">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Pesanan Baru
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
                    <input type="text" placeholder="Cari pesanan..." id="search-input"
                        class="block w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                </div>
            </div>
            <div class="md:col-span-4">
                <select id="status-filter" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                    <option value="">Semua Status</option>
                    <option value="queue">Antri</option>
                    <option value="process">Diproses</option>
                    <option value="done">Selesai</option>
                    <option value="taken">Diambil</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Orders Table -->
    <div class="bg-white rounded-lg border border-gray-100 overflow-hidden shadow-xs">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($orders as $order)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-800">#{{ $order->id }}</td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-800">{{ $order->customer_name }}</td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">{{ $order->created_at->format('d M Y H:i') }}</td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm font-semibold text-gray-800">Rp {{ number_format($order->total_price) }}</td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            @include('partials.status-badge', ['status' => $order->status])
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-left text-sm font-medium space-x-1">
                            <a href="{{ route('orders.show', $order->id) }}" style="text-decoration: none;!important" class="inline-flex items-center p-1.5 text-gray-500 hover:text-blue-600 transition-colors rounded-lg hover:bg-blue-50" title="Detail">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </a>
                            @if($order->status != 'taken')
                            <a href="{{ route('orders.edit', $order->id) }}" style="text-decoration: none;!important" class="inline-flex items-center p-1.5 text-gray-500 hover:text-amber-600 transition-colors rounded-lg hover:bg-amber-50" title="Edit">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </a>
                            @endif
                            <form action="{{ route('orders.destroy', $order->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center p-1.5 text-gray-500 hover:text-red-600 transition-colors rounded-lg hover:bg-red-50" title="Hapus" onclick="return confirm('Hapus pesanan ini?')">
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
        {{ $orders->links() }}
    </div>
</div>

@if(session('notify') && session('status_message'))
<script>
    const status = "{{ session('status_message') }}";

    // Mapping status ke pesan notifikasi
    const messages = {
        queue: "Pesanan Anda sedang dalam antrean. Mohon tunggu prosesnya.",
        process: "Pesanan Anda sekarang sedang diproses.",
        done: "Pesanan Anda siap diambil.",
        taken: "Pesanan telah diterima. Terima kasih!"
    };

    const bodyMessage = messages[status] || "Status Pesanan di Update.";

    if (Notification.permission === "granted") {
        new Notification("Order Updated", {
            body: bodyMessage,
            icon: "{{ asset('uploads/logo.png') }}"
        });
    } else if (Notification.permission !== "denied") {
        Notification.requestPermission().then(permission => {
            if (permission === "granted") {
                new Notification("Order Updated", {
                    body: bodyMessage,
                    icon: "{{ asset('uploads/logo.png') }}"
                });
            }
        });
    }
</script>
@endif

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
