<div class="bg-white rounded-lg overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
        <h3 class="text-lg font-medium text-gray-900">Permintaan Penarikan Saldo</h3>
        <p class="text-sm text-gray-500 mt-1">Saldo akan dikurangi setelah penarikan disetujui</p>
    </div>

    <form id="withdrawal-form" action="{{ route('withdrawals.store') }}" method="POST" class="p-6">
        @csrf

        <div class="space-y-6">
            <!-- Balance Info -->
            <div class="bg-blue-50 p-4 rounded-lg border border-blue-100">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-sm text-gray-600">Saldo Tersedia</p>
                        <p class="text-2xl font-bold text-gray-900">Rp {{ number_format(auth()->user()->balance, 0, ',', '.') }}</p>
                    </div>
                    <svg class="h-8 w-8 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>

            <!-- Amount Input -->
            <div>
                <label for="amount" class="block text-sm font-medium text-gray-700 mb-1">
                    Jumlah Penarikan <span class="text-red-500">*</span>
                </label>
                <div class="relative rounded-md shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <span class="text-gray-500">Rp</span>
                    </div>
                    <input
                        type="number"
                        name="amount"
                        id="amount"
                        min="10000"
                        max="{{ auth()->user()->balance }}"
                        class="block w-full pl-10 pr-12 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Minimal Rp 10.000"
                        required
                    >
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                        <span class="text-gray-500">,00</span>
                    </div>
                </div>
                <p class="mt-1 text-sm text-gray-500">
                    Minimal penarikan Rp 10.000
                </p>
            </div>

            <!-- Withdrawal Method -->
            <div>
                <label for="method" class="block text-sm font-medium text-gray-700 mb-1">
                    Metode Penarikan <span class="text-red-500">*</span>
                </label>
                <select
                    name="method"
                    id="method"
                    class="block w-full border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                    required
                >
                    <option value="">Pilih metode</option>
                    <option value="bank_transfer">Bank Transfer</option>
                    <option value="e_wallet">E-Wallet</option>
                    <option value="cash">Tunai</option>
                </select>
            </div>

            <!-- Account Details -->
            <div id="account-details" class="hidden">
                <label for="account_details" class="block text-sm font-medium text-gray-700 mb-1">
                    Detail Rekening/Nomor E-Wallet <span class="text-red-500">*</span>
                </label>
                <textarea
                    name="account_details"
                    id="account_details"
                    rows="3"
                    class="block w-full border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Contoh: BCA - 1234567890 - John Doe"
                ></textarea>
            </div>

            <!-- Notes (Optional) -->
            <div>
                <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">
                    Catatan (Opsional)
                </label>
                <textarea
                    name="notes"
                    id="notes"
                    rows="2"
                    class="block w-full border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Contoh: Untuk kebutuhan operasional"
                ></textarea>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="mt-6 flex justify-end space-x-3">
            <button
                type="button"
                onclick="closeModal()"
                class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
            >
                Batal
            </button>
            <button
                type="submit"
                class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
            >
                <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Ajukan Penarikan
            </button>
        </div>
    </form>

    <script>
        // Show account details when method is not cash
        document.getElementById('method').addEventListener('change', function() {
            const accountDetails = document.getElementById('account-details');
            accountDetails.classList.toggle('hidden', this.value === 'cash');

            if (this.value !== 'cash') {
                document.getElementById('account_details').required = true;
            } else {
                document.getElementById('account_details').required = false;
            }
        });

        // Form validation
        document.getElementById('withdrawal-form').addEventListener('submit', function(e) {
            const balance = {{ auth()->user()->balance }};
            const amount = parseFloat(document.getElementById('amount').value);
            const method = document.getElementById('method').value;
            const accountDetails = document.getElementById('account_details');

            if (amount > balance) {
                e.preventDefault();
                alert('Jumlah penarikan melebihi saldo tersedia!');
                return;
            }

            if (method !== 'cash' && !accountDetails.value.trim()) {
                e.preventDefault();
                alert('Detail rekening/nomor e-wallet harus diisi!');
                return;
            }
        });
    </script>
</div>
