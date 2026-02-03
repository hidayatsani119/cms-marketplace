<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - ScanCare Admin</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased min-h-screen flex items-center justify-center bg-[#f8f6f1]">
    <div class="w-full max-w-md px-6">
        <!-- Logo -->
        <div class="text-center mb-8">
            <h1 class="text-2xl font-bold text-[#004d2c]">ScanCare</h1>
            <p class="text-neutral-500 text-sm mt-2">Admin Panel</p>
        </div>
        
        <!-- Login Form -->
        <div class="bg-white p-8">
            @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-600 p-4 mb-6 text-sm">
                    @foreach($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif
            
            <form action="{{ route('admin.login') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label for="email" class="block text-xs font-medium text-neutral-500 uppercase tracking-widest mb-2">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" class="w-full px-4 py-3 bg-white border border-[#e5dfd2] focus:outline-none focus:border-[#004d2c]" placeholder="admin@example.com" required>
                </div>
                
                <div>
                    <label for="password" class="block text-xs font-medium text-neutral-500 uppercase tracking-widest mb-2">Password</label>
                    <input type="password" id="password" name="password" class="w-full px-4 py-3 bg-white border border-[#e5dfd2] focus:outline-none focus:border-[#004d2c]" placeholder="••••••••" required>
                </div>
                
                <button type="submit" class="btn-primary w-full">Sign In</button>
            </form>
        </div>
        
        <p class="text-center mt-6">
            <a href="{{ url('/') }}" class="text-sm text-neutral-500 hover:text-[#004d2c]">← Back to website</a>
        </p>
    </div>
</body>
</html>
