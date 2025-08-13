@extends('layouts.customer')

@section('customer_content')
<div class="space-y-4">
    <!-- Header and Actions -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-semibold text-gray-800">My Orders</h1>
            <p class="text-sm text-gray-500">View your order history</p>
        </div>
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
                    <input type="text" placeholder="Search orders..." id="search-input"
                        class="block w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                </div>
            </div>
            <div class="md:col-span-4">
                <select id="status-filter" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                    <option value="">All Status</option>
                    <option value="pending">Pending</option>
                    <option value="processing">Processing</option>
                    <option value="completed">Completed</option>
                    <option value="cancelled">Cancelled</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Orders Table -->
    @if($orders->count() > 0)
    <div class="bg-white rounded-lg border border-gray-100 overflow-hidden shadow-xs">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order #</th>
                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Items</th>
                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                        <th scope="col" class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($orders as $order)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-800">#{{ $order->order_number }}</td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">{{ $order->created_at->format('d M Y') }}</td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">{{ $order->items->count() }} item(s)</td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            @include('partials.status-badge', ['status' => $order->status])
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm font-semibold text-gray-800">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                        <td class="px-4 py-3 whitespace-nowrap text-left text-sm font-medium space-x-1">
                            <a href="{{ route('customer.orders.show', $order) }}" style="text-decoration: none;!important" class="inline-flex items-center p-1.5 text-gray-500 hover:text-blue-600 transition-colors rounded-lg hover:bg-blue-50" title="Detail">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </a>
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
    @else
    <div class="bg-white rounded-lg border border-gray-100 p-8 text-center shadow-xs">
        <i class="fas fa-box-open text-4xl text-gray-300 mb-3"></i>
        <h3 class="text-lg font-medium text-gray-900">No orders found</h3>
        <p class="mt-1 text-sm text-gray-500">You haven't placed any orders yet.</p>
        <div class="mt-6">
            <a href="{{ route('customer.products.index') }}" style="text-decoration: none;!important" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors shadow-sm">
                Browse Products
            </a>
        </div>
    </div>
    @endif
</div>

<script>
    // Status filter
    document.getElementById('status-filter').addEventListener('change', function(e) {
        const status = e.target.value;
        window.location.href = "{{ route('customer.orders.index') }}?status=" + status;
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
