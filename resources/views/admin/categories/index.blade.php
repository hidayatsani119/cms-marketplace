@extends('layouts.admin')

@section('title', 'Categories')
@section('page-title', 'Categories')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <p class="text-sm text-neutral-500">Manage product categories</p>
        <a href="{{ route('admin.categories.create') }}" class="btn-primary">Add Category</a>
    </div>
    
    <div class="bg-white overflow-hidden">
        <table class="w-full">
            <thead class="bg-[#f8f6f1] border-b border-[#e5dfd2]">
                <tr>
                    <th class="text-left px-6 py-4 text-xs font-medium text-neutral-500 uppercase tracking-wider">Name</th>
                    <th class="text-left px-6 py-4 text-xs font-medium text-neutral-500 uppercase tracking-wider">Description</th>
                    <th class="text-center px-6 py-4 text-xs font-medium text-neutral-500 uppercase tracking-wider">Products</th>
                    <th class="text-right px-6 py-4 text-xs font-medium text-neutral-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[#e5dfd2]">
                @forelse($categories as $category)
                    <tr class="hover:bg-[#faf9f6]">
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
                                    <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline" onsubmit="return confirm('Delete this category?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-sm text-red-500 hover:underline">Delete</button>
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
@endsection
