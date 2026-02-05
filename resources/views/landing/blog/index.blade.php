@extends('layouts.app')

@section('title', 'Blog - Skincare Tips & Articles')
@section('description', 'Read our latest skincare tips, guides, and product information')

@section('content')
<!-- Hero Section -->
<section class="py-12 bg-[#f8f6f1]">
    <div class="container mx-auto px-6 text-center">
        <p class="text-xs uppercase tracking-[0.3em] text-[#004d2c] mb-3">Our Blog</p>
        <h1 class="text-3xl md:text-4xl font-semibold text-neutral-900 mb-4">Skincare Tips & Articles</h1>
        <p class="text-neutral-600 max-w-lg mx-auto">Discover expert advice, product guides, and the latest trends in skincare</p>
    </div>
</section>

<!-- Blog Posts Grid -->
<section class="py-12 bg-white">
    <div class="container mx-auto px-6">
        @if($posts->count() > 0)
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                @foreach($posts as $post)
                <article class="group relative overflow-hidden cursor-pointer">
                    <a href="{{ route('blog.show', $post->slug) }}" class="block">
                        <!-- Image Container -->
                        <div class="relative aspect-square overflow-hidden">
                            @if($post->featured_image_url)
                                <img src="{{ $post->featured_image_url }}" alt="{{ $post->title }}" 
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            @else
                                <div class="w-full h-full bg-[#e5dfd2] flex items-center justify-center">
                                    <svg class="w-12 h-12 text-[#d4cbb8]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                                    </svg>
                                </div>
                            @endif
                            
                            <!-- Dark Overlay on Hover -->
                            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/40 transition-all duration-300"></div>
                            
                            <!-- Description on Hover (centered) -->
                            @if($post->excerpt)
                            <div class="absolute inset-0 flex items-center justify-center p-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                <p class="text-white text-center text-xs md:text-sm line-clamp-3">
                                    {{ $post->excerpt }}
                                </p>
                            </div>
                            @endif
                        </div>
                        
                        <!-- Title Always Visible at Bottom -->
                        <div class="p-3 bg-[#f8f6f1]">
                            <h2 class="text-sm font-medium text-neutral-900 line-clamp-2">
                                {{ $post->title }}
                            </h2>
                        </div>
                    </a>
                </article>
                @endforeach
            </div>

            @if($posts->hasPages())
            <div class="mt-12 flex justify-center">
                {{ $posts->links() }}
            </div>
            @endif
        @else
            <div class="text-center py-16">
                <svg class="w-16 h-16 mx-auto text-neutral-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                </svg>
                <h2 class="text-xl font-semibold text-neutral-900 mb-2">No articles yet</h2>
                <p class="text-neutral-500">Check back soon for skincare tips and articles!</p>
            </div>
        @endif
    </div>
</section>
@endsection
