@extends('layouts.admin')

@section('title', 'Profile')
@section('page-title', 'Profile')
@section('page-description', 'Manage your account settings')

@section('content')
    <div class="grid lg:grid-cols-2 gap-6">
        <!-- Profile Info -->
        <div class="bg-white p-6">
            <h2 class="text-lg font-semibold text-neutral-900 mb-6">Profile Information</h2>
            
            <form action="{{ route('admin.profile.update') }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="space-y-5">
                    <div>
                        <label for="name" class="block text-xs font-medium text-neutral-500 uppercase tracking-widest mb-2">Name</label>
                        <input type="text" id="name" name="name" value="{{ old('name', auth()->user()->name) }}" class="w-full px-4 py-3 bg-white border border-[#e5dfd2] focus:outline-none focus:border-[#004d2c]" required>
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="email" class="block text-xs font-medium text-neutral-500 uppercase tracking-widest mb-2">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email', auth()->user()->email) }}" class="w-full px-4 py-3 bg-white border border-[#e5dfd2] focus:outline-none focus:border-[#004d2c]" required>
                        @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <button type="submit" class="btn-primary mt-6">Update Profile</button>
            </form>
        </div>
        
        <!-- Change Password -->
        <div class="bg-white p-6">
            <h2 class="text-lg font-semibold text-neutral-900 mb-6">Change Password</h2>
            
            <form action="{{ route('admin.profile.password') }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="space-y-5">
                    <div>
                        <label for="current_password" class="block text-xs font-medium text-neutral-500 uppercase tracking-widest mb-2">Current Password</label>
                        <input type="password" id="current_password" name="current_password" class="w-full px-4 py-3 bg-white border border-[#e5dfd2] focus:outline-none focus:border-[#004d2c]" required>
                        @error('current_password')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="password" class="block text-xs font-medium text-neutral-500 uppercase tracking-widest mb-2">New Password</label>
                        <input type="password" id="password" name="password" class="w-full px-4 py-3 bg-white border border-[#e5dfd2] focus:outline-none focus:border-[#004d2c]" required>
                        @error('password')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="password_confirmation" class="block text-xs font-medium text-neutral-500 uppercase tracking-widest mb-2">Confirm Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" class="w-full px-4 py-3 bg-white border border-[#e5dfd2] focus:outline-none focus:border-[#004d2c]" required>
                    </div>
                </div>
                
                <button type="submit" class="btn-primary mt-6">Change Password</button>
            </form>
        </div>
    </div>
@endsection
