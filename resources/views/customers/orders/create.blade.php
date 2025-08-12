@extends('layouts.customer')

@section('customer_content')
<div class="max-w-2xl mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">New Order</h1>
        <p class="text-gray-600">Order for: {{ $product->name }}</p>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <form method="POST" action="{{ route('customer.orders.store') }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">

            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Quantity</label>
                <input type="number" name="quantity" min="1" value="1"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-1 focus:ring-blue-500">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Special Instructions</label>
                <textarea name="notes" rows="3"
                          class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-1 focus:ring-blue-500"></textarea>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Upload Design File</label>
                <div class="border border-gray-300 rounded-lg p-4 border-dashed">
                    <input type="file" name="file" id="file-upload" class="hidden">
                    <label for="file-upload" class="cursor-pointer flex flex-col items-center">
                        <i class="fas fa-cloud-upload-alt text-3xl text-gray-400 mb-2"></i>
                        <p class="text-gray-500">Click to upload or drag and drop</p>
                        <p class="text-xs text-gray-400 mt-1">JPG, PNG, PDF, DOC/DOCX (Max 5MB)</p>
                    </label>
                </div>
                <p id="file-name" class="text-sm text-gray-500 mt-2 hidden"></p>
            </div>

            <div class="bg-blue-50 p-4 rounded-lg mb-6">
                <h3 class="font-semibold mb-2">Order Summary</h3>
                <div class="flex justify-between mb-1">
                    <span>Product:</span>
                    <span>{{ $product->name }}</span>
                </div>
                <div class="flex justify-between mb-1">
                    <span>Price per unit:</span>
                    <span>Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between font-bold">
                    <span>Total:</span>
                    <span id="total-price">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                </div>
            </div>

            <div class="flex justify-end space-x-3">
                <a href="{{ route('customer.products.show', $product) }}"
                   class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">
                    Cancel
                </a>
                <button type="submit"
                        class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                    Place Order
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('file-upload').addEventListener('change', function(e) {
        const fileName = e.target.files[0]?.name || 'No file selected';
        document.getElementById('file-name').textContent = fileName;
        document.getElementById('file-name').classList.remove('hidden');
    });

    document.querySelector('input[name="quantity"]').addEventListener('change', function() {
        const quantity = parseInt(this.value);
        const price = {{ $product->price }};
        const total = quantity * price;
        document.getElementById('total-price').textContent = 'Rp ' + total.toLocaleString('id-ID');
    });
</script>
@endsection
