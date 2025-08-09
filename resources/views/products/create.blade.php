<div class="bg-white rounded-lg overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
        <h3 class="text-lg font-medium text-gray-900">Tambah Produk Baru</h3>
    </div>

    @include('products._form', [
        'action' => route('products.store'),
        'method' => 'POST'
    ])
</div>
