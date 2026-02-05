@extends('layouts.app')

@section('title', 'ScanCare | Authentic Products')
@section('description', 'Discover and verify authentic products with ScanCare')

@section('content')
<!-- Hero Slider -->
<section class="relative h-[70vh] min-h-[500px] overflow-hidden">
    <div id="hero-slider" class="relative h-full">
        <!-- Slides -->
        <div class="slides">
            <div class="slide absolute inset-0 opacity-100 transition-opacity duration-700">
                <div class="absolute inset-0"></div>
                <img src="https://images.unsplash.com/photo-1598919727365-3fcc3706b5de?w=900&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1yZWxhdGVkfDF8fHxlbnwwfHx8fHw%3D" alt="Skincare" class="w-full h-full object-cover">
                <div class="absolute inset-0 flex items-center">
                    <div class="container mx-auto px-6">
                        <div class="max-w-xl text-white">
                            <p class="text-xs uppercase tracking-[0.3em] text-white/70 mb-4">Premium Collection</p>
                            <h1 class="text-4xl md:text-5xl lg:text-6xl font-semibold mb-6">Quality Products<br>You Can Trust</h1>
                            <p class="text-lg text-white/80 mb-10">Discover our curated selection of authentic, verified products</p>
                            <a href="#catalog" class="btn-white">Shop Now</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="slide absolute inset-0 opacity-0 transition-opacity duration-700">
                <div class="absolute inset-0"></div>
                <img src="https://images.unsplash.com/photo-1651740895757-b014896022a9?q=80&w=2961&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="Beauty Products" class="w-full h-full object-cover">
                <div class="absolute inset-0 flex items-center">
                    <div class="container mx-auto px-6">
                        <div class="max-w-xl text-white">
                            <p class="text-xs uppercase tracking-[0.3em] text-white/70 mb-4">Verified Authentic</p>
                            <h1 class="text-4xl md:text-5xl lg:text-6xl font-semibold mb-6">Scan & Verify<br>Your Products</h1>
                            <p class="text-lg text-white/80 mb-10">Use our QR scanner to confirm authenticity instantly</p>
                            <a href="{{ url('/verify') }}" class="btn-white">Verify Now</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="slide absolute inset-0 opacity-0 transition-opacity duration-700">
                <div class="absolute inset-0"></div>
                <img src="https://images.unsplash.com/photo-1742799272845-7a27b54a1048?q=80&w=2340&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="Cosmetics" class="w-full h-full object-cover">
                <div class="absolute inset-0 flex items-center">
                    <div class="container mx-auto px-6">
                        <div class="max-w-xl text-white">
                            <p class="text-xs uppercase tracking-[0.3em] text-white/70 mb-4">New Arrivals</p>
                            <h1 class="text-4xl md:text-5xl lg:text-6xl font-semibold mb-6">Latest Beauty<br>Essentials</h1>
                            <p class="text-lg text-white/80 mb-10">Explore our newest collection of premium beauty products</p>
                            <a href="{{ url('/products') }}" class="btn-white">Explore</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Slider Controls -->
        <div class="absolute bottom-8 left-1/2 -translate-x-1/2 flex gap-3">
            <button class="slider-dot w-3 h-3 rounded-full bg-white/50 hover:bg-white transition-colors" data-slide="0"></button>
            <button class="slider-dot w-3 h-3 rounded-full bg-white/50 hover:bg-white transition-colors" data-slide="1"></button>
            <button class="slider-dot w-3 h-3 rounded-full bg-white/50 hover:bg-white transition-colors" data-slide="2"></button>
        </div>

        <!-- Arrow Controls -->
        <button id="prev-slide" class="absolute left-4 top-1/2 -translate-y-1/2 w-12 h-12 flex items-center justify-center bg-white/20 hover:bg-white/30 text-white transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
        </button>
        <button id="next-slide" class="absolute right-4 top-1/2 -translate-y-1/2 w-12 h-12 flex items-center justify-center bg-white/20 hover:bg-white/30 text-white transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </button>
    </div>
</section>

<!-- Product Catalog -->
<section id="catalog" class="py-20" style="background-color: #f8f6f1;">
    <div class="container mx-auto px-6">
        <div class="text-center mb-14">
            <p class="text-xs uppercase tracking-[0.3em] text-[#004d2c] mb-3">Our Collection</p>
            <h2 class="text-3xl md:text-4xl font-semibold text-neutral-900">Shop All Products</h2>
        </div>

        <div id="products-grid" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            <div class="col-span-full flex justify-center py-16">
                <div class="w-8 h-8 border-2 border-[#004d2c] border-t-transparent rounded-full animate-spin"></div>
            </div>
        </div>

        <div class="text-center mt-14">
            <a href="{{ url('/products') }}" class="btn-secondary">View All Products</a>
        </div>
    </div>
</section>

<!-- Why Choose Us -->
<section class="py-20 bg-white">
    <div class="container mx-auto px-6">
        <div class="text-center mb-14">
            <p class="text-xs uppercase tracking-[0.3em] text-[#004d2c] mb-3">Why Choose Us</p>
            <h2 class="text-3xl md:text-4xl font-semibold text-neutral-900">Our Commitment</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
            @foreach([
                ['icon' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4', 'title' => 'Quality Products', 'desc' => 'Carefully curated selection of premium products from trusted sources'],
                ['icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z', 'title' => 'Verified Authentic', 'desc' => 'Every product comes with authentication verification via QR code'],
                ['icon' => 'M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z', 'title' => 'Best Value', 'desc' => 'Competitive prices without compromising on quality standards']
            ] as $feature)
            <div class="text-center">
                <div class="w-16 h-16 mx-auto mb-6 bg-[#f8f6f1] flex items-center justify-center">
                    <svg class="w-7 h-7 text-[#004d2c]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $feature['icon'] }}" />
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-neutral-900 mb-3">{{ $feature['title'] }}</h3>
                <p class="text-sm text-neutral-500 leading-relaxed">{{ $feature['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Featured Banner -->
<section class="py-20" style="background-color: #f0ece3;">
    <div class="container mx-auto px-6 text-center">
        <p class="text-xs uppercase tracking-[0.3em] text-[#004d2c] mb-4">New Arrivals</p>
        <h2 class="text-3xl md:text-4xl font-semibold text-neutral-900 mb-6">Explore Our Latest Collection</h2>
        <p class="text-neutral-600 mb-10 max-w-lg mx-auto">Discover the newest additions to our carefully curated product range</p>
        <a href="{{ url('/products') }}" class="btn-primary">Shop New Arrivals</a>
    </div>
</section>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Hero Slider
    const slides = document.querySelectorAll('.slide');
    const dots = document.querySelectorAll('.slider-dot');
    const prevBtn = document.getElementById('prev-slide');
    const nextBtn = document.getElementById('next-slide');
    let currentSlide = 0;
    let slideInterval;

    function showSlide(index) {
        slides.forEach((slide, i) => {
            slide.style.opacity = i === index ? '1' : '0';
        });
        dots.forEach((dot, i) => {
            dot.classList.toggle('bg-white', i === index);
            dot.classList.toggle('bg-white/50', i !== index);
        });
        currentSlide = index;
    }

    function nextSlide() {
        showSlide((currentSlide + 1) % slides.length);
    }

    function prevSlide() {
        showSlide((currentSlide - 1 + slides.length) % slides.length);
    }

    function startAutoSlide() {
        slideInterval = setInterval(nextSlide, 5000);
    }

    function resetAutoSlide() {
        clearInterval(slideInterval);
        startAutoSlide();
    }

    dots.forEach((dot, i) => {
        dot.addEventListener('click', () => {
            showSlide(i);
            resetAutoSlide();
        });
    });

    prevBtn.addEventListener('click', () => {
        prevSlide();
        resetAutoSlide();
    });

    nextBtn.addEventListener('click', () => {
        nextSlide();
        resetAutoSlide();
    });

    showSlide(0);
    startAutoSlide();

    // Products Grid
    const grid = document.getElementById('products-grid');

    fetch('/api/products')
        .then(res => res.json())
        .then(data => {
            const products = data.data?.slice(0, 8) || [];

            if (products.length === 0) {
                grid.innerHTML = '<div class="col-span-full text-center py-16"><p class="text-neutral-400">No products available</p></div>';
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
        })
        .catch(() => {
            grid.innerHTML = '<div class="col-span-full text-center py-16"><p class="text-red-500">Failed to load products</p></div>';
        });
});
</script>
@endpush
