<div class="bg-white rounded-lg overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
        <h3 class="text-lg font-medium text-gray-900">Detail Withdraw #{{ $withdrawal->id }}</h3>
        <p class="text-sm text-gray-500 mt-1">{{ $withdrawal->created_at->translatedFormat('l, d F Y H:i') }}</p>
    </div>

    <div class="p-6 space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Withdrawal Information -->
            <div class="bg-gray-50 p-4 rounded-lg">
                <h4 class="font-medium text-gray-700 border-b border-gray-200 pb-2 mb-3">Informasi Penarikan</h4>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Operator:</span>
                        <span class="font-medium">{{ $withdrawal->user->name }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Jumlah:</span>
                        <span class="font-medium">Rp {{ number_format($withdrawal->amount) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Metode:</span>
                        <span class="font-medium">{{ $withdrawal->method ?: 'Bank Transfer' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Status:</span>
                        <span class="font-medium">
                            @include('partials.status-badge', ['status' => $withdrawal->status])
                        </span>
                    </div>
                    @if($withdrawal->processed_at)
                    <div class="flex justify-between">
                        <span class="text-gray-600">Diproses pada:</span>
                        <span class="font-medium">{{ $withdrawal->processed_at->format('d M Y H:i') }}</span>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Account Details -->
            @if($withdrawal->account_details)
            <div class="bg-gray-50 p-4 rounded-lg">
                <h4 class="font-medium text-gray-700 border-b border-gray-200 pb-2 mb-3">Detail Rekening</h4>
                <div class="whitespace-pre-line">{{ $withdrawal->account_details }}</div>
            </div>
            @endif
        </div>

        <!-- Notes -->
        @if($withdrawal->notes)
        <div class="bg-gray-50 p-4 rounded-lg">
            <h4 class="font-medium text-gray-700 border-b border-gray-200 pb-2 mb-3">Catatan</h4>
            <p>{{ $withdrawal->notes }}</p>
        </div>
        @endif

        <!-- Admin Actions -->
        @if($withdrawal->status == 'pending' && auth()->user()->isAdmin())
        <div class="pt-4 border-t border-gray-200">
            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3">
                <button onclick="processWithdrawal({{ $withdrawal->id }}, 'approve')"
                    class="w-full sm:w-auto px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                    <svg class="-ml-1 mr-2 h-5 w-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Approve
                </button>
                <button onclick="processWithdrawal({{ $withdrawal->id }}, 'reject')"
                    class="w-full sm:w-auto px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                    <svg class="-ml-1 mr-2 h-5 w-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    Reject
                </button>
            </div>
        </div>
        @endif
    </div>
</div>

<script>
function processWithdrawal(id, action) {
    const actionText = action === 'approve' ? 'approve' : 'reject';
    if(confirm(`Apakah Anda yakin ingin ${actionText} withdrawal ini?`)) {
        fetch(`/withdrawals/${id}/${action}`, {
            method: 'PUT',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                window.location.reload();
            } else {
                alert(data.message || 'Terjadi kesalahan');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan');
        });
    }
}
</script>
