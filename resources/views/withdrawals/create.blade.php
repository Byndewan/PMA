@extends('layouts.app')

@section('page-title', 'Ajukan Withdrawal Baru')

@section('content')
<div class="space-y-6">
    <!-- Withdrawal Form -->
    <div class="bg-white rounded-xl shadow-sm p-6">
        <h3 class="text-xl font-semibold mb-6 text-gray-900 border-b pb-2">Form Withdrawal</h3>

        <form action="{{ route('withdrawals.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Operator Info -->
                <div class="col-span-1">
                    <label class="block mb-2 text-sm font-medium text-gray-700">Operator</label>
                    <div class="flex items-center p-3 border border-gray-300 rounded-lg bg-gray-50">
                        <div class="flex-shrink-0 h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                            <span class="text-blue-600 text-lg font-medium">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </span>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-900">{{ auth()->user()->name }}</p>
                            <p class="text-sm text-gray-500">{{ ucfirst(auth()->user()->role) }}</p>
                        </div>
                    </div>
                </div>

                <!-- Balance Info -->
                <div class="col-span-1">
                    <label class="block mb-2 text-sm font-medium text-gray-700">Saldo Tersedia</label>
                    <div class="p-3 border border-gray-300 rounded-lg bg-gray-50">
                        <p class="text-2xl font-bold text-gray-900">Rp {{ number_format(auth()->user()->balance) }}</p>
                    </div>
                </div>

                <!-- Amount Input -->
                <div class="col-span-1 md:col-span-2">
                    <label for="amount" class="block mb-2 text-sm font-medium text-gray-700">Jumlah Withdrawal</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500">Rp</span>
                        </div>
                        <input type="number" id="amount" name="amount" required min="10000" max="{{ auth()->user()->balance }}"
                            class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                            placeholder="Masukkan jumlah withdrawal">
                    </div>
                    <p class="mt-1 text-xs text-gray-500">Minimum withdrawal Rp 10.000</p>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="mt-8 flex justify-end space-x-3">
                <a href="{{ route('withdrawals.index') }}" class="btn-secondary flex items-center">
                    <i class="fas fa-times mr-2"></i> Batal
                </a>
                <button type="submit" class="btn-primary flex items-center">
                    <i class="fas fa-paper-plane mr-2"></i> Ajukan Withdrawal
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
