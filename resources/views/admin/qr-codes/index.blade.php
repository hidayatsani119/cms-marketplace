@extends('layouts.admin')

@section('title', 'QR Codes')
@section('page-title', 'QR Codes')

@section('content')
    <div class="mb-8">
        <p class="text-neutral-600">Manage product QR codes for authentication</p>
    </div>
    
    <div class="bg-white overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="text-left text-xs font-medium text-neutral-500 uppercase tracking-widest border-b border-[#e5dfd2]">
                        <th class="px-6 py-4">QR Code</th>
                        <th class="px-6 py-4">Product</th>
                        <th class="px-6 py-4">Token</th>
                        <th class="px-6 py-4">Created</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($qrCodes as $qr)
                    <tr class="border-b border-[#f0ece3] hover:bg-[#fdfcfa] transition-colors">
                        <td class="px-6 py-4">
                            <div class="w-16 h-16 bg-white p-1 border border-[#e5dfd2]">
                                @if($qr->qr_image_url)
                                    <img src="{{ $qr->qr_image_url }}" alt="QR Code" class="w-full h-full object-contain">
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            @if($qr->product)
                                <p class="text-neutral-900 font-medium">{{ Str::limit($qr->product->name, 30) }}</p>
                                <p class="text-neutral-400 text-sm">ID: {{ $qr->product->id }}</p>
                            @else
                                <span class="text-neutral-400">Product deleted</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <code class="text-xs text-[#004d2c] bg-[#f0ece3] px-2 py-1">{{ Str::limit($qr->qr_token, 20) }}</code>
                        </td>
                        <td class="px-6 py-4 text-neutral-600">{{ $qr->created_at->format('M d, Y') }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end gap-3">
                                @if($qr->qr_image_url)
                                <a href="{{ $qr->qr_image_url }}" download class="text-neutral-400 hover:text-[#004d2c] transition-colors" title="Download">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                    </svg>
                                </a>
                                @endif
                                <form action="{{ route('admin.qr-codes.destroy', $qr) }}" method="POST" onsubmit="return confirm('Delete this QR code?')">
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
                        <td colspan="5" class="px-6 py-12 text-center text-neutral-400">No QR codes generated yet</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($qrCodes->hasPages())
        <div class="p-4 border-t border-[#e5dfd2]">
            {{ $qrCodes->links() }}
        </div>
        @endif
    </div>
@endsection
