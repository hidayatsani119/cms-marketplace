@extends('layouts.app')

@section('title', ($post->meta_title ?? $post->title) . ' - ScanCare Blog')
@section('description', $post->meta_description ?? $post->excerpt ?? Str::limit(strip_tags($post->content), 160))

@section('content')
<article class="bg-white">
    <!-- Back Link -->
    <div class="container mx-auto px-6 py-6">
        <a href="{{ route('blog.index') }}" class="inline-flex items-center gap-2 text-sm text-[#004d2c] hover:underline">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Back to Blog
        </a>
    </div>

    <!-- Article Content -->
    <div class="container mx-auto px-6 pb-16">
        <div class="max-w-2xl mx-auto">
            <!-- Header -->
            <header class="mb-8">
                <h1 class="text-2xl md:text-3xl font-semibold text-neutral-900 mb-4">{{ $post->title }}</h1>
                <div class="flex items-center gap-3 text-sm text-neutral-500">
                    @if($post->published_at)
                    <time datetime="{{ $post->published_at->toISOString() }}">
                        {{ $post->published_at->format('F d, Y') }}
                    </time>
                    @endif
                    @if($post->user)
                        <span>•</span>
                        <span>{{ $post->user->name }}</span>
                    @endif
                </div>
            </header>

            <!-- Featured Image -->
            @if($post->featured_image_url)
            <div class="mb-8">
                <img src="{{ $post->featured_image_url }}" alt="{{ $post->title }}" 
                     class="w-full aspect-video object-cover">
            </div>
            @endif

            <!-- Content -->
            <div class="prose prose-neutral max-w-none prose-p:text-neutral-700 prose-headings:text-neutral-900 prose-a:text-[#004d2c] prose-strong:text-neutral-900">
                {!! $post->content !!}
            </div>

            <!-- Previous / Next Navigation -->
            @if($previousPost || $nextPost)
            <nav class="mt-12 pt-8 border-t border-[#e5dfd2]">
                <div class="flex justify-between items-start gap-4">
                    <!-- Previous -->
                    <div class="flex-1">
                        @if($previousPost)
                        <a href="{{ route('blog.show', $previousPost->slug) }}" class="group block">
                            <span class="text-xs text-neutral-400 uppercase tracking-wider">← Previous Article</span>
                            <p class="text-sm font-medium text-neutral-900 group-hover:text-[#004d2c] transition-colors mt-1 line-clamp-2">
                                {{ $previousPost->title }}
                            </p>
                        </a>
                        @endif
                    </div>
                    
                    <!-- Next -->
                    <div class="flex-1 text-right">
                        @if($nextPost)
                        <a href="{{ route('blog.show', $nextPost->slug) }}" class="group block">
                            <span class="text-xs text-neutral-400 uppercase tracking-wider">Next Article →</span>
                            <p class="text-sm font-medium text-neutral-900 group-hover:text-[#004d2c] transition-colors mt-1 line-clamp-2">
                                {{ $nextPost->title }}
                            </p>
                        </a>
                        @endif
                    </div>
                </div>
            </nav>
            @endif
        </div>
    </div>
</article>

<!-- Related Posts -->
@if($relatedPosts->count() > 0)
<section class="py-12 bg-[#f8f6f1]">
    <div class="container mx-auto px-6">
        <h2 class="text-xl font-semibold text-neutral-900 text-center mb-8">Related Articles</h2>
        <div class="grid grid-cols-2 md:grid-cols-3 gap-4 max-w-3xl mx-auto">
            @foreach($relatedPosts as $related)
            <article class="group">
                <a href="{{ route('blog.show', $related->slug) }}" class="block">
                    <div class="aspect-square overflow-hidden mb-3">
                        @if($related->featured_image_url)
                            <img src="{{ $related->featured_image_url }}" alt="{{ $related->title }}" 
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        @else
                            <div class="w-full h-full bg-[#e5dfd2] flex items-center justify-center">
                                <svg class="w-8 h-8 text-[#d4cbb8]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                                </svg>
                            </div>
                        @endif
                    </div>
                    <h3 class="text-sm font-medium text-neutral-900 group-hover:text-[#004d2c] transition-colors line-clamp-2">
                        {{ $related->title }}
                    </h3>
                </a>
            </article>
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection
