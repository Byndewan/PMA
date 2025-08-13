@extends('layouts.customer')

@section('customer_content')
<div class="space-y-4">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-gray-800">Order #{{ $order->order_number }}</h1>
            <p class="text-sm text-gray-500">Placed on {{ $order->created_at->format('d M Y H:i') }}</p>
        </div>
        <div class="flex space-x-2">
            <a href="{{ route('customer.orders.index') }}" style="text-decoration: none;!important" class="inline-flex items-center px-4 py-2.5 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition-colors shadow-sm">
                Back
            </a>
        </div>
    </div>

    <!-- Order Header -->
    <div class="bg-white rounded-lg border border-gray-100 p-4 shadow-xs">
        <div class="flex items-center justify-between space-x-3">
            @include('partials.status-badge', ['status' => $order->status])
            <div class="mt-3">
                <p class="text-sm text-gray-500">Payment Status: <span class="ml-2">@include('partials.status-badge', ['status' => $order->status])</span></p>
            </div>
        </div>
    </div>

    <!-- Customer Information -->
    <div class="bg-white rounded-lg border border-gray-100 p-4 shadow-xs">
        <h3 class="text-lg font-semibold mb-3 text-gray-800">Customer Information</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <p class="text-sm font-medium text-gray-500">Name</p>
                <p class="mt-1 text-gray-800">{{ $order->customer_name }}</p>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Phone</p>
                <p class="mt-1 text-gray-800">{{ $order->phone }}</p>
            </div>
        </div>
    </div>

    <!-- Order Summary -->
    <div class="bg-white rounded-lg border border-gray-100 p-4 shadow-xs">
        <h3 class="text-lg font-semibold mb-3 text-gray-800">Order Summary</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="bg-blue-50 p-4 rounded-lg">
                <p class="text-sm font-medium text-gray-500">Total Price</p>
                <p class="mt-1 text-xl font-semibold text-gray-800">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
            </div>
            <div class="bg-gray-50 p-4 rounded-lg">
                <p class="text-sm font-medium text-gray-500">Order Date</p>
                <p class="mt-1 text-xl font-semibold text-gray-800">{{ $order->created_at->format('d M Y H:i') }}</p>
            </div>
        </div>
    </div>

    <!-- Order Items -->
    <div class="bg-white rounded-lg border border-gray-100 p-4 shadow-xs">
        <h3 class="text-lg font-semibold mb-4 text-gray-800">Order Items</h3>
        <div class="space-y-4">
        @foreach($order->items as $item)
            <div class="border border-gray-200 rounded-lg p-4 bg-gray-50">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-3">
                    <!-- Product Info -->
                    <div class="space-y-1">
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Product</p>
                        <p class="text-gray-800 font-medium">{{ $item->product->name }}</p>
                    </div>

                    <!-- Quantity -->
                    <div class="space-y-1">
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</p>
                        <p class="text-gray-800">{{ $item->quantity }}</p>
                    </div>

                    <!-- Price -->
                    <div class="space-y-1">
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Price</p>
                        <p class="text-gray-800">Rp {{ number_format($item->price_per_unit, 0, ',', '.') }}</p>
                    </div>

                    <!-- File -->
                    <div class="space-y-1">
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">File</p>
                        <a href="{{ asset('storage/'.$item->file_path) }}" target="_blank"
                           class="inline-flex items-center text-blue-600 hover:text-blue-800 text-sm">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                            </svg>
                            Lihat Pratinjau
                        </a>
                    </div>
                </div>

                @if($order->status == 'pending' || $order->status == 'processing')
                <!-- Revision Upload Form -->
                <form method="POST" action="{{ route('customer.orders.upload', $item) }}" enctype="multipart/form-data" class="border-t border-gray-200 pt-3 mt-3">
                    @csrf
                    <input type="hidden" name="item_id" value="{{ $item->id }}">
                    <div class="flex flex-col sm:flex-row gap-3">
                        <div class="flex-grow">
                            <input type="file" name="file" required
                                   class="block w-full text-sm text-gray-500
                                          file:mr-4 file:py-2 file:px-4
                                          file:rounded-md file:border-0
                                          file:text-sm file:font-semibold
                                          file:bg-blue-50 file:text-blue-700
                                          hover:file:bg-blue-100">
                        </div>
                        <button type="submit"
                                class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-md transition-colors shadow-sm whitespace-nowrap">
                            Upload Revision
                        </button>
                    </div>
                </form>
                @endif
            </div>
            @endforeach
        </div>
    </div>

</div>
@endsection
