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
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($posts as $post)
                <article class="group bg-white border border-[#e5dfd2] hover: transition-colors duration-300">
                    <a href="{{ route('blog.show', $post->slug) }}" class="block">
                        <!-- Image -->
                        <div class="aspect-[16/9] overflow-hidden bg-[#f0ece3] relative">
                            @if($post->featured_image_url)
                                <img src="{{ $post->featured_image_url }}" alt="{{ $post->title }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                            @else
                                <div class="absolute inset-0 flex items-center justify-center text-[#004d2c]/20">
                                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            @endif
                        </div>
                        
                        <!-- Content -->
                        <div class="p-6">
                            <div class="flex items-center gap-3 text-xs text-neutral-500 mb-3">
                                <span class="text-[#004d2c] font-medium">{{ $post->published_at ? $post->published_at->format('M d, Y') : $post->created_at->format('M d, Y') }}</span>
                                @if($post->user)
                                    <span>•</span>
                                    <span>{{ $post->user->name }}</span>
                                @endif
                            </div>
                            
                            <h3 class="text-lg font-semibold text-neutral-900 mb-3 line-clamp-2 group-hover:text-[#004d2c] transition-colors">
                                {{ $post->title }}
                            </h3>
                            
                            <p class="text-neutral-600 text-sm line-clamp-3 mb-4">
                                {{ $post->excerpt ?? Str::limit(strip_tags($post->content), 100) }}
                            </p>
                            
                            <div class="inline-flex items-center text-xs font-bold uppercase tracking-widest text-[#004d2c] group-hover:underline">
                                Read More
                                <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                </svg>
                            </div>
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
