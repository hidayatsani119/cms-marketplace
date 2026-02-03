<footer class="bg-[#004d2c] text-white py-12">
    <div class="container mx-auto px-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
            <!-- Brand -->
            <div>
                <h3 class="text-xl font-bold mb-4">ScanCare</h3>
                <p class="text-white/70 text-sm leading-relaxed">Your trusted source for authentic, verified products. Scan QR codes to ensure product authenticity.</p>
            </div>
            
            <!-- Quick Links -->
            <div>
                <h4 class="text-xs font-medium uppercase tracking-widest text-white/50 mb-4">Quick Links</h4>
                <ul class="space-y-2">
                    <li><a href="{{ url('/') }}" class="text-sm text-white/70 hover:text-white transition-colors">Home</a></li>
                    <li><a href="{{ url('/products') }}" class="text-sm text-white/70 hover:text-white transition-colors">Shop</a></li>
                    <li><a href="{{ url('/verify') }}" class="text-sm text-white/70 hover:text-white transition-colors">Verify Product</a></li>
                </ul>
            </div>
            
            <!-- Contact -->
            <div>
                <h4 class="text-xs font-medium uppercase tracking-widest text-white/50 mb-4">Contact</h4>
                <ul class="space-y-2 text-sm text-white/70">
                    <li>support@scancare.com</li>
                    <li>+62 123 456 7890</li>
                </ul>
            </div>
        </div>
        
        <div class="border-t border-white/10 mt-10 pt-6 text-center">
            <p class="text-sm text-white/50">&copy; {{ date('Y') }} ScanCare. All rights reserved.</p>
        </div>
    </div>
</footer>
