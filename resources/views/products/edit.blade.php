<div class="bg-white rounded-lg overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
        <h3 class="text-lg font-medium text-gray-900">Edit Produk</h3>
        <p class="text-sm text-gray-500 mt-1">ID: {{ $product->id }}</p>
    </div>

    @include('products._form', [
        'action' => route('products.update', $product->id),
        'method' => 'PUT',
        'product' => $product
    ])
</div>
