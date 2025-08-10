@extends('layouts.app')

@section('page-title', 'Buat Pesanan Baru')

@section('content')
<form action="{{ route('orders.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="space-y-6">
        <!-- Customer Information -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="text-xl font-semibold mb-6 text-gray-900 border-b pb-2">Informasi Pelanggan</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="customer_name" class="block mb-2 text-sm font-medium text-gray-700">Nama Pelanggan</label>
                    <input type="text" id="customer_name" name="customer_name" required
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                </div>
                <div>
                    <label for="customer_phone" class="block mb-2 text-sm font-medium text-gray-700">Nomor Telepon</label>
                    <input type="text" id="customer_phone" name="customer_phone"
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                </div>
            </div>
        </div>

        <!-- Order Items -->
        <div class="bg-white rounded-xl shadow-sm p-6" x-data="{ items: [{}] }">
            <div class="flex justify-between items-center mb-6 border-b pb-2">
                <h3 class="text-xl font-semibold text-gray-900">Item Pesanan</h3>
                <button type="button" @click="items.push({})"
                    class="btn-primary flex items-center text-sm">
                    <i class="fas fa-plus-circle mr-2"></i> Tambah Item
                </button>
            </div>

            <template x-for="(item, index) in items" :key="index">
                <div class="border border-gray-200 rounded-lg p-5 mb-4 bg-gray-50">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Product Selection -->
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-700">Produk</label>
                            <select name="items[][product_id]" x-model="item.product_id" required
                                @change="calculateTotal()"
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                                <option value="">Pilih Produk</option>
                                @foreach($products as $product)
                                <option value="{{ $product->id }}" data-price="{{ $product->price }}" data-estimate="{{ $product->estimate_time }}">
                                    {{ $product->name }} (Rp {{ number_format($product->price) }})
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Quantity -->
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-700">Jumlah</label>
                            <input type="number" name="items[][quantity]" x-model="item.quantity" min="1" required
                                @input="calculateTotal()"
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                        </div>

                        <!-- File Upload -->
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-700">File Cetak</label>
                            <div class="relative">
                                <input type="file" name="items[][file]" required
                                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                                    id="file-upload-${index}">
                                <label :for="`file-upload-${index}`"
                                    class="flex items-center justify-between px-4 py-2 bg-white border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50 transition">
                                    <span class="truncate text-sm text-gray-500" x-text="item.file ? item.file.name : 'Pilih file'"></span>
                                    <i class="fas fa-cloud-upload-alt text-gray-400 ml-2"></i>
                                </label>
                            </div>
                        </div>
                    </div>

                    <button type="button" @click="items.splice(index, 1); calculateTotal();"
                        class="mt-3 text-sm text-red-600 hover:text-red-800 transition-colors flex items-center">
                        <i class="fas fa-trash-alt mr-1"></i> Hapus Item
                    </button>
                </div>
            </template>
        </div>

        <!-- Order Summary -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="text-xl font-semibold mb-6 text-gray-900 border-b pb-2">Ringkasan Pesanan</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-blue-50 p-4 rounded-lg">
                    <p class="text-sm font-medium text-gray-500 mb-1">Total Harga</p>
                    <p class="text-2xl font-bold text-gray-900" id="total-price">Rp 0</p>
                </div>
                <div class="bg-green-50 p-4 rounded-lg">
                    <p class="text-sm font-medium text-gray-500 mb-1">Total Fee Operator</p>
                    <p class="text-2xl font-bold text-gray-900" id="total-fee">Rp 0</p>
                </div>
                <div class="bg-amber-50 p-4 rounded-lg">
                    <p class="text-sm font-medium text-gray-500 mb-1">Estimasi Selesai</p>
                    <p class="text-2xl font-bold text-gray-900" id="estimate-time">-</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="mt-8 flex justify-end space-x-3">
        <a href="{{ route('orders.index') }}" class="btn-secondary flex items-center">
            <i class="fas fa-times mr-2"></i> Batal
        </a>
        <button type="submit" class="btn-primary flex items-center">
            <i class="fas fa-save mr-2"></i> Simpan Pesanan
        </button>
    </div>
</form>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('orderForm', () => ({
            calculateTotal() {
                let totalPrice = 0;
                let totalFee = 0;
                let maxEstimate = 0;

                document.querySelectorAll('[name="items[][product_id]"]').forEach((select, index) => {
                    const selectedOption = select.options[select.selectedIndex];
                    const price = selectedOption ? parseInt(selectedOption.dataset.price) : 0;
                    const quantity = parseInt(document.querySelectorAll('[name="items[][quantity]"]')[index].value) || 0;
                    const productFee = 300; // Default fee operator

                    totalPrice += price * quantity;
                    totalFee += productFee * quantity;

                    if (selectedOption) {
                        const estimate = parseInt(selectedOption.dataset.estimate);
                        if (estimate > maxEstimate) {
                            maxEstimate = estimate;
                        }
                    }
                });

                // Update display
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
