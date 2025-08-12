@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="max-w-md w-full mx-auto mt-10 md:mt-30">
    <div class="bg-white rounded-2xl p-8 space-y-6">
        <div class="text-center space-y-3">
            <div class="mx-auto h-25 w-25 flex items-center justify-center mb-2">
                {{-- <i class="fas fa-lock text-blue-500 text-3xl"></i> --}}
                <img src="{{ asset('uploads/logo.png') }}" alt="logo">
            </div>
            <h1 class="text-2xl font-semibold text-gray-800">Selamat Datang</h1>
            <p class="text-gray-500 text-sm">Masukan Akun Anda Untuk Melanjutkan</p>
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

        <form action="{{ route('login') }}" method="POST" class="space-y-4">
            @csrf
            <div class="space-y-1.5">
                <label class="block text-sm font-medium text-gray-700">Email</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                        <i class="fas fa-user"></i>
                    </div>
                    <input type="text" name="login" required
                           class="block w-full pl-10 pr-3 py-2.5 border border-gray-200 rounded-xl placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 transition text-sm"
                           placeholder="john@email.com"
                           value="{{ old('login') }}">
                </div>
            </div>

            <div class="space-y-1.5">
                <label class="block text-sm font-medium text-gray-700">Kata Sandi</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                        <i class="fas fa-lock"></i>
                    </div>
                    <input type="password" name="password" required
                           class="block w-full pl-10 pr-10 py-2.5 border border-gray-200 rounded-xl placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 transition text-sm"
                           placeholder="••••••••"
                           id="password-field">
                    <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 transition"
                            onclick="togglePassword()">
                        <i class="far fa-eye" id="toggle-icon"></i>
                    </button>
                </div>
            </div>

            <button type="submit" class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-xl text-sm font-medium text-white bg-blue-500 hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition">
                Masuk
            </button>
        </form>

    </div>
</div>

<script>
    function togglePassword() {
        const passwordField = document.getElementById('password-field');
        const icon = document.getElementById('toggle-icon');
        const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';

        passwordField.setAttribute('type', type);
        icon.classList.toggle('fa-eye');
        icon.classList.toggle('fa-eye-slash');
    }
</script>
@endsection
