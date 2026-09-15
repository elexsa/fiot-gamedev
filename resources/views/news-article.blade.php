@extends('layouts.app')

@section('title', $article->title)

@section('meta_description', Str::limit($article->excerpt ?? '', 150))

@section('content')
<x-ui.page class="!min-h-0">
    <a href="{{ url()->previous() ?: route('news') }}"
       class="inline-flex items-center gap-2 text-sm text-fiot-gray hover:text-white transition-colors mb-10">
        <x-ui.icon name="arrow-left" class="w-3 h-3" />
        Назад
    </a>

    <article class="bg-fiot-dark/40 border border-white/10 rounded-2xl overflow-hidden">

        <div class="h-2 bg-gradient-to-r from-fiot-primary to-fiot-accent"></div>

        <div class="p-6 md:p-10">
            <div class="flex flex-wrap items-center gap-4 mb-6">
                <x-ui.badge>{{ $article->tag }}</x-ui.badge>
                <time class="text-sm text-fiot-gray" datetime="{{ $article->published_at->toDateString() }}">
                    {{ $article->published_at->translatedFormat('d F Y') }}
                </time>
            </div>

            <h1 class="text-2xl md:text-4xl font-bold tracking-tight text-white mb-8">
                {{ $article->title }}
            </h1>

            @if ($article->cover_image)
                <div class="mb-8 overflow-hidden rounded-xl border border-white/10 aspect-video bg-fiot-dark">
                    <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($article->cover_image) }}" alt="{{ $article->title }}" class="w-full h-full max-h-[420px] object-cover" loading="lazy" decoding="async">
                </div>
            @endif

            <p class="text-fiot-gray text-lg leading-relaxed mb-6 border-l-2 border-fiot-accent pl-4">
                {{ $article->excerpt }}
            </p>

            <div class="text-fiot-gray text-base leading-relaxed">
                {!! nl2br(e($article->body)) !!}
            </div>

            <div class="mt-12 pt-6 border-t border-white/10 text-sm text-fiot-gray">
                Текст матеріалу буде надано деканатом
            </div>
        </div>
    </article>
</x-ui.page>
@endsection