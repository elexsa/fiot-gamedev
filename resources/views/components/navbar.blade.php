<div x-data="{ open: false }" 
     x-init="$watch('open', value => document.body.classList.toggle('overflow-hidden', value))"
     @keydown.escape.window="open = false">
     
    <header class="relative z-50 border-b border-fiot-dark bg-fiot-black/70 backdrop-blur-md w-full shadow-lg shadow-fiot-black/50">
        <div class="container mx-auto px-4 md:px-6 py-4 flex justify-between items-center">
            
            <div class="flex items-center gap-3 relative z-50">
                <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                    <div class="text-2xl font-bold tracking-tighter text-white">GS<span class="text-fiot-accent">_</span></div>
                </a>
                <div class="hidden sm:block text-[9px] md:text-[10px] uppercase tracking-widest text-fiot-gray leading-tight border-l border-fiot-dark pl-3">
                    Кафедра ігрових<br>систем · ФІОТ
                </div>
            </div>
            
            <nav class="hidden lg:flex items-center gap-5 xl:gap-7">
                <a href="{{ route('home') }}" class="text-[11px] uppercase tracking-widest font-bold {{ request()->routeIs('home') ? 'text-fiot-accent' : 'hover:text-white transition' }}">Головна</a>
                <a href="{{ route('about') }}" class="text-[11px] uppercase tracking-widest font-bold {{ request()->routeIs('about') ? 'text-fiot-accent' : 'hover:text-white transition' }}">Про кафедру</a>
                <a href="{{ route('disciplines') }}" class="text-[11px] uppercase tracking-widest font-bold {{ request()->routeIs('disciplines') ? 'text-fiot-accent' : 'hover:text-white transition' }}">Дисципліни</a>
                <a href="{{ route('admission') }}" class="text-[11px] uppercase tracking-widest font-bold {{ request()->routeIs('admission') ? 'text-fiot-accent' : 'hover:text-white transition' }}">Вступникам</a>
                <a href="{{ route('news') }}" class="text-[11px] uppercase tracking-widest font-bold {{ request()->routeIs('news*') ? 'text-fiot-accent' : 'hover:text-white transition' }}">Новини</a>
                <a href="{{ route('partners') }}" class="text-[11px] uppercase tracking-widest font-bold {{ request()->routeIs('partners') ? 'text-fiot-accent' : 'hover:text-white transition' }}">Партнери</a>
            </nav>

            <button @click="open = !open" 
                    class="lg:hidden relative z-50 p-2 text-fiot-gray hover:text-white transition focus:outline-none cursor-pointer">

                <x-icons.menu x-show="!open" class="w-6 h-6 transition-transform" />
                <x-icons.cross x-show="open" class="w-6 h-6 transition-transform" />
                
            </button>
        </div>
    </header>

    <div x-show="open" 
         x-transition.opacity.duration.300ms
         style="display: none;"
         class="fixed inset-0 bg-[#0b0c0f]/95 backdrop-blur-2xl z-40 flex flex-col justify-center items-center gap-8">
        
        <a href="{{ route('home') }}" @click="open = false" class="text-xl uppercase tracking-widest font-bold {{ request()->routeIs('home') ? 'text-fiot-accent' : 'hover:text-white transition' }}">Головна</a>
        <a href="{{ route('about') }}" @click="open = false" class="text-xl uppercase tracking-widest font-bold {{ request()->routeIs('about') ? 'text-fiot-accent' : 'hover:text-white transition' }}">Про кафедру</a>
        <a href="{{ route('disciplines') }}" @click="open = false" class="text-xl uppercase tracking-widest font-bold {{ request()->routeIs('disciplines') ? 'text-fiot-accent' : 'hover:text-white transition' }}">Дисципліни</a>
        <a href="{{ route('admission') }}" @click="open = false" class="text-xl uppercase tracking-widest font-bold {{ request()->routeIs('admission') ? 'text-fiot-accent' : 'hover:text-white transition' }}">Вступникам</a>
        <a href="{{ route('news') }}" @click="open = false" class="text-xl uppercase tracking-widest font-bold {{ request()->routeIs('news*') ? 'text-fiot-accent' : 'hover:text-white transition' }}">Новини</a>
        <a href="{{ route('partners') }}" @click="open = false" class="text-xl uppercase tracking-widest font-bold {{ request()->routeIs('partners') ? 'text-fiot-accent' : 'hover:text-white transition' }}">Партнери</a>
    </div>
</div>