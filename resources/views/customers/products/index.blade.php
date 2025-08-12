@extends('layouts.customer')

@section('customer_content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Our Products</h1>
    <p class="text-gray-600">Browse our product catalog</p>
</div>

<div class="mb-4">
    <form method="GET" action="{{ route('customer.products.index') }}" class="flex">
        <input type="text" name="search" placeholder="Search products..."
               value="{{ request('search') }}"
               class="flex-1 border border-gray-300 rounded-l-lg px-4 py-2 focus:outline-none focus:ring-1 focus:ring-blue-500">
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-r-lg hover:bg-blue-600">
            <i class="fas fa-search"></i>
        </button>
    </form>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
    @foreach($products as $product)
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="relative">
                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-48 object-cover">
                <button class="absolute top-2 right-2 text-2xl text-gray-400 hover:text-red-500"
                        onclick="toggleFavorite({{ $product->id }}, this)">
                    <i class="{{ auth()->user()->hasFavorited($product) ? 'fas text-red-500' : 'far' }} fa-heart"></i>
                </button>
            </div>
            <div class="p-4">
                <h3 class="font-semibold text-lg mb-1">{{ $product->name }}</h3>
                <p class="text-gray-600 text-sm mb-2">{{ Str::limit($product->description, 60) }}</p>
                <div class="flex justify-between items-center">
                    <span class="font-bold text-blue-600">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                    <a href="{{ route('customer.orders.create', $product) }}"
                       class="bg-blue-500 text-white px-3 py-1 rounded text-sm hover:bg-blue-600">
                        Order Now
                    </a>
                </div>
            </div>
        </div>
    @endforeach
</div>

@if($products->hasPages())
    <div class="mt-6">
        {{ $products->links() }}
    </div>
@endif

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
