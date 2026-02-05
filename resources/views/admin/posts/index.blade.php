@extends('layouts.admin')

@section('title', 'Posts')
@section('page-title', 'Blog Posts')
@section('page-description', 'Manage your blog content')

@section('content')
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <form method="GET" class="flex items-center gap-3">
            <input type="text" name="search" value="{{ request('search') }}" 
                   placeholder="Search posts..." 
                   class="px-4 py-2 border border-[#e5dfd2] bg-white text-sm focus:outline-none focus:border-[#004d2c] w-64">
            <select name="status" class="px-4 py-2 border border-[#e5dfd2] bg-white text-sm focus:outline-none">
                <option value="">All Status</option>
                <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Published</option>
                <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
            </select>
            <button type="submit" class="px-4 py-2 bg-[#004d2c] text-white text-sm hover:bg-[#003d23] transition-colors">
                Filter
            </button>
        </form>
        <a href="{{ route('admin.posts.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-[#004d2c] text-white text-sm hover:bg-[#003d23] transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            New Post
        </a>
    </div>

    <div class="bg-white">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="text-left text-xs font-medium text-white uppercase tracking-widest border-b border-[#003d23] bg-[#004d2c]">
                        <th class="px-6 py-4 rounded-tl-lg">Title</th>
                        <th class="px-6 py-4">Author</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Published</th>
                        <th class="px-6 py-4 text-right rounded-tr-lg">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($posts as $post)
                    <tr class="border-b border-[#f0ece3] hover:bg-[#fdfcfa] transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 bg-[#f0ece3] overflow-hidden flex-shrink-0">
                                    @if($post->featured_image_url)
                                        <img src="{{ $post->featured_image_url }}" alt="" class="w-full h-full object-cover">
                                    @endif
                                </div>
                                <div>
                                    <div class="text-neutral-900 font-medium">{{ Str::limit($post->title, 40) }}</div>
                                    <div class="text-xs text-neutral-400">/blog/{{ $post->slug }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-neutral-600">{{ $post->user->name ?? 'Unknown' }}</td>
                        <td class="px-6 py-4">
                            <span class="badge {{ $post->status === 'published' ? 'badge-green' : 'badge-yellow' }}">
                                {{ ucfirst($post->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-neutral-600">
                            {{ $post->published_at?->format('M d, Y') ?? '-' }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.posts.edit', $post) }}" class="p-2 text-neutral-400 hover:text-[#004d2c] transition-colors" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>
                                <form id="delete-post-{{ $post->id }}" action="{{ route('admin.posts.destroy', $post) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" onclick="confirmDelete('delete-post-{{ $post->id }}', 'this post')" class="p-2 text-neutral-400 hover:text-red-500 transition-colors" title="Delete">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-neutral-400">No posts yet</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($posts->hasPages())
        <div class="px-6 py-4 border-t border-[#f0ece3]">
            {{ $posts->links() }}
        </div>
        @endif
    </div>
@endsection
