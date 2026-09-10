<div x-data="{ open: false }" 
     x-init="$watch('open', value => document.body.classList.toggle('overflow-hidden', value))"
     @keydown.escape.window="open = false">
     
    <header class="relative z-50 border-b border-fiot-dark bg-fiot-black/70 backdrop-blur-md w-full shadow-lg shadow-fiot-black/50">
        <div class="container mx-auto px-4 md:px-6 py-4 flex justify-between items-center">
            
            <div class="flex items-center gap-3 relative z-50">
                <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                    <div class="text-2xl font-bold tracking-tighter text-white">FICE</div>
                </a>
                <div class="hidden sm:block text-[9px] md:text-[10px] uppercase tracking-widest text-fiot-gray leading-tight border-l border-fiot-dark pl-3">
                    Кафедра<br> Комп'ютерних ігор
                </div>
            </div>
            
            <nav class="hidden lg:flex items-center gap-5 xl:gap-7">
                <a href="{{ route('home') }}" class="text-[11px] uppercase tracking-widest font-bold {{ request()->routeIs('home') ? 'text-fiot-accent' : 'hover:text-white transition' }}">Головна</a>
                <div class="relative group">
                    <a href="{{ route('admission') }}" class="text-[11px] uppercase tracking-widest font-bold {{ request()->routeIs('admission', 'about', 'programs') ? 'text-fiot-accent' : 'hover:text-white transition' }} flex items-center gap-1">Вступникам
                        <svg class="w-3 h-3 transition-transform group-hover:rotate-180" viewBox="0 0 24 24" fill="none"><path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                    </a>
                    <div class="absolute left-0 top-full pt-3 hidden group-hover:block">
                        <div class="bg-[#0b0c0f] border border-white/10 rounded-xl py-2 min-w-52 shadow-xl">
                            <a href="{{ route('admission') }}" class="block px-4 py-2 text-xs uppercase tracking-widest font-bold {{ request()->routeIs('admission') ? 'text-fiot-accent' : 'text-fiot-gray hover:text-white' }} transition">Етапи вступу</a>
                            <a href="{{ route('about') }}" class="block px-4 py-2 text-xs uppercase tracking-widest font-bold {{ request()->routeIs('about') ? 'text-fiot-accent' : 'text-fiot-gray hover:text-white' }} transition">Про кафедру</a>
                            <a href="{{ route('programs') }}" class="block px-4 py-2 text-xs uppercase tracking-widest font-bold {{ request()->routeIs('programs') ? 'text-fiot-accent' : 'text-fiot-gray hover:text-white' }} transition">Освітні програми</a>
                        </div>
                    </div>
                </div>
                <div class="relative group">
                    <a href="{{ route('disciplines') }}" class="text-[11px] uppercase tracking-widest font-bold {{ request()->routeIs('disciplines', 'syllabuses', 'syllabuses.diagram') ? 'text-fiot-accent' : 'hover:text-white transition' }} flex items-center gap-1">Студентам
                        <svg class="w-3 h-3 transition-transform group-hover:rotate-180" viewBox="0 0 24 24" fill="none"><path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                    </a>
                    <div class="absolute left-0 top-full pt-3 hidden group-hover:block">
                        <div class="bg-[#0b0c0f] border border-white/10 rounded-xl py-2 min-w-52 shadow-xl">
                            <a href="{{ route('syllabuses.diagram', ['mode' => 'skill']) }}" class="block px-4 py-2 text-xs uppercase tracking-widest font-bold {{ request()->routeIs('disciplines') ? 'text-fiot-accent' : 'text-fiot-gray hover:text-white' }} transition">Дерево навичок</a>
                            <a href="{{ route('syllabuses') }}" class="block px-4 py-2 text-xs uppercase tracking-widest font-bold {{ request()->routeIs('syllabuses') && ! request()->routeIs('syllabuses.diagram') ? 'text-fiot-accent' : 'text-fiot-gray hover:text-white' }} transition">Силабуси</a>
                            <a href="{{ route('syllabuses.diagram') }}" class="block px-4 py-2 text-xs uppercase tracking-widest font-bold {{ request()->routeIs('syllabuses.diagram') ? 'text-fiot-accent' : 'text-fiot-gray hover:text-white' }} transition">Діаграма дисциплін</a>
                        </div>
                    </div>
                </div>
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
        <a href="{{ route('admission') }}" @click="open = false" class="text-xl uppercase tracking-widest font-bold {{ request()->routeIs('admission') ? 'text-fiot-accent' : 'hover:text-white transition' }}">Вступникам</a>
        <div class="flex flex-col items-center gap-3">
            <a href="{{ route('about') }}" @click="open = false" class="text-sm uppercase tracking-widest text-fiot-gray {{ request()->routeIs('about') ? '!text-fiot-accent' : 'hover:text-white transition' }}">Про кафедру</a>
            <a href="{{ route('programs') }}" @click="open = false" class="text-sm uppercase tracking-widest text-fiot-gray {{ request()->routeIs('programs') ? '!text-fiot-accent' : 'hover:text-white transition' }}">Освітні програми</a>
        </div>
        <a href="{{ route('disciplines') }}" @click="open = false" class="text-xl uppercase tracking-widest font-bold {{ request()->routeIs('disciplines', 'syllabuses', 'syllabuses.diagram') ? 'text-fiot-accent' : 'hover:text-white transition' }}">Студентам</a>
        <div class="flex flex-col items-center gap-3">
            <a href="{{ route('syllabuses') }}" @click="open = false" class="text-sm uppercase tracking-widest text-fiot-gray {{ request()->routeIs('syllabuses') ? '!text-fiot-accent' : 'hover:text-white transition' }}">Силабуси</a>
            <a href="{{ route('syllabuses.diagram') }}" @click="open = false" class="text-sm uppercase tracking-widest text-fiot-gray {{ request()->routeIs('syllabuses.diagram') ? '!text-fiot-accent' : 'hover:text-white transition' }}">Діаграма</a>
        </div>
        <a href="{{ route('news') }}" @click="open = false" class="text-xl uppercase tracking-widest font-bold {{ request()->routeIs('news*') ? 'text-fiot-accent' : 'hover:text-white transition' }}">Новини</a>
        <a href="{{ route('partners') }}" @click="open = false" class="text-xl uppercase tracking-widest font-bold {{ request()->routeIs('partners') ? 'text-fiot-accent' : 'hover:text-white transition' }}">Партнери</a>
    </div>
</div>