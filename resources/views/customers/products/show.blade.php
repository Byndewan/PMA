@extends('layouts.customer')

@section('customer_content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('customer.products.index') }}" class="text-blue-500 hover:text-blue-700 flex items-center">
            <i class="fas fa-arrow-left mr-2"></i> Back to Products
        </a>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="md:flex">
            <div class="md:w-1/2 p-6">
                <div class="bg-gray-100 rounded-lg overflow-hidden mb-4">
                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-auto">
                </div>
                <div class="flex justify-center space-x-2">
                    <button class="p-2 rounded-full bg-gray-100 hover:bg-gray-200">
                        <i class="fas fa-share-alt text-gray-600"></i>
                    </button>
                    <button class="p-2 rounded-full bg-gray-100 hover:bg-gray-200"
                            onclick="toggleFavorite({{ $product->id }}, this)">
                        <i class="{{ auth()->user()->hasFavorited($product) ? 'fas text-red-500' : 'far' }} fa-heart"></i>
                    </button>
                </div>
            </div>
            <div class="md:w-1/2 p-6">
                <h1 class="text-2xl font-bold text-gray-800 mb-2">{{ $product->name }}</h1>
                <div class="flex items-center mb-4">
                    <div class="flex items-center text-yellow-400 mr-2">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                    <span class="text-sm text-gray-500">(24 reviews)</span>
                </div>
                <div class="text-2xl font-bold text-blue-600 mb-4">
                    Rp {{ number_format($product->price, 0, ',', '.') }}
                </div>
                <div class="mb-6">
                    <h3 class="text-sm font-medium text-gray-700 mb-2">Description</h3>
                    <p class="text-gray-600">{{ $product->description }}</p>
                </div>
                <div class="mb-6">
                    <h3 class="text-sm font-medium text-gray-700 mb-2">Specifications</h3>
                    <ul class="text-gray-600 space-y-1">
                        <li><span class="font-medium">Material:</span> {{ $product->material ?? 'N/A' }}</li>
                        <li><span class="font-medium">Size:</span> {{ $product->size ?? 'N/A' }}</li>
                        <li><span class="font-medium">Weight:</span> {{ $product->weight ?? 'N/A' }}</li>
                    </ul>
                </div>
                <a href="{{ route('customer.orders.create', $product) }}"
                   class="w-full bg-blue-500 text-white py-3 px-4 rounded-lg hover:bg-blue-600 text-center block">
                    Order Now
                </a>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden mt-6">
        <div class="p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Related Products</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                @foreach($relatedProducts as $product)
                    <div class="border border-gray-200 rounded-lg overflow-hidden hover:shadow-md transition">
                        <a href="{{ route('customer.products.show', $product) }}">
                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-48 object-cover">
                        </a>
                        <div class="p-4">
                            <a href="{{ route('customer.products.show', $product) }}" class="block">
                                <h3 class="font-medium text-gray-900 mb-1">{{ $product->name }}</h3>
                                <p class="text-blue-600 font-medium">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<script>
    function toggleFavorite(productId, element) {
        fetch(`/customer/products/${productId}/favorite`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            const icon = element.querySelector('i');
            if (data.action === 'added') {
                icon.classList.remove('far');
                icon.classList.add('fas', 'text-red-500');
            } else {
                icon.classList.remove('fas', 'text-red-500');
                icon.classList.add('far');
            }
        });
    }
</script>
@endsection
