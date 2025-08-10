@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="max-w-md w-full mx-auto bg-white rounded-xl shadow-md overflow-hidden p-8 space-y-6 transition-all duration-300 hover:shadow-lg">
    <div class="text-center">
        <div class="mx-auto h-16 w-16 bg-blue-100 rounded-full flex items-center justify-center mb-4">
            <i class="fas fa-lock text-blue-600 text-2xl"></i>
        </div>
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Welcome back</h1>
        <p class="text-gray-500">Sign in to your account</p>
    </div>

    @if($errors->any())
        <div class="p-4 bg-red-50 rounded-lg border border-red-200 text-red-600 flex items-start">
            <i class="fas fa-exclamation-circle mt-1 mr-3"></i>
            <div>
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        </div>
    @endif

    <form action="{{ route('login') }}" method="POST" class="space-y-5">
        @csrf
        <div class="space-y-2">
            <label class="block text-sm font-medium text-gray-700">Email or Username</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-user text-gray-400"></i>
                </div>
                <input type="text" name="login" required
                       class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150"
                       placeholder="your@email.com"
                       value="{{ old('login') }}">
            </div>
        </div>

        <div class="space-y-2">
            <label class="block text-sm font-medium text-gray-700">Password</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-lock text-gray-400"></i>
                </div>
                <input type="password" name="password" required
                       class="block w-full pl-10 pr-10 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150"
                       placeholder="••••••••"
                       id="password-field">
                <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 transition"
                        onclick="togglePassword()">
                    <i class="far fa-eye" id="toggle-icon"></i>
                </button>
            </div>
        </div>

        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <input type="checkbox" name="remember" id="remember" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                <label for="remember" class="ml-2 block text-sm text-gray-700">Remember me</label>
            </div>
            <a href="#" class="text-sm text-blue-600 hover:text-blue-500 hover:underline">Forgot password?</a>
        </div>

        <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150">
            Sign in
        </button>
    </form>

    <div class="relative">
        <div class="absolute inset-0 flex items-center">
            <div class="w-full border-t border-gray-300"></div>
        </div>
        <div class="relative flex justify-center text-sm">
            <span class="px-2 bg-white text-gray-500">Or continue with</span>
        </div>
    </div>

    <div class="flex justify-center">
        <a href="{{ route('qr.login') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150">
            <i class="fas fa-qrcode mr-2 text-blue-500"></i> QR Code Login
        </a>
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
