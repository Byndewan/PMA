@extends('layouts.app')

@section('page-title', 'Ajukan Withdrawal Baru')

@section('content')
<form action="{{ route('withdrawals.store') }}" method="POST">
    @csrf

    <div class="space-y-4">
        <!-- Header and Actions -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h1 class="text-2xl font-semibold text-gray-800">Ajukan Withdrawal Baru</h1>
                <p class="text-sm text-gray-500">Isi formulir untuk mengajukan withdrawal</p>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('dashboard') }}" style="text-decoration: none;!important" class="inline-flex items-center px-4 py-2.5 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition-colors shadow-sm">
                    Batal
                </a>
                <button type="submit" class="inline-flex items-center px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors shadow-sm">
                    Ajukan Withdrawal
                </button>
            </div>
        </div>

        <!-- Operator Info -->
        <div class="bg-white rounded-lg border border-gray-100 p-4 shadow-xs">
            <h3 class="text-lg font-semibold mb-4 text-gray-800">Informasi Operator</h3>
            <div class="flex items-center p-3 border border-gray-200 rounded-lg bg-gray-50">
                <div class="flex-shrink-0 h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 mr-3">
                    <span class="font-medium">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                </div>
                <div>
                    <div class="font-medium text-gray-800">{{ auth()->user()->name }}</div>
                    <div class="text-sm text-gray-500">{{ ucfirst(auth()->user()->role) }}</div>
                </div>
            </div>
        </div>

        <!-- Balance Info -->
        <div class="bg-white rounded-lg border border-gray-100 p-4 shadow-xs">
            <h3 class="text-lg font-semibold mb-4 text-gray-800">Saldo Tersedia</h3>
            <div class="p-3 border border-gray-200 rounded-lg bg-gray-50">
                <p class="text-xl font-semibold text-gray-800">Rp {{ number_format($availableBalance) }}</p>
            </div>
        </div>

        <!-- Amount Input -->
        <div class="bg-white rounded-lg border border-gray-100 p-4 shadow-xs">
            <h3 class="text-lg font-semibold mb-4 text-gray-800">Jumlah Withdrawal</h3>
            <div>
                <label for="amount" class="block mb-1.5 text-sm font-medium text-gray-700">Jumlah</label>
                <div class="relative rounded-md shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <span class="text-gray-500">Rp</span>
                    </div>
                    <input type="number" id="amount" name="amount" required min="10000" max="{{ auth()->user()->balance }}"
                        class="block w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                        placeholder="Masukkan jumlah withdrawal">
                </div>
                <p class="mt-1 text-xs text-gray-500">Minimum withdrawal Rp 10.000</p>
            </div>
        </div>
    </div>
</form>
@endsection
