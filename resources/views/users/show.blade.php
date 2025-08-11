@extends('layouts.app')

@section('page-title', 'Detail Pengguna: ' . $user->name)

@section('content')
<div class="space-y-4">
    <!-- Header and Actions -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-semibold text-gray-800">Detail Pengguna</h1>
            <p class="text-sm text-gray-500">Informasi lengkap tentang pengguna ini</p>
        </div>
        <div class="flex space-x-2">
            <a href="{{ route('users.index') }}" style="text-decoration: none;!important" class="inline-flex items-center px-4 py-2.5 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition-colors shadow-sm">
                Kembali
            </a>
            @can('update', $user)
            <a href="{{ route('users.edit', $user->id) }}" style="text-decoration: none;!important" class="inline-flex items-center px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors shadow-sm">
                Edit
            </a>
            @endcan
        </div>
    </div>

    <!-- User Profile -->
    <div class="bg-white rounded-lg border border-gray-100 p-4 shadow-xs">
        <div class="flex items-center space-x-4 mb-4">
            <div class="flex-shrink-0 h-12 w-12 rounded-full bg-gradient-to-br from-blue-100 to-blue-50 flex items-center justify-center text-blue-600">
                <span class="font-medium text-xl">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
            </div>
            <div>
                <h3 class="text-lg font-medium text-gray-800">{{ $user->name }}</h3>
                <div class="flex items-center space-x-2">
                    <span class="px-2 py-1 rounded-full text-xs font-medium {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                        {{ ucfirst($user->role) }}
                    </span>
                    <span class="text-sm text-gray-500">{{ $user->email }}</span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Account Information -->
            <div>
                <h4 class="font-medium text-gray-700 mb-3 border-b pb-2">Informasi Akun</h4>
                <dl class="space-y-3">
                    <div>
                        <dt class="text-sm text-gray-500">Username</dt>
                        <dd class="mt-1 text-sm font-medium text-gray-800">{{ $user->username }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm text-gray-500">Terdaftar Pada</dt>
                        <dd class="mt-1 text-sm font-medium text-gray-800">{{ $user->created_at->format('d M Y H:i') }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm text-gray-500">Terakhir Diupdate</dt>
                        <dd class="mt-1 text-sm font-medium text-gray-800">{{ $user->updated_at->format('d M Y H:i') }}</dd>
                    </div>
                </dl>
            </div>

            <!-- Statistics -->
            <div>
                <h4 class="font-medium text-gray-700 mb-3 border-b pb-2">Statistik</h4>
                <dl class="space-y-3">
                    @if($user->role === 'operator')
                    <div>
                        <dt class="text-sm text-gray-500">Saldo</dt>
                        <dd class="mt-1 text-lg font-semibold text-gray-800">Rp {{ number_format($user->balance) }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm text-gray-500">Total Pesanan Diproses</dt>
                        <dd class="mt-1 text-sm font-medium text-gray-800">{{ $user->orders_count ?? 0 }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm text-gray-500">Total Withdrawal</dt>
                        <dd class="mt-1 text-sm font-medium text-gray-800">{{ $user->withdrawals_count ?? 0 }}</dd>
                    </div>
                    @else
                    <div>
                        <dt class="text-sm text-gray-500">Total User Dibuat</dt>
                        <dd class="mt-1 text-sm font-medium text-gray-800">{{ $user->created_users_count ?? 0 }}</dd>
                    </div>
                    @endif
                </dl>
            </div>
        </div>
    </div>

    <!-- Withdrawal History (For operators) -->
    @if($user->role === 'operator')
    <div class="bg-white rounded-lg border border-gray-100 overflow-hidden shadow-xs">
        <div class="px-4 py-3 border-b border-gray-200 bg-gray-50">
            <h3 class="text-lg font-semibold text-gray-800">Riwayat Withdrawal</h3>
        </div>

        <div class="divide-y divide-gray-200">
            @forelse($user->withdrawals as $withdrawal)
            <div class="px-4 py-3 hover:bg-gray-50 transition-colors">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="font-medium text-gray-800">Rp {{ number_format($withdrawal->amount) }}</p>
                        <p class="text-sm text-gray-500">
                            {{ $withdrawal->created_at->format('d M Y H:i') }}
                        </p>
                    </div>
                    <span class="px-2 py-1 rounded-full text-xs font-medium {{ $withdrawal->status === 'approved' ? 'bg-green-100 text-green-800' : ($withdrawal->status === 'pending' ? 'bg-amber-100 text-amber-800' : 'bg-red-100 text-red-800') }}">
                        {{ ucfirst($withdrawal->status) }}
                    </span>
                </div>
            </div>
            @empty
            <div class="px-4 py-8 text-center">
                <div class="mx-auto h-12 w-12 rounded-full bg-gray-100 flex items-center justify-center text-gray-400 mb-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <p class="text-gray-500">Belum ada riwayat withdrawal</p>
            </div>
            @endforelse
        </div>
    </div>
    @endif

    <!-- Delete User -->
    @can('delete', $user)
    <div class="bg-white rounded-lg border border-gray-100 p-4 shadow-xs">
        <h3 class="text-lg font-semibold text-gray-800 mb-3">Hapus Pengguna</h3>
        <p class="text-sm text-gray-500 mb-3">Menghapus pengguna akan menghapus semua data terkait secara permanen.</p>
        <form action="{{ route('users.destroy', $user->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="inline-flex items-center px-4 py-2.5 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg transition-colors shadow-sm" onclick="return confirm('Hapus pengguna ini?')">
                Hapus Pengguna
            </button>
        </form>
    </div>
    @endcan
</div>
@endsection
