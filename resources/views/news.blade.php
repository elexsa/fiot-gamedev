@extends('layouts.app')

@section('title', 'Новини | F2 GameDev')

@section('meta_description', 'Останні новини освітньої програми «Програмування комп’ютерних ігор» ФІОТ КПІ: події, хакатони, оновлення навчального плану та партнерства.')

@section('content')
<section class="relative z-10 pt-16 md:pt-24 min-h-screen flex flex-col pb-20">
    <div class="container mx-auto max-w-screen-xl px-4 md:px-8 relative z-10">

        <div class="mb-12 md:mb-16 border-l-4 border-white pl-4 md:pl-6">
            <h1 class="text-3xl md:text-5xl lg:text-6xl font-bold tracking-tighter mb-2 text-white uppercase">
                Новини
            </h1>
            <p class="text-gray-400 max-w-2xl text-[10px] md:text-xs lg:text-sm font-mono">
                [PATCH_NOTES] // Останні події, оновлення та досягнення програми.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

            @foreach ($news as $item)
                <a href="{{ route('news.article', ['slug' => $item['slug']]) }}"
                   class="group flex flex-col bg-[#0b0c0f] border border-[#2a2a35] rounded-xl overflow-hidden hover:border-fiot-accent/50 hover:shadow-[0_0_25px_rgba(18,230,49,0.08)] hover:-translate-y-1 transition-all duration-300">

                    <div class="h-2 bg-gradient-to-r from-fiot-primary/60 to-fiot-accent/40 group-hover:from-fiot-primary group-hover:to-fiot-accent transition-all duration-300"></div>

                    <div class="p-6 flex-1 flex flex-col">
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-[10px] font-mono uppercase tracking-widest text-fiot-accent border border-fiot-accent/30 bg-fiot-accent/5 px-2 py-1 rounded">
                                {{ $item['tag'] }}
                            </span>
                            <time class="text-[10px] text-gray-500 font-mono uppercase tracking-widest" datetime="{{ $item['date'] }}">
                                {{ \Carbon\Carbon::parse($item['date'])->translatedFormat('d.m.Y') }}
                            </time>
                        </div>

                        <h2 class="text-white font-bold text-lg mb-3 group-hover:text-fiot-accent transition-colors">
                            {{ $item['title'] }}
                        </h2>

                        <p class="text-gray-400 text-sm leading-relaxed mb-6 flex-1">
                            {{ $item['excerpt'] }}
                        </p>

                        <div class="text-[10px] text-gray-500 font-mono uppercase tracking-widest flex items-center gap-2 mt-auto group-hover:text-white transition-colors">
                            Читати далі
                            <svg class="w-3 h-3 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </div>
                    </div>
                </a>
            @endforeach

        </div>
    </div>
</section>
@endsection