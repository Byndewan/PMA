@extends('layouts.customer')

@section('customer_content')
    <form action="{{ route('customer.orders.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="product_id" value="{{ $product->id }}">

        <div x-data="{
            items: [{ quantity: 1, file: null, previewUrl: null }],
            productPrice: {{ $product->price }},
            serviceFee: 300,
            estimateTime: {{ $product->estimate_time }},
            calculateTotal() {
                const totalQuantity = this.items.reduce((sum, item) => sum + (parseInt(item.quantity) || 0), 0);
                const totalPrice = this.productPrice * totalQuantity;
                const totalServiceFee = this.serviceFee * this.items.length;
                document.getElementById('total-price').textContent = 'Rp ' + totalPrice.toLocaleString('id-ID');
                document.getElementById('service-fee').textContent = 'Rp ' + totalServiceFee.toLocaleString('id-ID');

                const maxQuantity = Math.max(...this.items.map(item => parseInt(item.quantity) || 1)); // ✅ diperbaiki
                const now = new Date();
                now.setMinutes(now.getMinutes() + (this.estimateTime * maxQuantity));
                document.getElementById('estimate-time').textContent = now.toLocaleTimeString('id-ID', {
                    hour: '2-digit',
                    minute: '2-digit',
                    hour12: false
                });
            }
        }" class="space-y-4">
            <!-- Header -->
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-semibold text-gray-800">Buat Pesanan Baru</h1>
                    <p class="text-sm text-gray-500">Isi formulir untuk membuat pesanan {{ $product->name }}</p>
                </div>
            </div>

            <!-- Customer Information -->
            <div class="bg-white rounded-lg border border-gray-100 p-4 shadow-xs">
                <h3 class="text-lg font-semibold mb-4 text-gray-800">Informasi Pelanggan</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="customer_name" class="block mb-1.5 text-sm font-medium text-gray-700">Nama
                            Customer</label>
                        <input required type="text" id="customer_name" name="customer_name"
                            value="{{ auth()->user()->name }}"
                            class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                    </div>
                    <div>
                        <label for="customer_phone" class="block mb-1.5 text-sm font-medium text-gray-700">Nomor
                            Telepon</label>
                        <input required type="text" id="customer_phone" name="customer_phone"
                            value="{{ auth()->user()->phone }}"
                            class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                    </div>
                </div>
            </div>

            <!-- Order Items -->
            <div class="bg-white rounded-lg border border-gray-100 p-4 shadow-xs">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-800">Item Pesanan</h3>
                    <button type="button" @click="items.push({ quantity: 1, file: null, previewUrl: null })"
                        class="inline-flex items-center px-3 py-1.5 bg-white border border-gray-300 text-sm font-medium rounded-lg text-gray-700 hover:bg-gray-50 transition-colors shadow-sm">
                        Tambah Item
                    </button>
                </div>

                <template x-for="(item, index) in items" :key="index">
                    <div class="border border-gray-200 rounded-lg p-4 mb-3 bg-gray-50">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                            <!-- Product Info -->
                            <div>
                                <label class="block mb-1.5 text-sm font-medium text-gray-700">Produk</label>
                                <div class="p-2 bg-white border border-gray-200 rounded-lg">
                                    <p class="font-medium">{{ $product->name }}</p>
                                    <p class="text-sm text-blue-600">Rp {{ number_format($product->price) }}</p>
                                </div>
                            </div>

                            <!-- Quantity -->
                            <div>
                                <label class="block mb-1.5 text-sm font-medium text-gray-700">Jumlah</label>
                                <input required type="number" x-model="item.quantity" :name="`items[${index}][quantity]`"
                                    min="1" @input="calculateTotal()"
                                    class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                            </div>

                            <!-- File Upload -->
                            <div>
                                <label class="block mb-1.5 text-sm font-medium text-gray-700">File Cetak</label>
                                <div class="relative">
                                    <input required type="file" :name="`items[${index}][file]`" accept="image/*" required
                                        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                                        @change="
                                        item.file = $event.target.files[0];
                                        if (item.file) {
                                            let reader = new FileReader();
                                            reader.onload = e => item.previewUrl = e.target.result;
                                            reader.readAsDataURL(item.file);
                                        }
                                    ">
                                    <label
                                        class="flex items-center justify-between px-4 py-2.5 bg-white border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 transition text-sm">
                                        <span class="truncate text-gray-500"
                                            x-text="item.file ? item.file.name : 'Pilih file'"></span>
                                        <svg class="w-4 h-4 ml-2 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12">
                                            </path>
                                        </svg>
                                    </label>
                                </div>

                                <template x-if="item.previewUrl">
                                    <div class="mt-2">
                                        <img :src="item.previewUrl"
                                            class="w-20 h-20 object-cover rounded cursor-pointer border border-gray-200 hover:opacity-80"
                                            @click="showPreview(item.previewUrl)">
                                    </div>
                                </template>
                            </div>
                        </div>

                        <button type="button" x-show="items.length > 1" @click="items.splice(index, 1); calculateTotal();"
                            class="mt-2 text-sm text-red-600 hover:text-red-800 transition-colors flex items-center">
                            Hapus Item
                        </button>
                    </div>
                </template>
            </div>

            <!-- Special Instructions -->
            <div class="bg-white rounded-lg border border-gray-100 p-4 shadow-xs">
                <label class="block mb-1.5 text-sm font-medium text-gray-700">Catatan Khusus (Opsional)</label>
                <textarea name="notes" rows="2"
                    class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"></textarea>
            </div>

            <!-- Order Summary -->
            <div class="bg-white rounded-lg border border-gray-100 p-4 shadow-xs">
                <h3 class="text-lg font-semibold mb-4 text-gray-800">Ringkasan Pesanan</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-blue-50 p-4 rounded-lg">
                        <p class="text-sm font-medium text-gray-500">Total Harga</p>
                        <p class="mt-1 text-xl font-semibold text-gray-800" id="total-price">Rp
                            {{ number_format($product->price) }}</p>
                    </div>
                    <div class="bg-amber-50 p-4 rounded-lg">
                        <p class="text-sm font-medium text-gray-500">Estimasi Selesai</p>
                        <p class="mt-1 text-xl font-semibold text-gray-800" id="estimate-time">
                            {{ now()->addMinutes($product->estimate_time)->format('H:i') }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end space-x-3">
                <a href="{{ route('customer.products.show', $product) }}"
                    class="inline-flex items-center px-4 py-2.5 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition-colors shadow-sm">
                    Batal
                </a>
                <button type="submit"
                    class="inline-flex items-center px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors shadow-sm">
                    Buat Pesanan
                </button>
            </div>
        </div>
    </form>

    <div x-data="{ previewUrl: null }" x-show="previewUrl"
        class="fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center z-50" @click="previewUrl = null"
        x-transition>
        <img :src="previewUrl" class="max-w-full max-h-full rounded shadow-lg">
    </div>

    <script>
        function showPreview(url) {
            const previewModal = document.querySelector('[x-data="{ previewUrl: null }"]');
            Alpine.set(previewModal, 'previewUrl', url);
        }
    </script>
@endsection
