@extends('layouts.customer')

@section('customer_content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Dashboard</h1>
    <p class="text-gray-600">Selamat Datang, {{ auth()->user()->name }}!</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    <div class="bg-white p-4 rounded-lg shadow">
        <div class="text-gray-500 mb-1">Total Orders</div>
        <div class="text-2xl font-bold">{{ $orders->count() }}</div>
    </div>
    <div class="bg-white p-4 rounded-lg shadow">
        <div class="text-gray-500 mb-1">Pending Orders</div>
        <div class="text-2xl font-bold">{{ $orders->where('status', 'pending')->count() }}</div>
    </div>
    <div class="bg-white p-4 rounded-lg shadow">
        <div class="text-gray-500 mb-1">Completed Orders</div>
        <div class="text-2xl font-bold">{{ $orders->where('status', 'completed')->count() }}</div>
    </div>
</div>

<div class="bg-white p-4 rounded-lg shadow">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-lg font-semibold">Recent Orders</h2>
        <a href="{{ route('customer.orders.index') }}" class="text-blue-500 text-sm">View All</a>
    </div>

    @if($orders->count() > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr class="text-left border-b">
                        <th class="pb-2">Order #</th>
                        <th class="pb-2">Date</th>
                        <th class="pb-2">Status</th>
                        <th class="pb-2">Total</th>
                        <th class="pb-2">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders->take(5) as $order)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-3">{{ $order->order_number }}</td>
                            <td>{{ $order->created_at->format('d M Y') }}</td>
                            <td>
                                <span class="px-2 py-1 text-xs rounded-full
                                    @if($order->status == 'pending') bg-yellow-100 text-yellow-800
                                    @elseif($order->status == 'completed') bg-green-100 text-green-800
                                    @else bg-gray-100 text-gray-800 @endif">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td>Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                            <td>
                                <a href="{{ route('customer.orders.show', $order) }}"
                                   class="text-blue-500 hover:text-blue-700">
                                    View
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p class="text-gray-500 py-4">You don't have any orders yet.</p>
    @endif
</div>
@endsection
