@props(['product'])

<div class="card overflow-hidden group">
    <!-- Product Image -->
    <div class="relative aspect-video overflow-hidden bg-dark-100">
        @if($product['image_url'])
            <img 
                src="{{ $product['image_url'] }}" 
                alt="{{ $product['name'] }}"
                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
            >
        @else
            <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-primary-500/20 to-purple-500/20">
                <svg class="w-12 h-12 text-dark-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </div>
        @endif
        
        <!-- Status Badge -->
        @if(isset($product['status']))
            <div class="absolute top-3 right-3">
                <span class="px-2 py-1 text-xs font-medium rounded-full {{ $product['status'] === 'active' ? 'bg-green-500/20 text-green-400' : 'bg-red-500/20 text-red-400' }}">
                    {{ ucfirst($product['status']) }}
                </span>
            </div>
        @endif
    </div>
    
    <!-- Product Info -->
    <div class="p-5">
        <h3 class="text-lg font-semibold text-dark-900 mb-2 line-clamp-1">{{ $product['name'] }}</h3>
        <p class="text-dark-500 text-sm mb-4 line-clamp-2">{{ $product['description'] }}</p>
        
        <div class="flex items-center justify-between">
            <span class="text-xl font-bold text-primary-600">
                Rp {{ number_format($product['price'], 0, ',', '.') }}
            </span>
            <a href="{{ url('/products/' . $product['id']) }}" class="text-primary-500 hover:text-primary-600 font-medium text-sm transition-colors">
                View Details →
            </a>
        </div>
    </div>
</div>
