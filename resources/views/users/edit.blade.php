<div class="bg-white rounded-lg overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
        <div class="flex justify-between items-center">
            <div>
                <h3 class="text-lg font-medium text-gray-900">Edit User</h3>
                <p class="text-sm text-gray-500 mt-1">ID: {{ $user->id }}</p>
            </div>
            @if(auth()->user()->isAdmin() && auth()->user()->id !== $user->id)
            <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-600 hover:text-red-900 text-sm font-medium">
                    Hapus User
                </button>
            </form>
            @endif
        </div>
    </div>

    @include('users._form', [
        'action' => route('users.update', $user->id),
        'method' => 'PUT',
        'user' => $user
    ])
</div>
