@extends('layouts.app')

@section('title', 'Verify Product')
@section('description', 'Scan QR code to verify product authenticity')

@section('content')
<section class="py-12" style="background-color: #f8f6f1;">
    <div class="container mx-auto px-6">
        <div class="max-w-xl mx-auto text-center">
            <!-- Page Header -->
            <div class="mb-8">
                <div class="w-16 h-16 mx-auto mb-6 border-1 border-[#004d2c] flex items-center justify-center">
                    <svg class="w-8 h-8 text-[#004d2c]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                </div>
                <p class="text-xs uppercase tracking-[0.3em] text-[#004d2c] mb-3">Authenticity Check</p>
                <h1 class="text-2xl md:text-3xl font-semibold text-neutral-900 mb-2">Verify Product</h1>
                <p class="text-neutral-500">Scan the QR code on your product to verify authenticity</p>
            </div>
            
            <!-- Scanner Container -->
            <div id="scanner-section" class="mb-8">
                <div id="reader" class="mx-auto mb-4" style="max-width: 400px; width: 100%;"></div>
                
                <div id="scanner-placeholder" class="aspect-square max-w-[400px] mx-auto bg-white flex flex-col items-center justify-center gap-4 mb-4">
                    <svg class="w-16 h-16 text-[#d4cbb8]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                    </svg>
                    <p class="text-neutral-400 text-sm">Click button below to start scanning</p>
                </div>
                
                <div class="flex justify-center">
                    <button id="start-scanner" class="btn-primary">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Start Camera
                    </button>
                    
                    <button id="stop-scanner" class="btn-secondary" style="display: none;">
                        Stop Camera
                    </button>
                </div>
                
                <p id="camera-error" class="text-red-500 text-sm mt-4 hidden"></p>
            </div>
            
            <!-- Divider -->
            <div class="flex items-center gap-4 max-w-[400px] mx-auto mb-8">
                <div class="flex-1 h-px bg-[#e5dfd2]"></div>
                <span class="text-xs text-neutral-400 uppercase tracking-widest">or enter manually</span>
                <div class="flex-1 h-px bg-[#e5dfd2]"></div>
            </div>
            
            <!-- Manual Input -->
            <form id="verify-form" class="max-w-[400px] mx-auto">
                <input 
                    type="text" 
                    id="qr_token" 
                    name="qr_token"
                    placeholder="Enter QR code token"
                    class="w-full px-5 py-4 bg-white border border-[#e5dfd2] text-neutral-900 placeholder-neutral-400 focus:outline-none focus:border-[#004d2c] mb-4"
                    value="{{ $token ?? '' }}"
                >
                <button type="submit" id="verify-btn" class="btn-secondary w-full">
                    Verify Manually
                </button>
            </form>
            
            <!-- Result Container -->
            <div id="result-container" class="hidden mt-8 max-w-[400px] mx-auto"></div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const startBtn = document.getElementById('start-scanner');
    const stopBtn = document.getElementById('stop-scanner');
    const placeholder = document.getElementById('scanner-placeholder');
    const readerDiv = document.getElementById('reader');
    const form = document.getElementById('verify-form');
    const result = document.getElementById('result-container');
    const tokenInput = document.getElementById('qr_token');
    const cameraError = document.getElementById('camera-error');
    
    let html5QrCode = null;
    let isScanning = false;
    
    startBtn.addEventListener('click', async function() {
        cameraError.classList.add('hidden');
        
        try {
            const devices = await Html5Qrcode.getCameras();
            
            if (devices && devices.length > 0) {
                html5QrCode = new Html5Qrcode("reader");
                
                placeholder.style.display = 'none';
                readerDiv.style.display = 'block';
                startBtn.style.display = 'none';
                stopBtn.style.display = 'inline-flex';
                
                const config = {
                    fps: 10,
                    qrbox: { width: 250, height: 250 },
                    aspectRatio: 1.0
                };
                
                await html5QrCode.start(
                    { facingMode: "environment" },
                    config,
                    (decodedText) => {
                        let token = decodedText;
                        if (decodedText.includes('/verify/')) {
                            token = decodedText.split('/verify/').pop();
                        } else if (decodedText.includes('token=')) {
                            token = decodedText.split('token=').pop();
                        }
                        
                        stopScanner();
                        tokenInput.value = token;
                        verifyToken(token);
                    },
                    () => {}
                );
                
                isScanning = true;
            } else {
                throw new Error('No cameras found');
            }
        } catch (err) {
            console.error('Camera error:', err);
            cameraError.textContent = 'Camera access denied or not available. Please check browser permissions.';
            cameraError.classList.remove('hidden');
            placeholder.style.display = 'flex';
            readerDiv.style.display = 'none';
            startBtn.style.display = 'inline-flex';
            stopBtn.style.display = 'none';
        }
    });
    
    stopBtn.addEventListener('click', stopScanner);
    
    function stopScanner() {
        if (html5QrCode && isScanning) {
            html5QrCode.stop().then(() => {
                isScanning = false;
                readerDiv.style.display = 'none';
                readerDiv.innerHTML = '';
                placeholder.style.display = 'flex';
                startBtn.style.display = 'inline-flex';
                stopBtn.style.display = 'none';
            }).catch(err => console.error(err));
        }
    }
    
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        const token = tokenInput.value.trim();
        if (token) verifyToken(token);
    });
    
    async function verifyToken(token) {
        result.innerHTML = '<div class="p-6 bg-white text-center"><div class="w-6 h-6 border-2 border-[#004d2c] border-t-transparent rounded-full animate-spin mx-auto"></div><p class="text-neutral-500 mt-3 text-sm">Verifying...</p></div>';
        result.classList.remove('hidden');
        
        try {
            const res = await fetch(`/api/qr/${token}`, { method: 'POST' });
            const data = await res.json();
            
            if (res.ok && data.data) {
                const p = data.data;
                result.innerHTML = `
                    <div class="border-1 border-[#004d2c] p-6 text-left">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-12 h-12 bg-green-100 flex items-center justify-center">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-green-700">Verified Authentic</h3>
                                <p class="text-neutral-500 text-sm">This product is genuine</p>
                            </div>
                        </div>
                        ${p.image_url ? `
                            <div class="mb-6">
                                <img src="${p.image_url}" alt="${p.name}" class="w-full aspect-square object-cover bg-[#f0ece3]">
                            </div>
                        ` : ''}
                        <div class="space-y-3 text-sm">
                            <div class="flex justify-between py-2 border-b border-[#f0ece3]">
                                <span class="text-neutral-500">Product</span>
                                <span class="text-neutral-900 font-medium">${p.name}</span>
                            </div>
                            <div class="flex justify-between py-2 border-b border-[#f0ece3]">
                                <span class="text-neutral-500">Price</span>
                                <span class="text-[#004d2c] font-semibold">Rp ${new Intl.NumberFormat('id-ID').format(p.price)}</span>
                            </div>
                            <div class="flex justify-between py-2">
                                <span class="text-neutral-500">Status</span>
                                <span class="${p.status === 'active' ? 'text-green-600' : 'text-red-500'}">${p.status === 'active' ? 'In Stock' : 'Out of Stock'}</span>
                            </div>
                        </div>
                        <a href="/products/${p.id}" class="btn-primary w-full mt-6">View Product</a>
                    </div>
                `;
            } else {
                result.innerHTML = `
                    <div class="bg-white border-2 border-red-400 p-6">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 bg-red-100 flex items-center justify-center">
                                <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </div>
                            <div class="text-left">
                                <h3 class="text-lg font-semibold text-red-600">Not Found</h3>
                                <p class="text-neutral-500 text-sm">${data.errors || 'Invalid QR code'}</p>
                            </div>
                        </div>
                    </div>
                `;
            }
        } catch (err) {
            result.innerHTML = '<div class="bg-white border-2 border-red-400 p-6 text-center"><p class="text-red-500">Verification failed. Please try again.</p></div>';
        }
    }
    
    @if(isset($token) && $token)
        verifyToken('{{ $token }}');
    @endif
});
</script>
@endpush
