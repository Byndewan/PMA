@extends('layouts.app')

@section('page-title', 'Detail User: ' . $user->name)

    <a href="{{ route('users.index') }}" class="btn-secondary flex items-center gap-2">
        <i class="fas fa-arrow-left"></i>
        <span>Kembali</span>
    </a>
    @can('update', $user)
    <a href="{{ route('users.edit', $user->id) }}" class="btn-primary flex items-center gap-2">
        <i class="fas fa-edit"></i>
        <span>Edit</span>
    </a>
    @endcan

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <!-- User Profile Card -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <!-- Card Header -->
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="flex-shrink-0 h-12 w-12 rounded-full bg-gradient-to-br from-blue-100 to-blue-50 flex items-center justify-center text-blue-600 mr-3">
                        <span class="font-medium text-xl">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                    </div>
                    <div>
                        <h3 class="text-lg font-medium text-gray-900">
                            {{ $user->name }}
                        </h3>
                        <p class="text-sm text-gray-500">
                            {{ $user->email }}
                        </p>
                    </div>
                </div>
                <span class="px-3 py-1 rounded-full text-xs font-medium {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                    {{ ucfirst($user->role) }}
                </span>
            </div>
        </div>

        <!-- Card Body -->
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Account Information -->
                <div>
                    <h4 class="font-medium text-gray-700 mb-4 pb-2 border-b">Informasi Akun</h4>
                    <dl class="space-y-4">
                        <div>
                            <dt class="text-sm text-gray-500">Username</dt>
                            <dd class="mt-1 text-sm font-medium text-gray-900">{{ $user->username }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm text-gray-500">Terdaftar Pada</dt>
                            <dd class="mt-1 text-sm font-medium text-gray-900">{{ $user->created_at->format('d M Y H:i') }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm text-gray-500">Terakhir Diupdate</dt>
                            <dd class="mt-1 text-sm font-medium text-gray-900">{{ $user->updated_at->format('d M Y H:i') }}</dd>
                        </div>
                    </dl>
                </div>

                <!-- Statistics -->
                <div>
                    <h4 class="font-medium text-gray-700 mb-4 pb-2 border-b">Statistik</h4>
                    <dl class="space-y-4">
                        @if($user->role === 'operator')
                        <div>
                            <dt class="text-sm text-gray-500">Saldo</dt>
                            <dd class="mt-1 text-lg font-semibold text-gray-900">Rp {{ number_format($user->balance) }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm text-gray-500">Total Pesanan Diproses</dt>
                            <dd class="mt-1 text-sm font-medium text-gray-900">{{ $user->orders_count ?? 0 }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm text-gray-500">Total Withdrawal</dt>
                            <dd class="mt-1 text-sm font-medium text-gray-900">{{ $user->withdrawals_count ?? 0 }}</dd>
                        </div>
                        @else
                        <div>
                            <dt class="text-sm text-gray-500">Total User Dibuat</dt>
                            <dd class="mt-1 text-sm font-medium text-gray-900">{{ $user->created_users_count ?? 0 }}</dd>
                        </div>
                        @endif
                    </dl>
                </div>
            </div>
        </div>

        <!-- Card Footer -->
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-between items-center">
            @can('delete', $user)
            <form action="{{ route('users.destroy', $user->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="text-red-600 hover:text-red-900 transition-colors flex items-center gap-2"
                        onclick="return confirm('Hapus user ini?')">
                    <i class="fas fa-trash-alt"></i>
                    <span>Hapus User</span>
                </button>
            </form>
            @endcan
            <span class="text-xs text-gray-500">ID: {{ $user->id }}</span>
        </div>
    </div>

    <!-- Withdrawal History Card (For operators) -->
    @if($user->role === 'operator')
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <!-- Card Header -->
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex items-center">
            <div class="flex-shrink-0 h-10 w-10 rounded-full bg-gradient-to-br from-blue-100 to-blue-50 flex items-center justify-center text-blue-600 mr-3">
                <i class="fas fa-wallet"></i>
            </div>
            <h4 class="font-medium text-gray-900">Riwayat Withdrawal</h4>
        </div>

        <!-- Card Body -->
        <div class="divide-y divide-gray-200">
            @forelse($user->withdrawals as $withdrawal)
            <div class="px-6 py-4 hover:bg-gray-50 transition-colors">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="font-medium">Rp {{ number_format($withdrawal->amount) }}</p>
                        <p class="text-sm text-gray-500">
                            {{ $withdrawal->created_at->format('d M Y H:i') }}
                        </p>
                    </div>
                    <span class="px-3 py-1 rounded-full text-xs font-medium {{ $withdrawal->status === 'approved' ? 'bg-green-100 text-green-800' : ($withdrawal->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                        {{ ucfirst($withdrawal->status) }}
                    </span>
                </div>
            </div>
            @empty
            <div class="px-6 py-8 text-center">
                <div class="mx-auto h-16 w-16 rounded-full bg-gray-100 flex items-center justify-center text-gray-400 mb-3">
                    <i class="fas fa-wallet text-2xl"></i>
                </div>
                <p class="text-gray-500">Belum ada riwayat withdrawal</p>
            </div>
            @endforelse
        </div>
    </div>
    @endif
</div>
@endsection
