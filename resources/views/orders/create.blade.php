@extends('layouts.app')

@section('page-title', 'Buat Pesanan Baru')

@section('content')
    <form action="{{ route('orders.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div x-data="orderForm()" class="space-y-4">
            <!-- Header -->
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-semibold text-gray-800">Buat Pesanan Baru</h1>
                    <p class="text-sm text-gray-500">Isi formulir untuk membuat pesanan baru</p>
                </div>
                <div class="flex space-x-2">
                    <a href="{{ route('orders.index') }}" style="text-decoration: none;!important"
                        class="inline-flex items-center px-4 py-2.5 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition-colors shadow-sm">
                        Batal
                    </a>
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors shadow-sm">
                        Simpan Pesanan
                    </button>
                </div>
            </div>

            <!-- Customer Information -->
            <div class="bg-white rounded-lg border border-gray-100 p-4 shadow-xs">
                <h3 class="text-lg font-semibold mb-4 text-gray-800">Informasi Pelanggan</h3>
                <div class="grid grid-cols-1 md:grid-cols-1 gap-4">
                    <div>
                        <label for="customer_phone" class="block mb-1.5 text-sm font-medium text-gray-700">Nomor
                            Telepon</label>
                        <input required type="text" id="customer_phone" name="customer_phone"
                            class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                    </div>
                </div>
            </div>

            <!-- Order Items -->
            <div class="bg-white rounded-lg border border-gray-100 p-4 shadow-xs" x-data="{ items: [{}] }">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-800">Item Pesanan</h3>
                    <button type="button" @click="items.push({})"
                        class="inline-flex items-center px-3 py-1.5 bg-white border border-gray-300 text-sm font-medium rounded-lg text-gray-700 hover:bg-gray-50 transition-colors shadow-sm">
                        Tambah Item
                    </button>
                </div>

                <template x-for="(item, index) in items" :key="index">
                    <div class="border border-gray-200 rounded-lg p-4 mb-3 bg-gray-50">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                            <!-- Product Selection -->
                            <div>
                                <label class="block mb-1.5 text-sm font-medium text-gray-700">Produk</label>
                                <select name="items[0][product_id]" x-model="item.product_id" required
                                    @change="calculateTotal()"
                                    class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                                    <option value="">Pilih Produk</option>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}" data-price="{{ $product->price }}"
                                            data-estimate="{{ $product->estimate_time }}">
                                            {{ $product->name }} (Rp {{ number_format($product->price) }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Quantity -->
                            <div>
                                <label class="block mb-1.5 text-sm font-medium text-gray-700">Jumlah</label>
                                <input required type="number" name="items[0][quantity]" x-model="item.quantity" min="1"
                                    required @input="calculateTotal()"
                                    class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                            </div>

                            <!-- File Upload -->
                            <div x-data="{ file: null, previewUrl: null, showModal: false }">
                                <label class="block mb-1.5 text-sm font-medium text-gray-700">File Cetak</label>
                                <div class="relative">
                                    <input required type="file" name="items[0][file]" accept="image/*" required
                                        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                                        @change="
                                file = $event.target.files[0];
                                if (file) {
                                    let reader = new FileReader();
                                    reader.onload = e => previewUrl = e.target.result;
                                    reader.readAsDataURL(file);
                                }
                            ">
                                    <label
                                        class="flex items-center justify-between px-4 py-2.5 bg-white border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 transition text-sm">
                                        <span class="truncate text-gray-500"
                                            x-text="file ? file.name : 'Pilih file'"></span>
                                        <svg class="w-4 h-4 ml-2 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12">
                                            </path>
                                        </svg>
                                    </label>
                                </div>

                                <!-- Thumbnail preview -->
                                <template x-if="previewUrl">
                                    <div class="mt-2">
                                        <img :src="previewUrl"
                                            class="w-20 h-20 object-cover rounded cursor-pointer border border-gray-200 hover:opacity-80"
                                            @click="showModal = true">
                                    </div>
                                </template>

                                <!-- Modal untuk preview besar -->
                                <div x-show="showModal"
                                    class="fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center z-50"
                                    @click="showModal = false" x-transition>
                                    <img :src="previewUrl" class="max-w-full max-h-full rounded shadow-lg">
                                </div>
                            </div>
                        </div>

                        <button type="button" @click="items.splice(index, 1); calculateTotal();"
                            class="mt-2 text-sm text-red-600 hover:text-red-800 transition-colors flex items-center">
                            Hapus Item
                        </button>
                    </div>
                </template>
            </div>

            <!-- Order Summary -->
            <div class="bg-white rounded-lg border border-gray-100 p-4 shadow-xs">
                <h3 class="text-lg font-semibold mb-4 text-gray-800">Ringkasan Pesanan</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-blue-50 p-4 rounded-lg">
                        <p class="text-sm font-medium text-gray-500">Total Harga</p>
                        <p class="mt-1 text-xl font-semibold text-gray-800" id="total-price">Rp 0</p>
                    </div>
                    <div class="bg-green-50 p-4 rounded-lg">
                        <p class="text-sm font-medium text-gray-500">Total Fee Operator</p>
                        <p class="mt-1 text-xl font-semibold text-gray-800" id="total-fee">Rp 0</p>
                    </div>
                    <div class="bg-amber-50 p-4 rounded-lg">
                        <p class="text-sm font-medium text-gray-500">Estimasi Selesai</p>
                        <p class="mt-1 text-xl font-semibold text-gray-800" id="estimate-time">-</p>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('orderForm', () => ({
                calculateTotal() {
                    let totalPrice = 0;
                    let totalFee = 0;
                    let maxEstimate = 0;

                    const productSelects = document.querySelectorAll('[name^="items"][name$="[product_id]"]');
                    const quantityInputs = document.querySelectorAll('[name^="items"][name$="[quantity]"]');

                    productSelects.forEach((select, index) => {
                        const selectedOption = select.options[select.selectedIndex];
                        const price = selectedOption ? parseInt(selectedOption.dataset.price) || 0 : 0;
                        const quantity = parseInt(quantityInputs[index]?.value) || 0;
                        const productFee = 300;

                        totalPrice += price * quantity;
                        totalFee += productFee * quantity;

                        if (selectedOption) {
                            const estimate = parseInt(selectedOption.dataset.estimate) || 0;
                            if (estimate > maxEstimate) {
                                maxEstimate = estimate;
                            }
                        }
                    });

                    document.getElementById('total-price').textContent = 'Rp ' + totalPrice.toLocaleString('id-ID');
                    document.getElementById('total-fee').textContent = 'Rp ' + totalFee.toLocaleString('id-ID');

                    if (maxEstimate > 0) {
                        const now = new Date();
                        now.setMinutes(now.getMinutes() + maxEstimate);
                        document.getElementById('estimate-time').textContent = now.toLocaleTimeString('id-ID', {
                            hour: '2-digit',
                            minute: '2-digit',
                            hour12: false
                        });
                    } else {
                        document.getElementById('estimate-time').textContent = '-';
                    }
                }
            }));
        });
    </script>
@endsection
