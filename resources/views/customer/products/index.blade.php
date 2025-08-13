@extends('layouts.customer')

@section('customer_content')
    <div class="space-y-6">
        <!-- Header Section -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-semibold text-gray-800">Produk Kami</h1>
                <p class="text-gray-500 text-sm">Telusuri katalog produk kami</p>
            </div>
        </div>

        <!-- Search Bar -->
        <div class="bg-white rounded-lg p-4 shadow-xs border border-gray-100">
            <form method="GET" action="{{ route('customer.products.index') }}" class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <input type="text" name="search" placeholder="Cari produk..." value="{{ request('search') }}"
                    class="block w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
            </form>
        </div>

        <!-- Products Grid -->
        @if ($products->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                @foreach ($products as $product)
                    <div
                        class="bg-white rounded-lg shadow-xs border border-gray-100 overflow-hidden hover:shadow-sm transition-shadow">
                        <div class="relative">
                            <div class="w-full h-48 bg-gray-100 flex items-center justify-center">
                                @if ($product->image_url)
                                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
                                        class="w-full h-full object-cover">
                                @else
                                    @php
                                        $initials = collect(explode(' ', $product->name))
                                            ->map(fn($word) => strtoupper(substr($word, 0, 1)))
                                            ->join('');
                                    @endphp
                                    <span class="text-4xl font-bold text-gray-400">{{ $initials }}</span>
                                @endif
                            </div>
                            <button class="absolute top-3 right-3 p-2 text-gray-400 hover:text-red-500 transition-colors"
                                onclick="toggleFavorite({{ $product->id }}, this)">
                                @php
                                    $isFavorited = auth()->user()->favoriteProducts->contains($product->id);
                                @endphp

                                <i class="{{ $isFavorited ? 'fas text-red-500' : 'far' }} fa-heart"></i>
                            </button>
                        </div>
                        <div class="p-4">
                            <h3 class="font-semibold text-gray-800 mb-1">{{ $product->name }}</h3>
                            {{-- <p class="text-sm text-gray-500 mb-3">{{ Str::limit($product->description, 60) }}</p> --}}
                            <div class="flex items-center justify-between">
                                <span class="font-bold text-blue-600">Rp
                                    {{ number_format($product->price, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex items-center justify-between mt-3">
                                <a href="{{ route('customer.orders.create', $product) }}"
                                    class="inline-flex items-center px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors shadow-sm">
                                    Pesan
                                </a>
                                <a href="{{ route('customer.products.show', $product) }}"
                                    class="inline-flex items-center px-3 py-1.5 outline outline-1 outline-blue-600 hover:bg-blue-50 text-blue-600 text-sm font-medium rounded-lg transition-colors shadow-xl">
                                    Detail
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if ($products->hasPages())
                <div class="bg-white rounded-lg border border-gray-100 px-4 py-3 shadow-xs">
                    {{ $products->links() }}
                </div>
            @endif
        @else
            <div class="bg-white rounded-lg border border-gray-100 p-8 text-center shadow-xs">
                <i class="fas fa-box text-4xl text-gray-300 mb-3"></i>
                <h3 class="text-lg font-medium text-gray-900">Belum Ada Produk</h3>
                <p class="mt-1 text-sm text-gray-500">Belum Ada Produk Untuk Sekarang.</p>
            </div>
        @endif
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
                        toastr.success('Produk di tambahkan Ke Favorit.');
                    } else {
                        icon.classList.remove('fas', 'text-red-500');
                        icon.classList.add('far');
                        toastr.info('Produk di hapus dari Favorit.');
                    }
                });
        }
    </script>
@endsection
