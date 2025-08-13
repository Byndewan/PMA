@extends('layouts.customer')

@section('customer_content')
<div class="space-y-4">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-gray-800">Payment for Order #{{ $order->order_number }}</h1>
            <p class="text-sm text-gray-500">Complete your payment to process the order</p>
        </div>
        <div class="flex space-x-2">
            <a href="{{ route('customer.orders.show', $order) }}" style="text-decoration: none;!important" class="inline-flex items-center px-4 py-2.5 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition-colors shadow-sm">
                Back to Order
            </a>
        </div>
    </div>

    <form method="POST" action="{{ route('customer.orders.submit_payment', $order) }}" enctype="multipart/form-data">
        @csrf

        <!-- Order Summary -->
        <div class="bg-white rounded-lg border border-gray-100 p-4 shadow-xs">
            <h3 class="text-lg font-semibold mb-4 text-gray-800">Order Summary</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-blue-50 p-4 rounded-lg">
                    <p class="text-sm font-medium text-gray-500">Order Total</p>
                    <p class="mt-1 text-xl font-semibold text-gray-800">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                </div>
                <div class="bg-green-50 p-4 rounded-lg">
                    <p class="text-sm font-medium text-gray-500">Payment Status</p>
                    <p class="mt-1 text-xl font-semibold text-gray-800 capitalize">{{ $order->payment_status }}</p>
                </div>
            </div>
        </div>

        <!-- Payment Method -->
        <div class="bg-white rounded-lg border border-gray-100 p-4 shadow-xs mt-3">
            <h3 class="text-lg font-semibold mb-4 text-gray-800">Payment Method</h3>
            <div class="space-y-4">
                <div>
                    <label class="block mb-1.5 text-sm font-medium text-gray-700">Payment Method</label>
                    <select name="payment_method" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                        <option value="cash">Cash</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="flex justify-end mt-3">
            <button type="submit" class="inline-flex items-center px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors shadow-sm">
                Submit Payment
            </button>
        </div>
    </form>
</div>
@endsection
