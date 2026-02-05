@extends('layouts.admin')

@section('title', 'Add Product')
@section('page-title', 'Add Product')
@section('page-description', 'Create a new product')

@section('content')
    <div class="max-w-2xl">
        <div class="mb-6">
            <a href="{{ route('admin.products.index') }}" class="text-sm text-neutral-500 hover:text-[#004d2c]">← Back to Products</a>
        </div>
        
        <div class="bg-white p-6">
            <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="space-y-5">
                    <!-- Category -->
                    <div>
                        <label for="category_id" class="block text-xs font-medium text-neutral-500 uppercase tracking-widest mb-2">Category *</label>
                        <select id="category_id" name="category_id" class="w-full px-4 py-3 bg-white border border-[#e5dfd2] focus:outline-none focus:border-[#004d2c]" required>
                            <option value="">Select a category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-xs font-medium text-neutral-500 uppercase tracking-widest mb-2">Product Name</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" class="w-full px-4 py-3 bg-white border border-[#e5dfd2] focus:outline-none focus:border-[#004d2c]" required>
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-xs font-medium text-neutral-500 uppercase tracking-widest mb-2">Description</label>
                        <textarea id="description" name="description" rows="4" class="w-full px-4 py-3 bg-white border border-[#e5dfd2] focus:outline-none focus:border-[#004d2c] resize-none" required>{{ old('description') }}</textarea>
                        @error('description')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Price & Quantity -->
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="price" class="block text-xs font-medium text-neutral-500 uppercase tracking-widest mb-2">Price (Rp)</label>
                            <input type="number" id="price" name="price" value="{{ old('price') }}" min="0" class="w-full px-4 py-3 bg-white border border-[#e5dfd2] focus:outline-none focus:border-[#004d2c]" required>
                            @error('price')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="quantity" class="block text-xs font-medium text-neutral-500 uppercase tracking-widest mb-2">Quantity</label>
                            <input type="number" id="quantity" name="quantity" value="{{ old('quantity', 0) }}" min="0" class="w-full px-4 py-3 bg-white border border-[#e5dfd2] focus:outline-none focus:border-[#004d2c]" required>
                            @error('quantity')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    <!-- Status -->
                    <div>
                        <label class="block text-xs font-medium text-neutral-500 uppercase tracking-widest mb-3">Status</label>
                        <div class="flex items-center gap-6">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="status" value="active" {{ old('status', 'active') === 'active' ? 'checked' : '' }}>
                                <span class="text-sm text-neutral-600">Active</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="status" value="inactive" {{ old('status') === 'inactive' ? 'checked' : '' }}>
                                <span class="text-sm text-neutral-600">Inactive</span>
                            </label>
                        </div>
                    </div>
                    
                    <!-- Image -->
                    <div>
                        <label for="image" class="block text-xs font-medium text-neutral-500 uppercase tracking-widest mb-2">Product Image</label>
                        <input type="file" id="image" name="image" accept="image/*" class="w-full px-4 py-3 bg-[#f8f6f1] border border-[#e5dfd2] focus:outline-none focus:border-[#004d2c]">
                        @error('image')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <div class="flex gap-4 mt-8">
                    <button type="submit" class="btn-primary">Create Product</button>
                    <a href="{{ route('admin.products.index') }}" class="btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
