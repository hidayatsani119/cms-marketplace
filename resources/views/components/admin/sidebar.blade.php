<aside id="sidebar" class="fixed inset-y-0 left-0 z-40 w-64 bg-[#f8f6f1] border-r border-[#e5dfd2] transform -translate-x-full lg:translate-x-0 transition-transform">
    <div class="h-full flex flex-col">
        <!-- Logo -->
        <div class="h-16 flex items-center px-6 border-b border-[#e5dfd2]">
            <a href="{{ route('admin.dashboard') }}" class="text-xl font-bold text-[#004d2c]">
                ScanCare
            </a>
        </div>
        
        <!-- Navigation -->
        <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-medium transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-[#004d2c] text-white' : 'text-neutral-600 hover:bg-[#e5dfd2] hover:text-[#004d2c]' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                Dashboard
            </a>
            <a href="{{ route('admin.products.index') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-medium transition-colors {{ request()->routeIs('admin.products.*') ? 'bg-[#004d2c] text-white' : 'text-neutral-600 hover:bg-[#e5dfd2] hover:text-[#004d2c]' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                </svg>
                Products
            </a>
            <a href="{{ route('admin.qr-codes.index') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-medium transition-colors {{ request()->routeIs('admin.qr-codes.*') ? 'bg-[#004d2c] text-white' : 'text-neutral-600 hover:bg-[#e5dfd2] hover:text-[#004d2c]' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                </svg>
                QR Codes
            </a>
        </nav>
        
        <!-- User Menu -->
        <div class="p-4 border-t border-[#e5dfd2]">
            <a href="{{ route('admin.profile') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-medium transition-colors {{ request()->routeIs('admin.profile') ? 'bg-[#004d2c] text-white' : 'text-neutral-600 hover:bg-[#e5dfd2] hover:text-[#004d2c]' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                Profile
            </a>
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" class="flex items-center gap-3 px-4 py-3 text-sm font-medium w-full text-left text-red-500 hover:bg-red-50 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    Logout
                </button>
            </form>
        </div>
    </div>
</aside>
