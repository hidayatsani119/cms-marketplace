<header class="fixed top-0 left-0 right-0 z-50 bg-[#f8f6f1] border-b border-[#e5dfd2]">
    <nav class="container mx-auto px-6">
        <div class="flex items-center justify-between h-16">
            <!-- Logo -->
            <a href="{{ url('/') }}" class="text-xl font-bold text-[#004d2c] tracking-tight">
                ScanCare
            </a>

            <!-- Desktop Navigation -->
            <div class="hidden md:flex items-center gap-8">
                <a href="{{ url('/') }}" class="text-xs font-medium text-neutral-700 hover:text-[#004d2c] transition-colors tracking-wider {{ request()->is('/') ? 'text-[#004d2c] uppercase' : '' }}">Home</a>
                <a href="{{ url('/products') }}" class="text-xs font-medium text-neutral-700 hover:text-[#004d2c] transition-colors tracking-wider {{ request()->is('products*') ? 'text-[#004d2c] uppercase' : '' }}">Shop</a>
                <a href="{{ url('/verify') }}" class="text-xs font-medium text-neutral-700 hover:text-[#004d2c] transition-colors tracking-wider {{ request()->is('verify*') ? 'text-[#004d2c] uppercase' : '' }}">Verify</a>
            </div>

            <!-- Mobile Menu Button -->
            <button id="mobile-menu-btn" class="md:hidden p-2 text-neutral-700" onclick="document.getElementById('mobile-menu').classList.toggle('hidden')">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>

        <!-- Mobile Navigation -->
        <div id="mobile-menu" class="hidden md:hidden py-4 border-t border-[#e5dfd2]">
            <div class="flex flex-col gap-1">
                <a href="{{ url('/') }}" class="px-4 py-3 text-xs font-medium text-neutral-700 hover:text-[#004d2c] hover:bg-[#f0ece3] tracking-wider uppercase">Home</a>
                <a href="{{ url('/products') }}" class="px-4 py-3 text-xs font-medium text-neutral-700 hover:text-[#004d2c] hover:bg-[#f0ece3] tracking-wider uppercase">Shop</a>
                <a href="{{ url('/verify') }}" class="px-4 py-3 text-xs font-medium text-neutral-700 hover:text-[#004d2c] hover:bg-[#f0ece3] tracking-wider uppercase">Verify</a>
            </div>
        </div>
    </nav>
</header>
<div class="h-16"></div>
