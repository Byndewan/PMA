@extends('layouts.app')

@section('page-title', 'Manajemen Pengguna')

    @can('create', App\Models\User::class)
    <a href="{{ route('users.create') }}" class="btn-primary flex items-center gap-2">
        <i class="fas fa-user-plus"></i>
        <span>User Baru</span>
    </a>
    @endcan

@section('content')
<div class="space-y-6">
    <!-- Search and Filter Card -->
    <div class="bg-white rounded-xl shadow-sm p-4">
        <div class="flex flex-col md:flex-row md:items-center gap-4">
            <div class="flex-1 relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                    <i class="fas fa-search"></i>
                </div>
                <input
                    type="text"
                    placeholder="Cari user..."
                    class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                    id="search-input"
                >
            </div>
            <div class="w-full md:w-48">
                <select id="role-filter" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                    <option value="">Semua Role</option>
                    <option value="admin">Admin</option>
                    <option value="operator">Operator</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Users Table Card -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($users as $user)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10 rounded-full bg-gradient-to-br from-blue-100 to-blue-50 flex items-center justify-center text-blue-600 mr-3">
                                    <span class="font-medium">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                </div>
                                <div>
                                    <div class="font-medium text-gray-900">{{ $user->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 rounded-full text-xs font-medium {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900">Rp {{ number_format($user->balance) }}</div>
                            <div class="text-xs text-gray-500">{{ $user->username }}</div>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-3">
                                <a href="{{ route('users.show', $user->id) }}"
                                   class="text-blue-600 hover:text-blue-900 transition-colors p-2 rounded-full hover:bg-blue-50"
                                   title="Detail">
                                    <i class="fas fa-eye w-4 h-4"></i>
                                </a>
                                @can('update', $user)
                                <a href="{{ route('users.edit', $user->id) }}"
                                   class="text-amber-600 hover:text-amber-900 transition-colors p-2 rounded-full hover:bg-amber-50"
                                   title="Edit">
                                    <i class="fas fa-edit w-4 h-4"></i>
                                </a>
                                @endcan
                                @can('delete', $user)
                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="text-red-600 hover:text-red-900 transition-colors p-2 rounded-full hover:bg-red-50"
                                            title="Hapus"
                                            onclick="return confirm('Hapus user ini?')">
                                        <i class="fas fa-trash-alt w-4 h-4"></i>
                                    </button>
                                </form>
                                @endcan
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="px-4 py-3 bg-white rounded-xl shadow-sm">
        {{ $users->links() }}
    </div>
</div>

<script>
    // Role filter
    document.getElementById('role-filter').addEventListener('change', function(e) {
        const role = e.target.value;
        window.location.href = "{{ route('users.index') }}?role=" + role;
    });

    // Live search
    document.getElementById('search-input').addEventListener('input', debounce(function(e) {
        const query = e.target.value.toLowerCase();
        document.querySelectorAll('tbody tr').forEach(row => {
            const userName = row.querySelector('td:first-child').textContent.toLowerCase();
            const userEmail = row.querySelector('td:first-child div:nth-child(2)').textContent.toLowerCase();
            row.style.display = (userName.includes(query) || userEmail.includes(query)) ? '' : 'none';
        });
    }, 300));

    function debounce(func, wait) {
        let timeout;
        return function(...args) {
            clearTimeout(timeout);
            timeout = setTimeout(() => func.apply(this, args), wait);
        };
    }
</script>
@endsection
