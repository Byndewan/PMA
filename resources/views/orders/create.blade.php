@extends('layouts.app')

@section('page-title', 'Buat Pesanan Baru')

@section('content')
<form action="{{ route('orders.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="space-y-6">
        <!-- Informasi Pelanggan -->
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-lg font-medium mb-4">Informasi Pelanggan</h3>
            <div>
                <label for="customer_name" class="block mb-2 text-sm font-medium text-gray-700">Nama Pelanggan</label>
                <input type="text" id="customer_name" name="customer_name" required
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
        </div>

        <!-- Daftar Produk -->
        <div class="bg-white p-6 rounded-lg shadow" x-data="{ items: [{}] }">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-medium">Item Pesanan</h3>
                <button type="button" @click="items.push({})" class="btn-primary text-sm">
                    + Tambah Item
                </button>
            </div>

            <template x-for="(item, index) in items" :key="index">
                <div class="border border-gray-200 rounded-lg p-4 mb-4">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Pilih Produk -->
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-700">Produk</label>
                            <select name="items[][product_id]" x-model="item.product_id" required
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Pilih Produk</option>
                                @foreach($products as $product)
                                <option value="{{ $product->id }}" data-price="{{ $product->price }}">
                                    {{ $product->name }} (Rp {{ number_format($product->price) }})
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Jumlah -->
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-700">Jumlah</label>
                            <input type="number" name="items[][quantity]" x-model="item.quantity" min="1" required
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <!-- File -->
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-700">File Cetak</label>
                            <input type="file" name="items[][file]" required
                                class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        </div>
                    </div>

                    <button type="button" @click="items.splice(index, 1)"
                        class="mt-2 text-red-600 text-sm flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                        Hapus Item
                    </button>
                </div>
            </template>
        </div>

        <!-- Ringkasan -->
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-lg font-medium mb-4">Ringkasan Pesanan</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-700">Total Harga</label>
                    <div class="text-xl font-semibold" id="total-price">Rp 0</div>
                </div>
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-700">Total Fee Operator</label>
                    <div class="text-xl font-semibold" id="total-fee">Rp 0</div>
                </div>
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-700">Estimasi Selesai</label>
                    <div class="text-xl font-semibold" id="estimate-time">-</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tombol Aksi -->
    <div class="mt-6 flex justify-end space-x-3">
        <a href="{{ route('orders.index') }}" class="btn-secondary">
            Batal
        </a>
        <button type="submit" class="btn-primary">
            Simpan Pesanan
        </button>
    </div>
</form>

<script>
    // Kalkulasi harga otomatis
    document.addEventListener('alpine:init', () => {
        Alpine.data('orderCalculator', () => ({
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

                    // Hitung estimasi waktu terpanjang
                    if (selectedOption) {
                        const product = @json($products->keyBy('id')->toArray())[selectedOption.value];
                        if (product.estimate_time > maxEstimate) {
                            maxEstimate = product.estimate_time;
                        }
                    }
                });

                // Update tampilan
                document.getElementById('total-price').textContent = 'Rp ' + totalPrice.toLocaleString();
                document.getElementById('total-fee').textContent = 'Rp ' + totalFee.toLocaleString();

                if (maxEstimate > 0) {
                    const now = new Date();
                    now.setMinutes(now.getMinutes() + maxEstimate);
                    document.getElementById('estimate-time').textContent = now.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
                } else {
                    document.getElementById('estimate-time').textContent = '-';
                }
            }
        }));
    });
</script>
@endsection
