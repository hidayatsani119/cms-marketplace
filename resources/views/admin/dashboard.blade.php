@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-description', 'Welcome back! Here\'s an overview of your marketplace.')

@section('content')
    
    <!-- Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        @foreach([
            ['label' => 'Total Products', 'value' => $stats['total_products'], 'icon' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4'],
            ['label' => 'Active Products', 'value' => $stats['active_products'], 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
            ['label' => 'QR Codes', 'value' => $stats['total_qr_codes'], 'icon' => 'M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z'],
            ['label' => 'Total Posts', 'value' => $stats['total_posts'], 'icon' => 'M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z'],
            ['label' => 'Published Posts', 'value' => $stats['published_posts'], 'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4'],
            ['label' => 'Total Users', 'value' => $stats['total_users'], 'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z'],
        ] as $stat)
        <div class="bg-white p-6 flex items-start gap-4">
            <div class="w-12 h-12 bg-[#e8f5e9] flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6 text-[#004d2c]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $stat['icon'] }}" />
                </svg>
            </div>
            <div>
                <div class="text-xs font-medium text-neutral-500 uppercase tracking-widest mb-1">{{ $stat['label'] }}</div>
                <div class="text-2xl font-semibold text-[#004d2c]">{{ number_format($stat['value']) }}</div>
            </div>
        </div>
        @endforeach
    </div>
    
    <!-- Recent Products -->
    <div class="bg-white">
        <div class="flex items-center justify-between p-6 border-b border-[#e5dfd2]">
            <h2 class="text-lg font-semibold text-neutral-900">Recent Products</h2>
            <a href="{{ route('admin.products.index') }}" class="text-sm text-[#004d2c] hover:underline">View All →</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="text-left text-xs font-medium text-white uppercase tracking-widest border-b border-[#003d23] bg-[#004d2c]">
                        <th class="px-6 py-4">Product</th>
                        <th class="px-6 py-4">Price</th>
                        <th class="px-6 py-4">Stock</th>
                        <th class="px-6 py-4">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentProducts as $product)
                    <tr class="border-b border-[#f0ece3] hover:bg-[#fdfcfa] transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-[#f0ece3] overflow-hidden">
                                    @if($product->image_url)
                                        <img src="{{ $product->image_url }}" alt="" class="w-full h-full object-cover">
                                    @endif
                                </div>
                                <span class="text-neutral-900 font-medium">{{ Str::limit($product->name, 30) }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-neutral-600">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 text-neutral-600">{{ $product->quantity }}</td>
                        <td class="px-6 py-4">
                            <span class="badge {{ $product->status === 'active' ? 'badge-green' : 'badge-red' }}">
                                {{ ucfirst($product->status) }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-8 text-center text-neutral-400">No products yet</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
