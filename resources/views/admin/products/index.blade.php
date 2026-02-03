@extends('layouts.admin')

@section('title', 'Products')
@section('page-title', 'Products')

@section('content')
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
        <p class="text-neutral-600">Manage your product catalog</p>
        <a href="{{ route('admin.products.create') }}" class="btn-primary inline-flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Add Product
        </a>
    </div>
    
    <!-- Filters -->
    <div class="bg-white p-5 mb-6">
        <form action="{{ route('admin.products.index') }}" method="GET">
            <div class="flex flex-col sm:flex-row gap-4 mb-4">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search products..." class="flex-1 px-4 py-3 bg-white border border-[#e5dfd2] focus:outline-none focus:border-[#004d2c]">
                <button type="submit" class="btn-primary">Search</button>
            </div>
            <div class="flex items-center gap-6">
                <span class="text-sm text-neutral-500">Status:</span>
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="radio" name="status" value="" {{ !request('status') ? 'checked' : '' }} onchange="this.form.submit()">
                    <span class="text-sm text-neutral-600">All</span>
                </label>
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="radio" name="status" value="active" {{ request('status') === 'active' ? 'checked' : '' }} onchange="this.form.submit()">
                    <span class="text-sm text-neutral-600">Active</span>
                </label>
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="radio" name="status" value="inactive" {{ request('status') === 'inactive' ? 'checked' : '' }} onchange="this.form.submit()">
                    <span class="text-sm text-neutral-600">Inactive</span>
                </label>
            </div>
        </form>
    </div>
    
    <!-- Products Table -->
    <div class="bg-white overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="text-left text-xs font-medium text-neutral-500 uppercase tracking-widest border-b border-[#e5dfd2]">
                        <th class="px-6 py-4">Product</th>
                        <th class="px-6 py-4">Price</th>
                        <th class="px-6 py-4">Stock</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">QR Code</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                    <tr class="border-b border-[#f0ece3] hover:bg-[#fdfcfa] transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 bg-[#f0ece3] flex-shrink-0 overflow-hidden">
                                    @if($product->image_url)
                                        <img src="{{ $product->image_url }}" alt="" class="w-full h-full object-cover">
                                    @endif
                                </div>
                                <div>
                                    <p class="text-neutral-900 font-medium">{{ Str::limit($product->name, 30) }}</p>
                                    <p class="text-neutral-400 text-sm">{{ Str::limit($product->description, 40) }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-neutral-600">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 text-neutral-600">{{ $product->quantity }}</td>
                        <td class="px-6 py-4">
                            <span class="badge {{ $product->status === 'active' ? 'badge-green' : 'badge-red' }}">
                                {{ ucfirst($product->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            @if($product->product_qr_code)
                                <span class="text-xs font-medium text-[#004d2c]">Generated</span>
                            @else
                                <form action="{{ route('admin.qr-codes.store', $product) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="text-xs text-neutral-500 hover:text-[#004d2c]">Generate</button>
                                </form>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end gap-3">
                                <a href="{{ route('admin.products.edit', $product) }}" class="text-neutral-400 hover:text-[#004d2c] transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>
                                <form action="{{ route('admin.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Delete this product?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-neutral-400 hover:text-red-500 transition-colors">
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
                        <td colspan="6" class="px-6 py-12 text-center text-neutral-400">No products found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($products->hasPages())
        <div class="p-4 border-t border-[#e5dfd2]">
            {{ $products->links() }}
        </div>
        @endif
    </div>
@endsection
