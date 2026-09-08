@extends('layouts.app')

@section('title', 'Новини | Кафедра ігрових систем')

@section('meta_description', 'Останні новини кафедри ігрових систем ФІОТ КПІ: події, хакатони, оновлення навчального плану та партнерства.')

@section('content')
<x-ui.page>
    <x-ui.page-header title="Новини" kicker="[PATCH_NOTES]" subtitle="Останні події, оновлення та досягнення кафедри й освітньої програми." />

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

        @foreach ($news as $item)
            <x-ui.card :href="route('news.article', ['slug' => $item['slug']])" interactive class="group overflow-hidden">
                <div class="h-2 bg-gradient-to-r from-fiot-primary/60 to-fiot-accent/40 group-hover:from-fiot-primary group-hover:to-fiot-accent transition-all duration-300"></div>

                <div class="p-6 flex-1 flex flex-col">
                    <div class="flex items-center justify-between mb-4">
                        <x-ui.badge>{{ $item['tag'] }}</x-ui.badge>
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
                        <x-ui.icon name="arrow-right" class="w-3 h-3 transition-transform group-hover:translate-x-1" />
                    </div>
                </div>
            </x-ui.card>
        @endforeach

    </div>
</x-ui.page>
@endsection