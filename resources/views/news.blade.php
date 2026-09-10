@extends('layouts.app')

@section('title', 'Новини')

@section('meta_description', 'Останні новини кафедри ігрових систем ФІОТ КПІ: події, хакатони, оновлення навчального плану та партнерства.')

@section('content')
<x-ui.page>
    <x-ui.page-header title="Новини" kicker="Новини кафедри" subtitle="Останні події, оновлення та досягнення кафедри й освітньої програми." />

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

        @foreach ($news as $item)
            <x-ui.card :href="route('news.article', $item)" interactive class="group overflow-hidden">
                @if ($item->cover_image)
                    <div class="h-48 overflow-hidden border-b border-white/10">
                        <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($item->cover_image) }}" alt="{{ $item->title }}" loading="lazy" decoding="async" class="h-full w-full object-cover group-hover:scale-105 transition-transform duration-500">
                    </div>
                @else
                    <div class="h-2 bg-gradient-to-r from-fiot-primary/60 to-fiot-accent/40 group-hover:from-fiot-primary group-hover:to-fiot-accent transition-all duration-300"></div>
                @endif

                <div class="p-6 flex-1 flex flex-col">
                    <div class="flex items-center justify-between mb-4">
                        <x-ui.badge>{{ $item->tag }}</x-ui.badge>
                        <time class="text-sm text-fiot-gray" datetime="{{ $item->published_at->toDateString() }}">
                            {{ $item->published_at->translatedFormat('d.m.Y') }}
                        </time>
                    </div>

                    <h2 class="text-white font-bold text-lg mb-3 group-hover:text-fiot-accent transition-colors">
                        {{ $item->title }}
                    </h2>

                    <p class="text-gray-400 text-sm leading-relaxed mb-6 flex-1">
                        {{ $item->excerpt }}
                    </p>

                    <div class="inline-flex items-center gap-2 text-sm text-fiot-gray mt-auto group-hover:text-fiot-primary transition-colors">
                        Читати далі
                        <x-ui.icon name="arrow-right" class="w-3 h-3 transition-transform group-hover:translate-x-1" />
                    </div>
                </div>
            </x-ui.card>
        @endforeach

    </div>
</x-ui.page>
@endsection