@extends('layouts.app')

@section('title', $article['title'] . ' | F2 GameDev')

@section('meta_description', $article['excerpt'])

@section('content')
<section class="relative z-10 pt-16 md:pt-24 min-h-screen flex flex-col pb-20">
    <div class="container mx-auto max-w-screen-lg px-4 md:px-8 relative z-10">

        <a href="{{ route('news') }}"
           class="inline-flex items-center gap-2 text-[10px] md:text-xs text-gray-500 font-mono uppercase tracking-widest hover:text-white transition-colors mb-10">
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            До всіх новин
        </a>

        <article class="bg-[#0b0c0f] border border-[#2a2a35] rounded-xl overflow-hidden">

            <div class="h-2 bg-gradient-to-r from-fiot-primary to-fiot-accent"></div>

            <div class="p-6 md:p-10">
                <div class="flex flex-wrap items-center gap-4 mb-6">
                    <span class="text-[10px] font-mono uppercase tracking-widest text-fiot-accent border border-fiot-accent/30 bg-fiot-accent/5 px-2 py-1 rounded">
                        {{ $article['tag'] }}
                    </span>
                    <time class="text-[10px] text-gray-500 font-mono uppercase tracking-widest" datetime="{{ $article['date'] }}">
                        {{ \Carbon\Carbon::parse($article['date'])->translatedFormat('d F Y') }}
                    </time>
                </div>

                <h1 class="text-2xl md:text-4xl font-bold tracking-tight text-white uppercase mb-8">
                    {{ $article['title'] }}
                </h1>

                <p class="text-fiot-gray text-lg leading-relaxed mb-6 border-l-2 border-fiot-primary pl-4">
                    {{ $article['excerpt'] }}
                </p>

                <p class="text-fiot-gray text-base leading-relaxed">
                    {{ $article['body'] }}
                </p>

                <div class="mt-12 pt-6 border-t border-[#2a2a35] text-[10px] text-gray-600 font-mono uppercase tracking-widest">
                    [PLACEHOLDER_CONTENT] // Текст буде надано деканатом
                </div>
            </div>
        </article>

    </div>
</section>
@endsection