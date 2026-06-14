@extends('layouts.app')

@section('content')
<section class="relative z-10 pt-16 md:pt-24 lg:pt-32 pb-24 flex items-center min-h-[90vh]">
    
    <div class="absolute top-[10%] right-[2%] w-24 md:w-32 lg:w-48 xl:w-64 opacity-10 grayscale blur-[1px] pointer-events-none z-0">
        <img src="{{ asset('images/steve_67.gif') }}" alt="Steve" class="w-full h-full object-contain">
    </div>

    <div class="absolute bottom-[10%] left-[2%] w-24 md:w-32 lg:w-48 xl:w-64 opacity-10 grayscale blur-[1px] pointer-events-none z-0">
        <img src="{{ asset('images/nyam_cat.gif') }}" alt="Nyan Cat" class="w-full h-full object-contain">
    </div>

    <div class="container mx-auto max-w-[1400px] px-4 md:px-8 relative z-10">
        
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-12 xl:gap-20 items-center w-full">
            
            <div class="lg:col-span-7 xl:col-span-7 text-left w-full">
                <h1 class="text-5xl sm:text-6xl md:text-7xl xl:text-8xl font-bold leading-[1.05] mb-6 xl:mb-8 tracking-tighter drop-shadow-md">
                    Програмування <br class="hidden sm:block">
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-white via-fiot-primary to-purple-400">комп'ютерних ігор</span>
                </h1>
                
                <p class="text-gray-300 text-base md:text-lg xl:text-xl max-w-2xl mb-10 xl:mb-12 leading-relaxed font-light">
                    Офіційна освітня програма за спеціальністю <span class="text-white font-bold">F2 «Інженерія програмного забезпечення»</span>. 
                    Навчись створювати ігрові світи на базі найпотужнішого факультету країни.
                </p>

                <div class="flex flex-wrap gap-4 md:gap-8 mb-10 xl:mb-12 font-mono text-[10px] md:text-xs uppercase tracking-[0.2em] bg-[#121215]/95 p-5 md:p-6 rounded-lg border border-white/10 inline-flex backdrop-blur-xl shadow-2xl relative group">
                    <div class="absolute top-0 left-0 w-2 h-2 border-t border-l border-fiot-accent"></div>
                    
                    <div class="flex flex-col border-l-2 border-fiot-primary pl-3 md:pl-4">
                        <span class="text-gray-500 text-[9px] md:text-[10px] mb-1">Освітня програма</span>
                        <span class="text-white font-bold text-sm md:text-base lg:text-lg">F2</span>
                    </div>
                    <div class="flex flex-col border-l-2 border-fiot-accent pl-3 md:pl-4">
                        <span class="text-gray-500 text-[9px] md:text-[10px] mb-1">Головний Стек</span>
                        <span class="text-white font-bold text-sm md:text-base lg:text-lg">C++ / UE5</span>
                    </div>
                    <div class="flex flex-col border-l-2 border-purple-500 pl-3 md:pl-4">
                        <span class="text-gray-500 text-[9px] md:text-[10px] mb-1">Локація</span>
                        <span class="text-white font-bold text-sm md:text-base lg:text-lg">Корпус 18</span>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="#" class="w-full sm:w-auto px-10 py-4 md:py-5 bg-white text-black font-bold uppercase tracking-widest text-[10px] md:text-xs hover:bg-fiot-accent hover:shadow-[0_0_20px_rgba(18,230,49,0.3)] transition-all text-center rounded-sm">
                        Почати квест
                    </a>
                    <a href="/disciplines" class="w-full sm:w-auto px-10 py-4 md:py-5 border border-fiot-dark bg-fiot-black/50 text-white font-bold uppercase tracking-widest text-[10px] md:text-xs hover:border-fiot-primary transition-all text-center rounded-sm backdrop-blur-md">
                        Дерево навичок
                    </a>
                </div>
            </div>

            <div class="lg:col-span-5 xl:col-span-5 w-full relative mt-10 lg:mt-0 group">
                <div class="relative bg-[#0d0d0f] border border-fiot-dark rounded-lg flex flex-col font-mono text-[10px] md:text-[11px] min-h-[300px] md:min-h-[380px] shadow-2xl overflow-hidden w-full">
                    
                    <div class="h-8 md:h-9 bg-[#16161a] border-b border-fiot-dark flex items-center px-4 justify-between z-10 shrink-0">
                        <div class="flex gap-1.5 md:gap-2">
                            <div class="w-2 md:w-2.5 h-2 md:h-2.5 rounded-full bg-red-500/30"></div>
                            <div class="w-2 md:w-2.5 h-2 md:h-2.5 rounded-full bg-yellow-500/30"></div>
                            <div class="w-2 md:w-2.5 h-2 md:h-2.5 rounded-full bg-green-500/30"></div>
                        </div>
                        <span class="text-[8px] md:text-[9px] text-gray-600 uppercase tracking-widest">fice_engine.exe</span>
                    </div>
                    
                    <div id="console-output" class="p-4 md:p-6 text-gray-500 space-y-2 flex-1 relative z-10 flex flex-col justify-end overflow-hidden">
                    </div>
                    
                    <div class="scanline z-20 pointer-events-none"></div>
                    
                    <div class="p-4 md:p-5 bg-[#16161a]/90 border-t border-fiot-dark z-10 backdrop-blur-sm shrink-0">
                        <div class="flex justify-between mb-2 text-[9px] md:text-[10px] uppercase tracking-widest text-gray-500 font-bold">
                            <span id="status-text" class="animate-pulse">Loading Assets...</span>
                            <span id="percent" class="text-fiot-accent">0%</span>
                        </div>
                        <div class="w-full h-1 bg-black rounded-full overflow-hidden">
                            <div id="progress-bar" class="h-full bg-fiot-accent w-0 transition-all duration-700 relative">
                                <div class="absolute inset-0 bg-white/10 animate-[pulse_1s_ease-in-out_infinite]"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
@endsection

@section('scripts')
<script>
    const logPool = [
        ">> Mounting C++ classes...",
        ">> Loading texture atlas_01.png",
        ">> Connecting to Building 18 Server...",
        ">> Initializing UE5 Engine...",
        ">> Compiling Shaders (244/1024)...",
        ">> Success. Virtual world ready.",
        ">> Optimizing physics engine...",
        ">> Resolving character animations..."
    ];
    
    const output = document.getElementById('console-output');
    const progressBar = document.getElementById('progress-bar');
    const percentText = document.getElementById('percent');
    const statusText = document.getElementById('status-text');
    
    let progress = 0;
    const MAX_LINES = 7;

    function generateLog() {
        if(!output) return;
        const p = document.createElement('p');
        p.className = Math.random() > 0.85 ? "text-fiot-accent" : "text-gray-500";
        p.textContent = logPool[Math.floor(Math.random() * logPool.length)];
        output.appendChild(p);

        if (output.childNodes.length > MAX_LINES) output.removeChild(output.firstChild);
        
        progress += Math.random() * 4 + 1; 
        if (progress > 100) progress = 0; 
        
        progressBar.style.width = progress + "%";
        percentText.textContent = Math.round(progress) + "%";
        
        setTimeout(generateLog, Math.random() * 1200 + 400);
    }
    
    window.onload = generateLog;
</script>
@endsection