<aside id="sidebar" class="fixed inset-y-0 left-0 z-40 w-64 lg:w-16 bg-[#f8f6f1] border-r border-[#e5dfd2] transform -translate-x-full lg:translate-x-0 transition-transform overflow-visible">
    <div class="h-full flex flex-col overflow-visible">
        <!-- Logo -->
        <div class="h-16 flex items-center justify-center lg:justify-center px-4 border-b border-[#e5dfd2]">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
                <div class="w-8 h-8 bg-[#004d2c] flex items-center justify-center flex-shrink-0">
                    <span class="text-white font-bold text-sm">S</span>
                </div>
                <span class="text-lg font-bold text-[#004d2c] lg:hidden">ScanCare</span>
            </a>
        </div>
        
        <!-- Navigation -->
        <nav class="flex-1 px-2 py-6 space-y-1 overflow-visible">
            @php
                $menuItems = [
                    ['route' => 'admin.dashboard', 'routeIs' => 'admin.dashboard', 'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6', 'label' => 'Dashboard'],
                    ['route' => 'admin.categories.index', 'routeIs' => 'admin.categories.*', 'icon' => 'M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z', 'label' => 'Categories'],
                    ['route' => 'admin.products.index', 'routeIs' => 'admin.products.*', 'icon' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4', 'label' => 'Products'],
                    ['route' => 'admin.qr-codes.index', 'routeIs' => 'admin.qr-codes.*', 'icon' => 'M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z', 'label' => 'QR Codes'],
                    ['route' => 'admin.posts.index', 'routeIs' => 'admin.posts.*', 'icon' => 'M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z', 'label' => 'Posts'],
                ];
            @endphp
            
            @foreach($menuItems as $item)
                @php $isActive = request()->routeIs($item['routeIs']); @endphp
                <a href="{{ route($item['route']) }}" class="sidebar-item group relative flex items-center justify-center lg:justify-center gap-3 px-3 py-3 text-sm font-medium transition-colors {{ $isActive ? 'bg-[#004d2c] text-white' : 'text-neutral-600 hover:bg-[#e5dfd2] hover:text-[#004d2c]' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $item['icon'] }}" />
                    </svg>
                    <span class="lg:hidden">{{ $item['label'] }}</span>
                    <div class="sidebar-tooltip {{ $isActive ? 'active-tooltip' : '' }}">{{ $item['label'] }}</div>
                </a>
            @endforeach
        </nav>
        
        <!-- Bottom Menu -->
        <div class="p-2 border-t border-[#e5dfd2] overflow-visible space-y-1">
            <!-- View Site -->
            <a href="{{ url('/') }}" target="_blank" class="sidebar-item group relative flex items-center justify-center lg:justify-center gap-3 px-3 py-3 text-sm font-medium text-neutral-600 hover:bg-[#e5dfd2] hover:text-[#004d2c] transition-colors">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                </svg>
                <span class="lg:hidden">View Site</span>
                <div class="sidebar-tooltip">View Site</div>
            </a>
            
            <!-- Profile -->
            @php $isProfileActive = request()->routeIs('admin.profile'); @endphp
            <a href="{{ route('admin.profile') }}" class="sidebar-item group relative flex items-center justify-center lg:justify-center gap-3 px-3 py-3 text-sm font-medium transition-colors {{ $isProfileActive ? 'bg-[#004d2c] text-white' : 'text-neutral-600 hover:bg-[#e5dfd2] hover:text-[#004d2c]' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                <span class="lg:hidden">Profile</span>
                <div class="sidebar-tooltip {{ $isProfileActive ? 'active-tooltip' : '' }}">Profile</div>
            </a>
            
            <!-- Logout -->
            <form id="logout-form" action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="button" onclick="confirmLogout()" class="sidebar-item group relative flex items-center justify-center lg:justify-center gap-3 px-3 py-3 text-sm font-medium w-full text-red-500 hover:bg-red-50 transition-colors">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    <span class="lg:hidden">Logout</span>
                    <div class="sidebar-tooltip">Logout</div>
                </button>
            </form>
        </div>
    </div>
</aside>

<style>
    .sidebar-tooltip {
        display: none;
        position: absolute;
        left: 100%;
        margin-left: 8px;
        padding: 8px 12px;
        background-color: #171717;
        color: white;
        font-size: 13px;
        white-space: nowrap;
        z-index: 9999;
        pointer-events: none;
    }
    
    @media (min-width: 1024px) {
        .sidebar-item:hover .sidebar-tooltip {
            display: block;
        }
    }
</style>
