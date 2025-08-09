<div class="bg-white rounded-lg overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
        <h3 class="text-lg font-medium text-gray-900">Buat Pesanan Baru</h3>
    </div>

    <form id="order-form" action="{{ route('orders.store') }}" method="POST" enctype="multipart/form-data" class="p-6">
        @csrf

        <div class="space-y-6">
            <!-- Customer Info -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Pelanggan <span class="text-red-500">*</span></label>
                    <input type="text" name="customer_name" required
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                           placeholder="Nama pelanggan">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nomor HP Pelanggan</label>
                    <input type="tel" name="customer_phone"
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                           placeholder="0812-3456-7890">
                </div>
            </div>

            <!-- Order Items -->
            <div x-data="orderForm">
                <div class="flex justify-between items-center mb-2">
                    <label class="block text-sm font-medium text-gray-700">Item Pesanan <span class="text-red-500">*</span></label>
                    <button type="button" @click="items.push({ product_id: '', quantity: 1, file: null })"
                            class="text-sm text-blue-600 hover:text-blue-800 flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Tambah Item
                    </button>
                </div>

                <template x-for="(item, index) in items" :key="index">
                    <div class="border border-gray-200 rounded-lg p-4 mb-4 relative">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <!-- Product Selection -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Produk <span class="text-red-500">*</span></label>
                                <select name="items[][product_id]" x-model="item.product_id" required
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    <option value="">Pilih Produk</option>
                                    @foreach($products as $product)
                                    <option value="{{ $product->id }}" data-price="{{ $product->price }}">
                                        {{ $product->name }} (Rp {{ number_format($product->price) }})
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Quantity -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah <span class="text-red-500">*</span></label>
                                <input type="number" name="items[][quantity]" x-model="item.quantity" min="1" required
                                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            </div>

                            <!-- File Upload -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">File</label>
                                <input type="file" name="items[][file]"
                                       class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                            </div>
                        </div>

                        <button type="button" @click="items.splice(index, 1)" x-show="items.length > 1"
                                class="absolute top-2 right-2 text-gray-400 hover:text-red-500">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    </div>
                </template>
            </div>

            <!-- Notes -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Catatan</label>
                <textarea name="notes" rows="2"
                          class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                          placeholder="Catatan tambahan untuk pesanan"></textarea>
            </div>
        </div>

        <div class="mt-6 flex justify-end space-x-3">
            <button type="button" onclick="closeModal()"
                    class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Batal
            </button>
            <button type="submit"
                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                </svg>
                Simpan Pesanan
            </button>
        </div>
    </form>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('orderForm', () => ({
            items: [{ product_id: '', quantity: 1, price: 0, file: null }],
            total: 0,

            updatePrice(index, event) {
                let selected = event.target.options[event.target.selectedIndex];
                let price = selected.dataset.price || 0;
                this.items[index].price = parseInt(price);
                this.calculateTotal();
            },

            calculateTotal() {
                this.total = this.items.reduce((sum, item) => {
                    return sum + (item.price * item.quantity);
                }, 0);
            },

            addItem() {
                this.items.push({ product_id: '', quantity: 1, price: 0, file: null });
            },

            removeItem(index) {
                this.items.splice(index, 1);
                this.calculateTotal();
            }
        }));
    });
</script>
