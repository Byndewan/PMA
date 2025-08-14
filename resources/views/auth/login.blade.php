@extends('layouts.app')

@section('title', 'Login')

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
            <h1 class="text-2xl font-semibold text-gray-800">Selamat Datang</h1>
            <p class="text-gray-500 text-sm">Masuk menggunakan akun Anda untuk melanjutkan pemesanan atau mengecek detail dan riwayat</p>
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

        <div class="relative">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-gray-200"></div>
            </div>
            <div class="relative flex justify-center text-sm">
                <span class="px-2 bg-white text-gray-500">Belum punya akun?</span>
            </div>
        </div>

        <div class="space-y-3">
            <a href="{{ route('login.google') }}" class="w-full flex items-center justify-center gap-2 py-2.5 px-4 border border-gray-200 rounded-xl text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition">
                <img src="https://www.google.com/favicon.ico" alt="Google" class="w-4 h-4">
                Daftar/Masuk dengan Google
            </a>
            {{-- {{ route('login.facebook') }} --}}
            {{-- <a href="" class="w-full flex items-center justify-center gap-2 py-2.5 px-4 border border-gray-200 rounded-xl text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition">
                <img src="https://www.facebook.com/favicon.ico" alt="Facebook" class="w-4 h-4">
                Masuk dengan Facebook
            </a> --}}
        </div>

        <div class="relative">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-gray-200"></div>
            </div>
        </div>

        <form action="{{ route('login') }}" method="POST" class="space-y-4 mt-10">
            @csrf
            <div class="space-y-1.5">
                <label class="block text-sm font-medium text-gray-700">Email</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                        <i class="fas fa-user"></i>
                    </div>
                    <input type="text" name="login" required
                           class="block w-full pl-10 pr-3 py-2.5 border border-gray-200 rounded-xl placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 transition text-sm"
                           placeholder="Masukan Email Anda Disini . . ."
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
