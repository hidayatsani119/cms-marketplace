@extends('layouts.app')

@section('title', $product->name)

@section('content')
<section class="py-12" style="background-color: #f8f6f1;">
    <div class="container mx-auto px-6">
        <!-- Breadcrumb -->
        <nav class="mb-8">
            <ol class="flex items-center gap-2 text-sm text-neutral-500">
                <li><a href="{{ url('/') }}" class="hover:text-[#004d2c]">Home</a></li>
                <li>/</li>
                <li><a href="{{ url('/products') }}" class="hover:text-[#004d2c]">Shop</a></li>
                <li>/</li>
                <li class="text-neutral-900">{{ $product->name }}</li>
            </ol>
        </nav>
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Product Image -->
            <div class="aspect-square bg-white">
                @if($product->image_url)
                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center" style="background-color: #f0ece3;">
                        <svg class="w-20 h-20 text-[#d4cbb8]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    </div>
                @endif
            </div>
            
            <!-- Product Info -->
            <div class="py-4">
                <span class="badge {{ $product->status === 'active' ? 'badge-green' : 'badge-red' }} mb-4">
                    {{ $product->status === 'active' ? 'In Stock' : 'Out of Stock' }}
                </span>
                
                <h1 class="text-2xl lg:text-3xl font-semibold text-neutral-900 mb-4">{{ $product->name }}</h1>
                
                <div class="text-2xl font-semibold text-[#004d2c] mb-6">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                
                <div class="mb-8">
                    <h3 class="text-xs font-semibold text-neutral-500 uppercase tracking-widest mb-3">Description</h3>
                    <p class="text-neutral-600 leading-relaxed">{{ $product->description }}</p>
                </div>
                
                <div class="mb-8 pb-8 border-b border-[#e5dfd2]">
                    <h3 class="text-xs font-semibold text-neutral-500 uppercase tracking-widest mb-3">Availability</h3>
                    <p class="text-neutral-900"><span class="font-semibold">{{ $product->quantity }}</span> items in stock</p>
                </div>
                
                <a href="{{ url('/products') }}" class="btn-secondary">← Back to Shop</a>
            </div>
        </div>
    </div>
</section>
@endsection
