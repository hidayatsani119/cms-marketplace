<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') | Admin Panel</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="antialiased min-h-screen bg-[#f8f6f1]">
    <div class="flex min-h-screen relative">
        <!-- Mobile Backdrop -->
        <div id="sidebar-backdrop" onclick="toggleSidebar()" class="fixed inset-0 bg-black/50 z-30 lg:hidden hidden transition-opacity"></div>

        @include('components.admin.sidebar')
        
        <div class="flex-1 flex flex-col lg:ml-16">
            <!-- Mobile Header -->
            <header class="lg:hidden bg-white border-b border-[#e5dfd2] px-4 py-3 flex items-center justify-between sticky top-0 z-20">
                <button onclick="toggleSidebar()" class="p-2 text-neutral-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                <span class="font-bold text-[#004d2c]">ScanCare</span>
                <div class="w-10"></div>
            </header>
            
            <main class="flex-1 p-6 lg:pt-1">
                <!-- Page Header -->
                <div class="flex flex-col items-center justify-between mb-8 pb-3 border-b border-[#e5dfd2]">
                    <h1 class="text-xl font-bold text-[#003d23]">@yield('page-title', 'Dashboard')</h1>
                    @hasSection('page-description')
                        <span class="text-sm text-neutral-400">@yield('page-description')</span>
                    @endif
                </div>
                
                @yield('content')
            </main>
        </div>
    </div>
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const SwalTheme = Swal.mixin({
            customClass: {
                confirmButton: 'swal-confirm-btn',
                cancelButton: 'swal-cancel-btn',
                popup: 'swal-popup'
            },
            buttonsStyling: false
        });

        @if(session('success'))
            SwalTheme.fire({
                icon: 'success',
                title: 'Success!',
                text: '{{ session('success') }}',
                confirmButtonText: 'OK',
                timer: 3000,
                timerProgressBar: true
            });
        @endif

        @if(session('error'))
            SwalTheme.fire({
                icon: 'error',
                title: 'Error',
                text: '{{ session('error') }}',
                confirmButtonText: 'OK'
            });
        @endif

        function confirmDelete(formId, itemName = 'this item') {
            SwalTheme.fire({
                title: 'Delete ' + itemName + '?',
                text: 'This action cannot be undone.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it',
                cancelButtonText: 'Cancel',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(formId).submit();
                }
            });
        }

        function confirmLogout() {
            SwalTheme.fire({
                title: 'Logout?',
                text: 'Are you sure you want to logout?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, logout',
                cancelButtonText: 'Cancel',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('logout-form').submit();
                }
            });
        }

        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const backdrop = document.getElementById('sidebar-backdrop');
            
            if (sidebar.classList.contains('-translate-x-full')) {
                // Open sidebar
                sidebar.classList.remove('-translate-x-full');
                backdrop.classList.remove('hidden');
            } else {
                // Close sidebar
                sidebar.classList.add('-translate-x-full');
                backdrop.classList.add('hidden');
            }
        }
    </script>
    <style>
        .swal-popup { border-radius: 0 !important; }
        .swal-confirm-btn {
            background-color: #004d2c !important;
            color: white !important;
            padding: 12px 24px !important;
            font-size: 14px !important;
            border: none !important;
            cursor: pointer !important;
            margin: 4px !important;
        }
        .swal-confirm-btn:hover { background-color: #003d23 !important; }
        .swal-cancel-btn {
            background-color: #f8f6f1 !important;
            color: #525252 !important;
            padding: 12px 24px !important;
            font-size: 14px !important;
            border: 1px solid #e5dfd2 !important;
            cursor: pointer !important;
            margin: 4px !important;
        }
        .swal-cancel-btn:hover { background-color: #e5dfd2 !important; }
    </style>
    
    @stack('scripts')
</body>
</html>
