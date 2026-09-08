@extends('layouts.app')

@section('title', 'GameDev | ФІОТ')

@section('content')
<main class="flex flex-col relative overflow-hidden">
    
    <section class="min-h-[calc(100vh-80px)] flex items-center relative px-6 py-12 justify-center flex-col overflow-hidden">
        <div class="absolute inset-0 pointer-events-none opacity-[0.04] bg-[radial-gradient(circle,white_1px,transparent_1px)] bg-[length:40px_40px]"></div>
        
        <div class="container mx-auto flex flex-col lg:flex-row items-center justify-between gap-12 z-10 my-auto">
            <div class="w-full lg:w-1/2 flex flex-col justify-center gap-8 text-center lg:text-left">
                <h1 class="text-white text-5xl md:text-7xl font-bold uppercase tracking-tighter opacity-90 max-w-lg mx-auto lg:mx-0 leading-[0.9]">
                    Програмування <br>
                    <span class="text-fiot-gray">комп'ютерних ігор</span>
                </h1>
                <div class="flex flex-col sm:flex-row gap-6 mt-4 justify-center lg:justify-start w-full max-w-lg mx-auto lg:mx-0">
                    <a href="{{ route('admission') }}" class="btn btn-primary btn-lg">Вступнику</a>
                    <a href="/disciplines" class="btn btn-secondary btn-lg">Студенту</a>
                </div>
            </div>

            <div class="w-full lg:w-1/2 h-[400px] lg:h-[500px] flex items-center justify-center relative z-10">
                <model-viewer 
                    src="{{ asset('models/cool_fice_frog.glb') }}" 
                    alt="Cyber frog"
                    auto-rotate
                    rotation-per-second="15deg"
                    camera-controls
                    disable-zoom
                    shadow-intensity="1.5"
                    class="w-full h-full outline-none">
                </model-viewer>
            </div>
        </div>
        
        <div class="absolute bottom-0 left-0 w-full h-48 bg-gradient-to-t from-[#080809] to-transparent pointer-events-none z-20"></div>
    </section>

    <section class="reveal-on-scroll py-24 px-6 border-fiot-dark bg-gradient-to-b from-[#080809] to-[#14161C]">
        <div class="container mx-auto grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
            
            <div class="max-w-none border-fiot-primary pl-8">
                <h3 class="text-white text-3xl md:text-4xl font-bold uppercase tracking-tight mb-6">Інженерний підхід</h3>
                <p class="text-fiot-gray text-lg leading-relaxed mb-6 font-body">
                    Офіційна освітня програма за спеціальністю <strong>121 «Інженерія програмного забезпечення»</strong>. Ми готуємо архітекторів систем реального часу.
                </p>
                <p class="text-fiot-gray text-lg leading-relaxed font-body">
                    Глибока математика, комп'ютерна графіка та системне програмування на базі ФІОТ.
                </p>
            </div>

            <div class="h-[350px] bg-[#080809]/40 border border-fiot-dark rounded-xl flex items-center justify-center relative overflow-hidden shadow-2xl">
                <div class="absolute inset-0 opacity-10 bg-[linear-gradient(45deg,#4D11CC_1px,transparent_1px)] bg-[length:20px_20px]"></div>
                <span class="text-fiot-gray/50 text-xs font-mono uppercase tracking-widest z-10">[Render: Raytracing Engine]</span>
            </div>
            
        </div>
    </section>

    <section class="reveal-on-scroll py-24 px-6 border-t border-fiot-dark">
        <div class="container mx-auto grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
            <div class="h-[400px] bg-fiot-dark rounded-lg overflow-hidden border border-fiot-dark relative order-2 lg:order-1 flex items-center justify-center">
                <div class="absolute inset-0 opacity-10 bg-[linear-gradient(to_right,#4D11CC_1px,transparent_1px),linear-gradient(to_bottom,#4D11CC_1px,transparent_1px)] bg-[length:30px_30px]"></div>
                <span class="text-fiot-gray/50 text-xs font-mono uppercase tracking-widest z-10">[IMAGE: Корпус 18 ФІОТ]</span>
                <div class="absolute bottom-6 left-6 font-bold tracking-widest text-sm z-10">КОРПУС 18</div>
            </div>
            <div class="max-w-none order-1 lg:order-2">
                <h3 class="text-white text-3xl md:text-4xl font-bold uppercase tracking-tight mb-6">Фізична база кафедри</h3>
                <p class="text-fiot-gray text-lg leading-relaxed">
                    Ми знаходимося в серці технічного університету — легендарному 18-му корпусі ФІОТ.
                </p>
            </div>
        </div>
    </section>

    {{-- Статистика --}}
    <section class="reveal-on-scroll py-16 px-6 border-t border-fiot-dark bg-[#0b0c0f]">
        <div class="container mx-auto grid grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach (config('content.stats') as $stat)
                <div class="text-center">
                    <div class="text-4xl md:text-5xl font-bold text-white tracking-tighter mb-2">{{ $stat['value'] }}</div>
                    <div class="text-[10px] md:text-xs text-fiot-gray font-mono uppercase tracking-widest">{{ $stat['label'] }}</div>
                </div>
            @endforeach
        </div>
    </section>

    {{-- Останні новини --}}
    <section class="reveal-on-scroll py-24 px-6 border-t border-fiot-dark">
        <div class="container mx-auto">

            <div class="flex flex-col md:flex-row justify-between md:items-end gap-4 mb-12">
                <div>
                    <h3 class="text-white text-3xl md:text-4xl font-bold uppercase tracking-tight mb-2">Останні новини</h3>
                    <p class="text-gray-400 text-xs font-mono">[LATEST_UPDATES] // Що нового у світі програми</p>
                </div>
                <a href="{{ route('news') }}" class="btn btn-outline btn-md self-start md:self-auto group">
                    Усі новини
                    <svg class="w-3 h-3 ml-2 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach (array_slice(config('content.news'), 0, 3) as $item)
                    <a href="{{ route('news.article', ['slug' => $item['slug']]) }}"
                       class="group flex flex-col bg-[#0b0c0f] border border-[#2a2a35] rounded-xl overflow-hidden hover:border-fiot-accent/50 hover:-translate-y-1 transition-all duration-300">
                        <div class="p-6 flex-1 flex flex-col">
                            <div class="flex items-center justify-between mb-4">
                                <span class="text-[10px] font-mono uppercase tracking-widest text-fiot-accent">{{ $item['tag'] }}</span>
                                <time class="text-[10px] text-gray-500 font-mono uppercase tracking-widest" datetime="{{ $item['date'] }}">
                                    {{ \Carbon\Carbon::parse($item['date'])->translatedFormat('d.m.Y') }}
                                </time>
                            </div>
                            <h4 class="text-white font-bold mb-3 group-hover:text-fiot-accent transition-colors">{{ $item['title'] }}</h4>
                            <p class="text-gray-400 text-sm leading-relaxed flex-1">{{ $item['excerpt'] }}</p>
                        </div>
                    </a>
                @endforeach
            </div>

        </div>
    </section>

</main>
@endsection
