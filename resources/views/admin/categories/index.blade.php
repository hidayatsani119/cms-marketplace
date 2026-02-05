@extends('layouts.admin')

@section('title', 'Categories')
@section('page-title', 'Categories')
@section('page-description', 'Manage product categories')

@section('content')
    <div class="mb-6 flex justify-end">
        <a href="{{ route('admin.categories.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-[#004d2c] text-white text-sm hover:bg-[#003d23] transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Add Category
        </a>
    </div>
    
    <div class="bg-white">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="text-left text-xs font-medium text-white uppercase tracking-widest border-b border-[#003d23] bg-[#004d2c]">
                        <th class="px-6 py-4 rounded-tl-lg">Name</th>
                        <th class="px-6 py-4">Description</th>
                        <th class="px-6 py-4 text-center">Products</th>
                        <th class="px-6 py-4 text-right rounded-tr-lg">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                        <tr class="border-b border-[#f0ece3] hover:bg-[#fdfcfa] transition-colors">
                            <td class="px-6 py-4">
                                <span class="font-medium text-neutral-900">{{ $category->name }}</span>
                            </td>
                        <td class="px-6 py-4">
                            <span class="text-sm text-neutral-500">{{ Str::limit($category->description, 50) ?: '-' }}</span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="inline-flex items-center px-2.5 py-0.5 text-xs font-medium bg-[#e8f5e9] text-[#004d2c]">
                                {{ $category->products_count }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.categories.edit', $category) }}" class="text-sm text-[#004d2c] hover:underline">Edit</a>
                                @if($category->products_count === 0)
                                    <form id="delete-category-{{ $category->id }}" action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" onclick="confirmDelete('delete-category-{{ $category->id }}', 'this category')" class="text-sm text-red-500 hover:underline">Delete</button>
                                    </form>
                                @else
                                    <span class="text-sm text-neutral-300 cursor-not-allowed" title="Has products">Delete</span>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-neutral-400">No categories yet</td>
                    </tr>
                @endforelse
            </tbody>
            </table>
        </div>
    </div>
@endsection
