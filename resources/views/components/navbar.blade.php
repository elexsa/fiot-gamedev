<header class="relative z-50 border-b border-fiot-dark bg-fiot-black/70 backdrop-blur-md w-full shadow-lg shadow-fiot-black/50">
    <div class="container mx-auto px-4 md:px-6 py-4 flex justify-between items-center">
        <div class="flex items-center gap-3 relative z-50">
            <a href="/" class="flex items-center gap-2 group">
                <div class="text-2xl font-bold tracking-tighter text-white">FICE<span class="text-fiot-accent"></span></div>
                
                <div id="hp-heart-container" class="w-4 h-4 animate-pulse flex items-center justify-center ml-1 opacity-80 group-hover:opacity-100 transition-all duration-300" title="2/2 HP">
                    <svg viewBox="0 0 8 8" class="w-full h-full" style="shape-rendering: crispEdges;">
                        <defs>
                            <linearGradient id="hp-grad" x1="0%" y1="0%" x2="100%" y2="0%">
                                <stop offset="100%" stop-color="#ef4444" id="hp-stop-red" class="transition-all duration-300" />
                                <stop offset="100%" stop-color="#333333" id="hp-stop-empty" class="transition-all duration-300" />
                            </linearGradient>
                        </defs>
                        <path fill="url(#hp-grad)" d="M1,2 L2,2 L2,1 L3,1 L3,2 L5,2 L5,1 L6,1 L6,2 L7,2 L7,4 L6,4 L6,5 L5,5 L5,6 L4,6 L4,7 L3,7 L3,6 L2,6 L2,5 L1,5 L1,4 L0,4 L0,2 L1,2 Z" />
                    </svg>
                </div>
            </a>
            <div class="hidden sm:block text-[9px] md:text-[10px] uppercase tracking-widest text-fiot-gray leading-tight border-l border-fiot-dark pl-3">
                Educational<br>Program 2026
            </div>
        </div>
        
        <nav class="hidden lg:flex items-center gap-8">
            <a href="/" class="text-xs uppercase tracking-widest font-bold {{ request()->is('/') ? 'text-fiot-accent' : 'hover:text-white transition' }}">Головна</a>
            <a href="/disciplines" class="text-xs uppercase tracking-widest font-bold {{ request()->is('disciplines') ? 'text-fiot-accent' : 'hover:text-white transition' }}">Дисципліни</a>
            <a href="/admission" class="text-xs uppercase tracking-widest font-bold {{ request()->is('admission') ? 'text-fiot-accent' : 'hover:text-white transition' }}">Вступникам</a>
            <a href="{{ route('partners') }}" class="text-xs uppercase tracking-widest font-bold {{ request()->is('partners') ? 'text-fiot-accent drop-shadow-[0_0_8px_rgba(18,230,49,0.8)]' : 'text-gray-300 hover:text-white transition' }}">Партнери</a>
        </nav>

        <button id="mobile-menu-btn" class="lg:hidden relative z-50 p-2 text-fiot-gray hover:text-white transition focus:outline-none cursor-pointer">
            <svg id="menu-icon" class="w-6 h-6 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
            <svg id="close-icon" class="w-6 h-6 hidden transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
    </div>
</header>

<div id="mobile-menu" class="fixed inset-0 bg-[#0b0c0f]/95 backdrop-blur-2xl z-40 hidden flex-col justify-center items-center gap-8 opacity-0 transition-opacity duration-300">
    <a href="/" class="text-xl uppercase tracking-widest font-bold {{ request()->is('/') ? 'text-fiot-accent' : 'hover:text-white transition' }}">Головна</a>
    <a href="/disciplines" class="text-xl uppercase tracking-widest font-bold {{ request()->is('disciplines') ? 'text-fiot-accent' : 'hover:text-white transition' }}">Дисципліни</a>
    <a href="/admission" class="text-xl uppercase tracking-widest font-bold {{ request()->is('admission') ? 'text-fiot-accent' : 'hover:text-white transition' }}">Вступникам</a>
    <a href="{{ route('partners') }}" class="text-xl uppercase tracking-widest font-bold {{ request()->is('partners') ? 'text-fiot-accent' : 'hover:text-white transition' }}">Партнери</a>
</div>
