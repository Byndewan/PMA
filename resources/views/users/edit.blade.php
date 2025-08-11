@extends('layouts.app')

@section('page-title', 'Edit Pengguna: ' . $user->name)

@section('content')
<form action="{{ route('users.update', $user->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="space-y-4">
        <!-- Header and Actions -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h1 class="text-2xl font-semibold text-gray-800">Edit Pengguna</h1>
                <p class="text-sm text-gray-500">Perbarui informasi pengguna</p>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('users.index') }}" style="text-decoration: none;!important" class="inline-flex items-center px-4 py-2.5 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition-colors shadow-sm">
                    Batal
                </a>
                <button type="submit" class="inline-flex items-center px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors shadow-sm">
                    Simpan Perubahan
                </button>
            </div>
        </div>

        <!-- Basic Information -->
        <div class="bg-white rounded-lg border border-gray-100 p-4 shadow-xs">
            <h3 class="text-lg font-semibold mb-4 text-gray-800">Informasi Dasar</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="name" class="block mb-1.5 text-sm font-medium text-gray-700">Nama Lengkap</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required
                        class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                </div>
                <div>
                    <label for="role" class="block mb-1.5 text-sm font-medium text-gray-700">Role</label>
                    <select id="role" name="role" required
                        class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                        <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="operator" {{ old('role', $user->role) == 'operator' ? 'selected' : '' }}>Operator</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Account Information -->
        <div class="bg-white rounded-lg border border-gray-100 p-4 shadow-xs">
            <h3 class="text-lg font-semibold mb-4 text-gray-800">Informasi Akun</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="email" class="block mb-1.5 text-sm font-medium text-gray-700">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required
                        class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                </div>
                <div>
                    <label for="username" class="block mb-1.5 text-sm font-medium text-gray-700">Username</label>
                    <input type="text" id="username" name="username" value="{{ old('username', $user->username) }}" required
                        class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                </div>
            </div>
        </div>

        <!-- Password -->
        <div class="bg-white rounded-lg border border-gray-100 p-4 shadow-xs">
            <h3 class="text-lg font-semibold mb-4 text-gray-800">Password</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="password" class="block mb-1.5 text-sm font-medium text-gray-700">Password Baru (Opsional)</label>
                    <div class="relative">
                        <input type="password" id="password" name="password" minlength="8"
                            class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                            placeholder="Kosongkan jika tidak diubah">
                        <button type="button" class="absolute right-3 top-3 text-gray-400 hover:text-gray-600" onclick="togglePassword('password')">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                        </button>
                    </div>
                </div>
                <div>
                    <label for="password_confirmation" class="block mb-1.5 text-sm font-medium text-gray-700">Konfirmasi Password</label>
                    <div class="relative">
                        <input type="password" id="password_confirmation" name="password_confirmation"
                            class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                        <button type="button" class="absolute right-3 top-3 text-gray-400 hover:text-gray-600" onclick="togglePassword('password_confirmation')">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Balance (Only for operators) -->
        <div class="bg-white rounded-lg border border-gray-100 p-4 shadow-xs" x-data="{ role: '{{ $user->role }}' }" x-effect="role = document.getElementById('role').value">
            <div x-show="role === 'operator'">
                <h3 class="text-lg font-semibold mb-4 text-gray-800">Saldo Operator</h3>
                <div>
                    <label for="balance" class="block mb-1.5 text-sm font-medium text-gray-700">Saldo</label>
                    <div class="relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500">Rp</span>
                        </div>
                        <input type="number" id="balance" name="balance" min="0" value="{{ old('balance', $user->balance) }}"
                            class="block w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    function togglePassword(id) {
        const input = document.getElementById(id);
        const icon = input.nextElementSibling.querySelector('svg');
        if (input.type === 'password') {
            input.type = 'text';
            icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>';
        } else {
            input.type = 'password';
            icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>';
        }
    }
</script>
@endsection
