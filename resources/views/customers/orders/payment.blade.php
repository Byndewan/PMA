@extends('layouts.customer')

@section('customer_content')
<div class="max-w-md mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Payment for Order #{{ $order->order_number }}</h1>
        <p class="text-gray-600">Complete your payment to process the order</p>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="mb-6">
            <h3 class="text-lg font-medium mb-2">Order Summary</h3>
            <div class="bg-gray-50 p-4 rounded-lg">
                <div class="flex justify-between mb-2">
                    <span class="text-gray-600">Order Total:</span>
                    <span class="font-medium">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Payment Status:</span>
                    <span class="font-medium capitalize">{{ $order->payment_status }}</span>
                </div>
            </div>
        </div>

        <form method="POST" action="{{ route('customer.orders.submit_payment', $order) }}" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Payment Method</label>
                <select name="payment_method" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-1 focus:ring-blue-500">
                    <option value="transfer">Bank Transfer</option>
                    <option value="cash">Cash Payment</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Upload Payment Proof</label>
                <div class="border border-gray-300 rounded-lg p-4 border-dashed">
                    <input type="file" name="payment_proof" id="payment-proof" class="hidden" accept="image/*">
                    <label for="payment-proof" class="cursor-pointer flex flex-col items-center">
                        <i class="fas fa-cloud-upload-alt text-3xl text-gray-400 mb-2"></i>
                        <p class="text-gray-500">Click to upload payment proof</p>
                        <p class="text-xs text-gray-400 mt-1">JPG, PNG (Max 2MB)</p>
                    </label>
                </div>
                @if($order->payment_proof)
                    <div class="mt-2">
                        <p class="text-sm text-gray-500">Current proof:
                            <a href="{{ Storage::url($order->payment_proof) }}" target="_blank" class="text-blue-500 hover:underline">
                                View
                            </a>
                        </p>
                    </div>
                @endif
                <p id="proof-name" class="text-sm text-gray-500 mt-2 hidden"></p>
            </div>

            <div class="mt-6">
                <button type="submit" class="w-full bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600">
                    Submit Payment
                </button>
                <a href="{{ route('customer.orders.show', $order) }}" class="block text-center mt-2 text-blue-500 hover:text-blue-700">
                    Back to Order
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('payment-proof').addEventListener('change', function(e) {
        const fileName = e.target.files[0]?.name || 'No file selected';
        document.getElementById('proof-name').textContent = fileName;
        document.getElementById('proof-name').classList.remove('hidden');
    });
</script>
@endsection
