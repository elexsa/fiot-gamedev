<footer class="relative z-10 py-10 md:py-12 border-t border-fiot-dark bg-fiot-black/80 backdrop-blur-md">
    <div class="container mx-auto px-6">
        <div class="flex flex-col md:flex-row justify-between items-center gap-6 md:gap-8">
            
            <div class="text-center md:text-left">
                <div class="text-2xl font-bold tracking-tighter mb-1 text-white">FICE<span class="text-fiot-primary">_</span></div>
                <p class="text-fiot-gray text-[10px] uppercase tracking-widest">Програма розробки ігор</p>
            </div>
            
            <div class="flex gap-4">
                <a href="#" class="w-10 h-10 rounded-full border border-fiot-dark flex items-center justify-center text-fiot-gray hover:border-fiot-primary hover:text-fiot-primary hover:bg-fiot-primary/10 transition duration-300 group">
                    <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm5.891 8.146l-1.603 7.554c-.116.519-.424.646-.859.402l-2.438-1.797-1.176 1.132c-.13.13-.239.239-.49.239l.175-2.482 4.517-4.082c.197-.175-.043-.272-.304-.098l-5.584 3.517-2.406-.753c-.523-.164-.533-.523.11-.774l9.395-3.621c.435-.164.815.097.673.725z"/></svg>
                </a>
                <a href="#" class="w-10 h-10 rounded-full border border-fiot-dark flex items-center justify-center text-fiot-gray hover:border-fiot-primary hover:text-fiot-primary hover:bg-fiot-primary/10 transition duration-300 group">
                    <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                </a>
            </div>

            <div class="flex items-end gap-3">
                <p class="text-fiot-gray text-[9px] uppercase tracking-widest pb-2">&copy; 2026 КПІ ім. Ігоря Сікорського</p>
                <div class="w-12 h-12 flex items-end justify-center pointer-events-none group">
                    <img src="{{ asset('images/dota_flies.gif') }}" 
                        id="footer-boss"
                        alt="Idle Hero" 
                        class="h-full w-auto drop-shadow-[0_0_8px_rgba(18,230,49,0.3)] group-hover:drop-shadow-[0_0_15px_rgba(239,68,68,0.8)] transition-all duration-100 cursor-crosshair pointer-events-auto active:scale-95" 
                        style="image-rendering: pixelated;">
                </div>
            </div>
            
        </div>
    </div>
</footer>