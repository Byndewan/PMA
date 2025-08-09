@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="max-w-md mx-auto bg-white p-8 rounded-lg shadow-md mt-10">
    <h1 class="text-2xl font-bold mb-6 text-center text-gray-800">Login</h1>

    @if($errors->any())
        <div class="mb-4 p-3 bg-red-50 text-red-700 rounded">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form action="{{ route('login') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label class="block text-gray-700 mb-2 font-medium">Email/Username</label>
            <input type="text" name="login" required
                   class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                   value="{{ old('login') }}">
        </div>

        <div class="mb-4 relative">
            <label class="block text-gray-700 mb-2 font-medium">Password</label>
            <input type="password" name="password" required
                   class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                   id="password-field">
            <button type="button" class="absolute right-3 top-9 text-gray-500 hover:text-gray-700"
                    onclick="togglePassword()">
                <i class="far fa-eye"></i>
            </button>
        </div>

        <div class="mb-6 flex items-center">
            <input type="checkbox" name="remember" id="remember" class="mr-2">
            <label for="remember" class="text-gray-700">Remember me</label>
        </div>

        <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition duration-200">
            Login
        </button>

        <div class="mt-4 text-center">
            <a href="{{ route('qr.login') }}" class="text-blue-600 hover:underline">Login with QR Code</a>
        </div>
    </form>
</div>

<script>
    function togglePassword() {
        const passwordField = document.getElementById('password-field');
        const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordField.setAttribute('type', type);
    }
</script>
@endsection
