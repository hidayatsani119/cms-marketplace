@extends('layouts.app')

@section('title', 'Products')
@section('description', 'Browse our product catalog')

@section('content')
<section class="py-12" style="background-color: #f8f6f1;">
    <div class="container mx-auto px-6">
        <!-- Page Header -->
        <div class="text-center mb-12">
            <p class="text-xs uppercase tracking-[0.3em] text-[#004d2c] mb-3">Our Collection</p>
            <h1 class="text-3xl md:text-4xl font-semibold text-neutral-900">Shop All Products</h1>
        </div>
        
        <!-- Search & Filters -->
        <div class="mb-10">
            <form id="search-form" class="max-w-2xl mx-auto">
                <div class="flex flex-col sm:flex-row gap-4">
                    <input 
                        type="text" 
                        id="search-input"
                        name="name" 
                        placeholder="Search products..." 
                        class="flex-1 px-5 py-3 bg-white border border-[#e5dfd2] text-neutral-900 placeholder-neutral-400 focus:outline-none focus:border-[#004d2c]"
                    >
                    <button type="submit" class="btn-primary">Search</button>
                </div>
                <div class="flex items-center justify-center gap-6 mt-4">
                    <span class="text-sm text-neutral-500">Sort:</span>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" name="price" value="" class="text-[#004d2c]" checked>
                        <span class="text-sm text-neutral-600">Default</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" name="price" value="lowest" class="text-[#004d2c]">
                        <span class="text-sm text-neutral-600">Price ↑</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" name="price" value="highest" class="text-[#004d2c]">
                        <span class="text-sm text-neutral-600">Price ↓</span>
                    </label>
                </div>
            </form>
        </div>
        
        <!-- Products Grid -->
        <div id="products-grid" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            <div class="col-span-full flex justify-center py-16">
                <div class="w-8 h-8 border-2 border-[#004d2c] border-t-transparent rounded-full animate-spin"></div>
            </div>
        </div>
        
        <!-- Pagination -->
        <div id="pagination" class="flex justify-center items-center gap-2 mt-10"></div>
    </div>
</section>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const grid = document.getElementById('products-grid');
    const pagination = document.getElementById('pagination');
    const form = document.getElementById('search-form');
    let currentPage = 1;
    let currentParams = {};
    
    function loadProducts(params = {}, page = 1) {
        currentParams = params;
        currentPage = page;
        
        const url = new URL('/api/products/search/', window.location.origin);
        Object.keys(params).forEach(key => {
            if (params[key]) url.searchParams.append(key, params[key]);
        });
        url.searchParams.append('page', page);
        url.searchParams.append('perPage', 12);
        
        grid.innerHTML = '<div class="col-span-full flex justify-center py-16"><div class="w-8 h-8 border-2 border-[#004d2c] border-t-transparent rounded-full animate-spin"></div></div>';
        
        fetch(url)
            .then(res => res.json())
            .then(data => {
                const products = data.data || [];
                
                if (products.length === 0) {
                    grid.innerHTML = '<div class="col-span-full text-center py-16"><p class="text-neutral-400">No products found</p></div>';
                    pagination.innerHTML = '';
                    return;
                }
                
                grid.innerHTML = products.map(p => `
                    <a href="/products/${p.id}" class="product-card group">
                        <div class="product-image aspect-square">
                            ${p.image_url 
                                ? `<img src="${p.image_url}" alt="${p.name}" class="w-full h-full object-cover">`
                                : `<div class="w-full h-full flex items-center justify-center" style="background-color: #f0ece3;">
                                    <svg class="w-10 h-10 text-[#d4cbb8]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                    </svg>
                                  </div>`
                            }
                        </div>
                        <div class="p-4 text-center">
                            <h3 class="text-sm font-medium text-neutral-900 mb-1 line-clamp-2">${p.name}</h3>
                            <p class="text-sm font-semibold text-[#004d2c]">Rp ${new Intl.NumberFormat('id-ID').format(p.price)}</p>
                        </div>
                    </a>
                `).join('');
                
                // Render pagination
                if (data.pagination && data.pagination.last_page > 1) {
                    renderPagination(data.pagination);
                } else {
                    pagination.innerHTML = '';
                }
            })
            .catch(() => {
                grid.innerHTML = '<div class="col-span-full text-center py-16"><p class="text-red-500">Failed to load products</p></div>';
                pagination.innerHTML = '';
            });
    }
    
    function renderPagination(pag) {
        const { current_page, last_page } = pag;
        let html = '';
        
        // Previous button
        html += `<button onclick="goToPage(${current_page - 1})" ${current_page === 1 ? 'disabled' : ''} class="px-4 py-2 border border-[#e5dfd2] ${current_page === 1 ? 'text-neutral-300 cursor-not-allowed' : 'text-neutral-600 hover:border-[#004d2c] hover:text-[#004d2c]'}">←</button>`;
        
        // Page numbers
        const startPage = Math.max(1, current_page - 2);
        const endPage = Math.min(last_page, current_page + 2);
        
        if (startPage > 1) {
            html += `<button onclick="goToPage(1)" class="px-4 py-2 border border-[#e5dfd2] text-neutral-600 hover:border-[#004d2c] hover:text-[#004d2c]">1</button>`;
            if (startPage > 2) html += `<span class="px-2 text-neutral-400">...</span>`;
        }
        
        for (let i = startPage; i <= endPage; i++) {
            const isActive = i === current_page;
            html += `<button onclick="goToPage(${i})" class="px-4 py-2 border ${isActive ? 'bg-[#004d2c] text-white border-[#004d2c]' : 'border-[#e5dfd2] text-neutral-600 hover:border-[#004d2c] hover:text-[#004d2c]'}">${i}</button>`;
        }
        
        if (endPage < last_page) {
            if (endPage < last_page - 1) html += `<span class="px-2 text-neutral-400">...</span>`;
            html += `<button onclick="goToPage(${last_page})" class="px-4 py-2 border border-[#e5dfd2] text-neutral-600 hover:border-[#004d2c] hover:text-[#004d2c]">${last_page}</button>`;
        }
        
        // Next button
        html += `<button onclick="goToPage(${current_page + 1})" ${current_page === last_page ? 'disabled' : ''} class="px-4 py-2 border border-[#e5dfd2] ${current_page === last_page ? 'text-neutral-300 cursor-not-allowed' : 'text-neutral-600 hover:border-[#004d2c] hover:text-[#004d2c]'}">→</button>`;
        
        pagination.innerHTML = html;
    }
    
    // Global function for pagination buttons
    window.goToPage = function(page) {
        loadProducts(currentParams, page);
        window.scrollTo({ top: 0, behavior: 'smooth' });
    };
    
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(form);
        loadProducts({ name: formData.get('name'), price: formData.get('price') }, 1);
    });
    
    form.querySelectorAll('input[type="radio"]').forEach(radio => {
        radio.addEventListener('change', function() {
            const formData = new FormData(form);
            loadProducts({ name: formData.get('name'), price: formData.get('price') }, 1);
        });
    });
    
    loadProducts();
});
</script>
@endpush
