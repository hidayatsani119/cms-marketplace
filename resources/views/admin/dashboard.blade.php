@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
    <div class="mb-8">
        <p class="text-neutral-600">Welcome back! Here's an overview of your marketplace.</p>
    </div>
    
    <!-- Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        @foreach([
            ['label' => 'Total Products', 'value' => $stats['total_products'], 'color' => '#004d2c'],
            ['label' => 'Active Products', 'value' => $stats['active_products'], 'color' => '#004d2c'],
            ['label' => 'QR Codes', 'value' => $stats['total_qr_codes'], 'color' => '#004d2c'],
            ['label' => 'Total Users', 'value' => $stats['total_users'], 'color' => '#004d2c']
        ] as $stat)
        <div class="bg-white p-6">
            <div class="text-xs font-medium text-neutral-500 uppercase tracking-widest mb-3">{{ $stat['label'] }}</div>
            <div class="text-3xl font-semibold" style="color: {{ $stat['color'] }};">{{ number_format($stat['value']) }}</div>
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
                    <tr class="text-left text-xs font-medium text-neutral-500 uppercase tracking-widest border-b border-[#f0ece3]">
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
