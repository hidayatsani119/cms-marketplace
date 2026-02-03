@props(['type' => 'info', 'message'])

@php
$classes = match($type) {
    'success' => 'bg-green-500/10 border-green-500/30 text-green-400',
    'error' => 'bg-red-500/10 border-red-500/30 text-red-400',
    'warning' => 'bg-yellow-500/10 border-yellow-500/30 text-yellow-400',
    default => 'bg-primary-500/10 border-primary-500/30 text-primary-400',
};

$icon = match($type) {
    'success' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />',
    'error' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />',
    'warning' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />',
    default => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />',
};
@endphp

<div class="flex items-start gap-3 p-4 rounded-xl border {{ $classes }} mb-4">
    <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        {!! $icon !!}
    </svg>
    <p class="text-sm">{{ $message }}</p>
</div>
