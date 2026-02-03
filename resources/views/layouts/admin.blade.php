<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - Admin Panel</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="antialiased min-h-screen bg-[#f8f6f1]">
    <div class="flex min-h-screen">
        @include('components.admin.sidebar')
        
        <div class="flex-1 flex flex-col lg:ml-64">
            @include('components.admin.topbar')
            
            <main class="flex-1 p-6 lg:p-8">
                @if(session('success'))
                    <div class="bg-green-50 border border-green-200 text-green-700 p-4 mb-6 text-sm">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="bg-red-50 border border-red-200 text-red-600 p-4 mb-6 text-sm">
                        {{ session('error') }}
                    </div>
                @endif
                
                @yield('content')
            </main>
        </div>
    </div>
    
    @stack('scripts')
</body>
</html>
