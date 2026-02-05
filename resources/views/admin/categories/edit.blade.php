@extends('layouts.admin')

@section('title', 'Edit Category')
@section('page-title', 'Edit Category')
@section('page-description', 'Update category details')

@section('content')
    <div class="max-w-xl">
        <div class="mb-6">
            <a href="{{ route('admin.categories.index') }}" class="text-sm text-neutral-500 hover:text-[#004d2c]">← Back to Categories</a>
        </div>
        
        <div class="bg-white p-6">
            <form action="{{ route('admin.categories.update', $category) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="space-y-5">
                    <div>
                        <label for="name" class="block text-xs font-medium text-neutral-500 uppercase tracking-widest mb-2">Category Name *</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $category->name) }}" class="w-full px-4 py-3 bg-white border border-[#e5dfd2] focus:outline-none focus:border-[#004d2c]" required>
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="description" class="block text-xs font-medium text-neutral-500 uppercase tracking-widest mb-2">Description</label>
                        <textarea id="description" name="description" rows="3" class="w-full px-4 py-3 bg-white border border-[#e5dfd2] focus:outline-none focus:border-[#004d2c] resize-none">{{ old('description', $category->description) }}</textarea>
                        @error('description')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <div class="flex gap-4 mt-8">
                    <button type="submit" class="btn-primary">Update Category</button>
                    <a href="{{ route('admin.categories.index') }}" class="btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
