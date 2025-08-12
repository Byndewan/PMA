@extends('layouts.customer')

@section('customer_content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <div class="flex justify-between items-start">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Order #{{ $order->order_number }}</h1>
                <p class="text-gray-600">Placed on {{ $order->created_at->format('F d, Y \a\t h:i A') }}</p>
            </div>
            <div>
                <span class="px-3 py-1 rounded-full text-sm font-medium
                    @if($order->status == 'pending') bg-yellow-100 text-yellow-800
                    @elseif($order->status == 'processing') bg-blue-100 text-blue-800
                    @elseif($order->status == 'completed') bg-green-100 text-green-800
                    @else bg-gray-100 text-gray-800 @endif">
                    {{ ucfirst($order->status) }}
                </span>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden mb-6">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-lg font-medium mb-4">Order Details</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Customer</h3>
                    <p>{{ $order->customer_name }}</p>
                    <p>{{ $order->phone }}</p>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Payment Status</h3>
                    <p class="capitalize">{{ $order->payment_status }}</p>
                </div>
            </div>

            <div class="mb-4">
                <h3 class="text-sm font-medium text-gray-500">Notes</h3>
                <p>{{ $order->notes ?? 'No special instructions' }}</p>
            </div>
        </div>

        <div class="p-6 border-b border-gray-200">
            <h2 class="text-lg font-medium mb-4">Items</h2>

            @foreach($order->items as $item)
                <div class="flex py-4 @if(!$loop->last) border-b border-gray-200 @endif">
                    <div class="flex-shrink-0 w-20 h-20 bg-gray-200 rounded-lg overflow-hidden">
                        <img src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                    </div>
                    <div class="ml-4 flex-1">
                        <div class="flex justify-between">
                            <div>
                                <h3 class="text-sm font-medium text-gray-900">{{ $item->product->name }}</h3>
                                <p class="text-sm text-gray-500">Qty: {{ $item->quantity }}</p>
                            </div>
                            <p class="text-sm font-medium text-gray-900">Rp {{ number_format($item->price_per_unit * $item->quantity, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="p-6">
            <div class="flex justify-between text-lg font-medium">
                <span>Total</span>
                <span>Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden mb-6">
        <div class="p-6">
            <h2 class="text-lg font-medium mb-4">Uploaded Files</h2>

            @foreach($order->items as $item)
                <div class="mb-4">
                    <h3 class="text-sm font-medium text-gray-900 mb-2">{{ $item->product->name }}</h3>
                    @if($item->file_path)
                        <div class="flex items-center">
                            <i class="fas fa-file-alt text-gray-400 mr-2"></i>
                            <a href="{{ Storage::url($item->file_path) }}" target="_blank" class="text-blue-500 hover:underline">
                                View File
                            </a>
                        </div>
                    @else
                        <p class="text-sm text-gray-500">No file uploaded</p>
                    @endif
                </div>
            @endforeach

            @if($order->status == 'pending' || $order->status == 'processing')
                <form method="POST" action="{{ route('customer.orders.upload', $order) }}" enctype="multipart/form-data" class="mt-4">
                    @csrf
                    <label class="block text-sm font-medium text-gray-700 mb-2">Upload Revised File</label>
                    <div class="flex">
                        <input type="file" name="file" class="flex-1 border border-gray-300 rounded-l-lg px-4 py-2">
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-r-lg hover:bg-blue-600">
                            Upload
                        </button>
                    </div>
                </form>
            @endif
        </div>
    </div>

    <div class="flex justify-between">
        <a href="{{ route('customer.orders.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">
            Back to Orders
        </a>
        @if($order->status == 'pending')
            <div class="space-x-2">
                <form method="POST" action="{{ route('customer.orders.cancel', $order) }}" class="inline">
                    @csrf
                    <button type="submit" class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">
                        Cancel Order
                    </button>
                </form>
                <a href="{{ route('customer.orders.payment', $order) }}" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                    Make Payment
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
