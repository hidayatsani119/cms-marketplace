<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'CMS Marketplace') | Quality Products</title>
    <meta name="description" content="@yield('description', 'Shop authentic quality products')">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="antialiased min-h-screen" style="background-color: #f8f6f1;">
    @include('components.landing.header')
    
    <main>
        @yield('content')
    </main>
    
    @include('components.landing.footer')
    
    @stack('scripts')
</body>
</html>
