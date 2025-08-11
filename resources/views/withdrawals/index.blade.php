@extends('layouts.app')

@section('page-title', 'Manajemen Withdrawal')

@section('content')
<div class="space-y-4">
    <!-- Header and Actions -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-semibold text-gray-800">Manajemen Withdrawal</h1>
            <p class="text-sm text-gray-500">Kelola semua permintaan withdrawal</p>
        </div>
        @if(auth()->user()->isOperator())
        <a href="{{ route('withdrawals.create') }}" style="text-decoration: none;!important" class="inline-flex items-center px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors shadow-sm">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Ajukan Withdrawal
        </a>
        @endif
    </div>

    <!-- Search and Filter -->
    <div class="bg-white rounded-lg border border-gray-100 p-4 shadow-xs">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-3">
            <div class="md:col-span-8">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input type="text" placeholder="Cari withdrawal..." id="search-input"
                        class="block w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                </div>
            </div>
            <div class="md:col-span-4">
                <select id="status-filter" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                    <option value="">Semua Status</option>
                    <option value="pending">Pending</option>
                    <option value="approved">Approved</option>
                    <option value="rejected">Rejected</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Withdrawals Table -->
    <div class="bg-white rounded-lg border border-gray-100 overflow-hidden shadow-xs">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Operator</th>
                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th scope="col" class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($withdrawals as $withdrawal)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-800">#{{ $withdrawal->id }}</td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 mr-3">
                                    <span class="text-xs font-medium">{{ strtoupper(substr($withdrawal->user->name, 0, 1)) }}</span>
                                </div>
                                <div class="text-sm text-gray-800">{{ $withdrawal->user->name }}</div>
                            </div>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm font-semibold text-gray-800">Rp {{ number_format($withdrawal->amount) }}</td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            @include('partials.status-badge', ['status' => $withdrawal->status])
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                            {{ $withdrawal->created_at->format('d M Y H:i') }}
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-right text-sm font-medium space-x-1">
                            @if(auth()->user()->isAdmin() && $withdrawal->status === 'pending')
                            <form action="{{ route('withdrawals.approve', $withdrawal->id) }}" method="POST" class="inline">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="inline-flex items-center p-1.5 text-gray-500 hover:text-green-600 transition-colors rounded-lg hover:bg-green-50" title="Approve">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </button>
                            </form>
                            @endif

                            @if(auth()->user()->isOperator() && $withdrawal->status === 'pending')
                            <form action="{{ route('withdrawals.destroy', $withdrawal->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center p-1.5 text-gray-500 hover:text-red-600 transition-colors rounded-lg hover:bg-red-50" title="Batalkan" onclick="return confirm('Batalkan withdrawal ini?')">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="px-4 py-3 bg-white rounded-lg border border-gray-100 shadow-xs">
        {{ $withdrawals->links() }}
    </div>
</div>

<script>
    // Status filter
    document.getElementById('status-filter').addEventListener('change', function(e) {
        const status = e.target.value;
        window.location.href = "{{ route('withdrawals.index') }}?status=" + status;
    });

    // Live search
    const searchInput = document.getElementById('search-input');
    let searchTimer;

    searchInput.addEventListener('input', function(e) {
        clearTimeout(searchTimer);
        searchTimer = setTimeout(() => {
            const query = e.target.value;
            // Implement AJAX search here
        }, 500);
    });
</script>
@endsection
