@extends('layouts.app')

@section('title', 'Register')

@section('content')
<style>
    a {
        text-decoration: none !important;
    }
</style>

<div class="max-w-md w-full mx-auto">
    <div class="bg-white rounded-2xl p-8 space-y-6">
        <div class="text-center space-y-3">
            <div class="mx-auto h-25 w-25 flex items-center justify-center mb-2">
                <img src="{{ asset('uploads/logo.png') }}" alt="logo">
            </div>
            <h1 class="text-2xl font-semibold text-gray-800">Masukan Nomor Anda</h1>
            <p class="text-gray-500 text-sm">Gunakan nomor telepon yang terdaftar di WhatsApp</p>
        </div>

        @if($errors->any())
            <div class="p-3 bg-red-50 rounded-xl text-red-600 text-sm flex items-start gap-3">
                <i class="fas fa-exclamation-circle mt-0.5"></i>
                <div>
                    @foreach($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            </div>
        @endif

        <form action="{{ route('register') }}" method="POST" class="space-y-4">
            @csrf
            <div class="space-y-1.5">
                <label class="block text-sm font-medium text-gray-700">Nomor Telepon</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                        <i class="fas fa-phone"></i>
                    </div>
                    <input type="text" name="phone" required
                           class="block w-full pl-10 pr-3 py-2.5 border border-gray-200 rounded-xl placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 transition text-sm"
                           placeholder="081234567890"
                           value="{{ old('phone') }}">
                </div>
            </div>

            <button type="submit" class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-xl text-sm font-medium text-white bg-blue-500 hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition">
                Daftar
            </button>
        </form>
    </div>
</div>
@endsection
