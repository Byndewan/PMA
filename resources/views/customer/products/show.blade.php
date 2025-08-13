@extends('layouts.customer')

@section('customer_content')
<div class="space-y-6">
    <!-- Back Button -->
    <div class="flex space-x-2 justify-end">
        <a href="{{ route('customer.products.index') }}" style="text-decoration: none;!important" class="inline-flex items-center px-4 py-2.5 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition-colors shadow-sm">
            Back
        </a>
    </div>

    <!-- Product Detail -->
    <div class="bg-white rounded-xl shadow-xs border border-gray-100 overflow-hidden">
        <div class="md:flex">
            <!-- Product Image -->
            <div class="md:w-1/2 p-5">
                <div class="bg-gray-100 rounded-lg overflow-hidden mb-4 h-80 flex items-center justify-center">
                    @if($product->image_url)
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                    @else
                        @php
                            $initials = collect(explode(' ', $product->name))->map(fn($word) => strtoupper(substr($word, 0, 1)))->join('');
                        @endphp
                        <span class="text-6xl font-bold text-gray-400">{{ $initials }}</span>
                    @endif
                </div>
                <div class="flex justify-center space-x-3">
                    <button onclick="shareProduct('{{ $product->name }}', '{{ route('customer.orders.create', $product) }}')"
                        class="p-2 rounded-lg bg-gray-50 hover:bg-gray-100 transition-colors">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                        </svg>
                    </button>
                    <button class="p-2 rounded-lg bg-gray-50 hover:bg-gray-100 transition-colors"
                            onclick="toggleFavorite({{ $product->id }}, this)">
                        @php
                            $isFavorited = auth()->user()->favoriteProducts->contains($product->id);
                        @endphp

                        <i class="{{ $isFavorited ? 'fas text-red-500' : 'far' }} fa-heart"></i>
                    </button>
                </div>
            </div>

            <!-- Product Info -->
            <div class="md:w-1/2 p-5">
                <h1 class="text-2xl font-semibold text-gray-800 mb-2">{{ $product->name }}</h1>

                {{-- <div class="flex items-center mb-4">
                    <div class="flex items-center text-amber-400 mr-2">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                    </div>
                    <span class="text-sm text-gray-500">(24 ulasan)</span>
                </div> --}}

                <div class="text-2xl font-bold text-blue-600 mb-5">
                    Rp {{ number_format($product->price, 0, ',', '.') }}
                </div>

                <div class="mb-6">
                    <h3 class="text-sm font-medium text-gray-700 mb-2">Deskripsi</h3>
                    <p class="text-gray-600">{{ $product->description }}</p>
                </div>

                <div class="mb-6">
                    <h3 class="text-sm font-medium text-gray-700 mb-2">Detail</h3>
                    <ul class="text-gray-600 space-y-1">
                        <li class="flex"><span class="font-medium w-24">Estimasi :</span> {{ $product->estimate_time ?? '-' }} Menit</li>
                        <li class="flex"><span class="font-medium w-24">Ukuran :</span> {{ $product->format ?? '-' }}</li>
                    </ul>
                </div>

                <a href="{{ route('customer.orders.create', $product) }}"
                   class="block w-full text-center px-4 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg shadow-sm transition-colors">
                    Pesan Sekarang
                </a>
            </div>
        </div>
    </div>

    <!-- Related Products -->
    <div class="bg-white rounded-xl shadow-xs border border-gray-100 overflow-hidden">
        <div class="p-5 border-b border-gray-100">
            <h2 class="text-lg font-semibold text-gray-800">Produk Terkait</h2>
        </div>
        <div class="p-5">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($relatedProducts as $product)
                <a href="{{ route('customer.products.show', $product) }}" class="group">
                    <div class="bg-white rounded-lg border border-gray-100 overflow-hidden hover:shadow-sm transition-shadow">
                        <div class="w-full h-40 bg-gray-100 flex items-center justify-center">
                            @if($product->image_url)
                                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform">
                            @else
                                @php
                                    $initials = collect(explode(' ', $product->name))->map(fn($word) => strtoupper(substr($word, 0, 1)))->join('');
                                @endphp
                                <span class="text-3xl font-bold text-gray-400">{{ $initials }}</span>
                            @endif
                        </div>
                        <div class="p-3">
                            <h3 class="font-medium text-gray-800 group-hover:text-blue-600 transition-colors">{{ $product->name }}</h3>
                            <p class="text-blue-600 font-medium">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </div>
</div>

<script>
    function shareProduct(title, url) {
        if (navigator.share) {
            navigator.share({
                title: title,
                text: `Lihat produk ini: ${title}`,
                url: url
            }).catch(err => console.error('Share dibatalkan atau error:', err));
        } else {
            navigator.clipboard.writeText(url).then(() => {
                alert('Link disalin ke clipboard!');
            });
        }
    }
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
