<header class="bg-white border-b border-neutral-200 px-6 py-4">
    <div class="flex items-center justify-between">
        <!-- Page Title -->
        <h1 class="text-lg font-medium text-neutral-900" style="font-family: 'Playfair Display', serif;">@yield('page-title', 'Dashboard')</h1>
        
        <!-- Right Section -->
        <div class="flex items-center gap-6">
            <!-- View Site Link -->
            <a href="{{ url('/') }}" target="_blank" class="hidden sm:flex items-center gap-2 text-sm text-neutral-500 hover:text-neutral-900 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                </svg>
                <span>View Site</span>
            </a>
            
            <!-- User Info -->
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 bg-amber-100 flex items-center justify-center text-amber-700 font-medium text-sm">
                    {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                </div>
                <span class="hidden sm:block text-sm text-neutral-700">{{ auth()->user()->name ?? 'Admin' }}</span>
            </div>
            
            <!-- Logout -->
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" class="text-neutral-400 hover:text-red-500 transition-colors" title="Logout">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                </button>
            </form>
        </div>
    </div>
</header>
