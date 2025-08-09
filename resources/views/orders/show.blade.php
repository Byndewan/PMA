<div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
        <div>
            <h3 class="text-lg font-medium text-gray-900">Detail Pesanan #{{ $order->id }}</h3>
            <p class="text-sm text-gray-500 mt-1">{{ $order->created_at->translatedFormat('l, d F Y H:i') }}</p>
        </div>
        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium @if($order->status === 'done') bg-green-100 text-green-800 @elseif($order->status === 'process') bg-yellow-100 text-yellow-800 @else bg-blue-100 text-blue-800 @endif">
            {{ ucfirst($order->status) }}
        </span>
    </div>

    <div class="p-6 space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Order Information -->
            <div class="bg-gray-50 p-4 rounded-lg">
                <h4 class="font-medium text-gray-700 border-b border-gray-200 pb-2 mb-3">Informasi Pesanan</h4>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Pelanggan:</span>
                        <span class="font-medium">{{ $order->customer_name }}</span>
                    </div>
                    @if($order->customer_phone)
                    <div class="flex justify-between">
                        <span class="text-gray-600">Nomor HP:</span>
                        <span class="font-medium">{{ $order->customer_phone }}</span>
                    </div>
                    @endif
                    <div class="flex justify-between">
                        <span class="text-gray-600">Total:</span>
                        <span class="font-medium">Rp {{ number_format($order->total_price) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Fee Operator:</span>
                        <span class="font-medium">Rp {{ number_format($order->operator_fee_total) }}</span>
                    </div>
                    @if($order->notes)
                    <div>
                        <p class="text-gray-600 mb-1">Catatan:</p>
                        <p class="text-gray-800 bg-white p-2 rounded border border-gray-200">{{ $order->notes }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Order Items -->
            <div>
                <h4 class="font-medium text-gray-700 border-b border-gray-200 pb-2 mb-3">Item Pesanan</h4>
                <div class="space-y-3">
                    @foreach($order->items as $item)
                    <div class="border border-gray-200 rounded-lg p-3 hover:bg-gray-50">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="font-medium">{{ $item->product->name }}</p>
                                <p class="text-sm text-gray-600">Jumlah: {{ $item->quantity }} x Rp {{ number_format($item->price_per_unit) }}</p>
                                <p class="text-sm text-gray-600">Fee: Rp {{ number_format($item->operator_fee) }}</p>
                            </div>
                            @if($item->file_path)
                            <a href="{{ asset('storage/'.$item->file_path) }}" target="_blank"
                               class="text-blue-600 hover:text-blue-800 text-sm flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"></path>
                                </svg>
                                File
                            </a>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        @if(auth()->user()->isOperator() && $order->status != 'taken')
        <div class="pt-4 border-t border-gray-200">
            <form action="{{ route('orders.update-status', $order->id) }}" method="POST">
                @csrf
                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3">
                    <div class="w-full sm:w-auto">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Update Status</label>
                        <select name="status" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            <option value="process" {{ $order->status == 'process' ? 'selected' : '' }}>Diproses</option>
                            <option value="done" {{ $order->status == 'done' ? 'selected' : '' }}>Selesai</option>
                            <option value="taken" {{ $order->status == 'taken' ? 'selected' : '' }}>Diambil</option>
                        </select>
                    </div>
                    <button type="submit" class="mt-2 sm:mt-6 px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        Update Status
                    </button>
                </div>
            </form>
        </div>
        @endif
    </div>
</div>
