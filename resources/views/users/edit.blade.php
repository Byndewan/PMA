@extends('layouts.app')

@section('page-title', 'Edit User: ' . $user->name)

@section('content')
<div class="max-w-3xl mx-auto">
    <form action="{{ route('users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <!-- Card Header -->
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex items-center">
                <div class="flex-shrink-0 h-10 w-10 rounded-full bg-gradient-to-br from-blue-100 to-blue-50 flex items-center justify-center text-blue-600 mr-3">
                    <span class="font-medium">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                </div>
                <h3 class="text-lg font-medium text-gray-900">Edit User</h3>
            </div>

            <!-- Card Body -->
            <div class="p-6 space-y-6">
                <!-- Basic Information -->
                <div class="space-y-4">
                    <h4 class="font-medium text-gray-700 border-b pb-2">Informasi Dasar</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap*</label>
                            <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required
                                class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                        </div>
                        <div>
                            <label for="role" class="block text-sm font-medium text-gray-700 mb-1">Role*</label>
                            <select id="role" name="role" required
                                class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                                <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="operator" {{ old('role', $user->role) == 'operator' ? 'selected' : '' }}>Operator</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Account Information -->
                <div class="space-y-4">
                    <h4 class="font-medium text-gray-700 border-b pb-2">Informasi Akun</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email*</label>
                            <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required
                                class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                        </div>
                        <div>
                            <label for="username" class="block text-sm font-medium text-gray-700 mb-1">Username*</label>
                            <input type="text" id="username" name="username" value="{{ old('username', $user->username) }}" required
                                class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                        </div>
                    </div>
                </div>

                <!-- Password (Optional) -->
                <div class="space-y-4">
                    <h4 class="font-medium text-gray-700 border-b pb-2">Password</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password Baru (Opsional)</label>
                            <div class="relative">
                                <input type="password" id="password" name="password" minlength="8"
                                    class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                                    placeholder="Kosongkan jika tidak diubah">
                                <button type="button" class="absolute right-3 top-3 text-gray-400 hover:text-gray-600" onclick="togglePassword('password')">
                                    <i class="far fa-eye"></i>
                                </button>
                            </div>
                        </div>
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password</label>
                            <div class="relative">
                                <input type="password" id="password_confirmation" name="password_confirmation"
                                    class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                                <button type="button" class="absolute right-3 top-3 text-gray-400 hover:text-gray-600" onclick="togglePassword('password_confirmation')">
                                    <i class="far fa-eye"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Balance (Only for operators) -->
                <div x-data="{ role: '{{ $user->role }}' }" x-effect="role = document.getElementById('role').value">
                    <div x-show="role === 'operator'" class="space-y-4">
                        <h4 class="font-medium text-gray-700 border-b pb-2">Saldo Operator</h4>
                        <div>
                            <label for="balance" class="block text-sm font-medium text-gray-700 mb-1">Saldo</label>
                            <div class="relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500">Rp</span>
                                </div>
                                <input type="number" id="balance" name="balance" min="0" value="{{ old('balance', $user->balance) }}"
                                    class="block w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card Footer -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end gap-3">
                <a href="{{ route('users.index') }}" class="btn-secondary flex items-center gap-2">
                    <i class="fas fa-times"></i>
                    <span>Batal</span>
                </a>
                <button type="submit" class="btn-primary flex items-center gap-2">
                    <i class="fas fa-save"></i>
                    <span>Update User</span>
                </button>
            </div>
        </div>
    </form>
</div>

<script>
    function togglePassword(id) {
        const input = document.getElementById(id);
        const icon = input.nextElementSibling.querySelector('i');
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.replace('fa-eye', 'fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.replace('fa-eye-slash', 'fa-eye');
        }
    }
</script>
@endsection
