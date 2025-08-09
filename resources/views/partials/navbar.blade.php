<nav class="bg-blue-600 text-white shadow-lg" aria-label="Main navigation">
    <div class="container mx-auto px-4 py-3 flex justify-between items-center">
        <a href="{{ route('dashboard') }}" class="text-xl font-bold flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
            </svg>
            Print Management
        </a>

        <div class="flex items-center space-x-4">
            @auth
                <div class="hidden sm:flex items-center space-x-2">
                    <span class="font-medium">{{ auth()->user()->name }}</span>
                    <span class="px-2 py-1 rounded-full text-xs bg-white/20">{{ ucfirst(auth()->user()->role) }}</span>
                </div>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                            class="hover:bg-white/10 px-3 py-2 rounded-md flex items-center transition-colors"
                            aria-label="Logout">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z" clip-rule="evenodd" />
                        </svg>
                        <span class="hidden sm:inline">Logout</span>
                    </button>
                </form>
            @endauth
        </div>
    </div>
</nav>
