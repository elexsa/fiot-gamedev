@extends('layouts.app')

@section('title', 'Партнери | Кафедра ігрових систем')

@section('meta_description', 'Індустріальні партнери кафедри ігрових систем ФІОТ КПІ: менторство, стажування та працевлаштування для студентів.')

@section('content')
<x-ui.page>
    <x-ui.page-header title="Партнери" kicker="Партнери кафедри" subtitle="Компанії, з якими ми співпрацюємо. Менторство, стажування та працевлаштування для студентів." />

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-20">

        @foreach ($partners as $partner)
            <x-ui.card :href="$partner->url" interactive class="group overflow-hidden">
                <div class="h-32 flex items-center justify-center bg-fiot-dark/60 border-b border-white/10 p-8 relative overflow-hidden">
                    @if ($partner->logo)
                        <img src="{{ asset($partner->logo) }}" alt="{{ $partner->name }}" class="max-h-full max-w-full object-contain grayscale opacity-40 group-hover:grayscale-0 group-hover:opacity-100 transition-all duration-500 relative z-10">
                    @else
                        <span class="text-2xl font-bold tracking-tighter text-white/40">{{ mb_substr($partner->name, 0, 2) }}</span>
                    @endif
                </div>
                <div class="p-6 flex-1 flex flex-col">
                    <h3 class="text-white font-bold text-xl mb-2">{{ $partner->name }}</h3>
                    <p class="text-gray-400 text-sm leading-relaxed mb-6 flex-1">{{ $partner->description }}</p>
                    <div class="inline-flex items-center gap-2 text-sm text-fiot-gray mt-auto group-hover:text-fiot-primary transition-colors">
                        Відвідати сайт
                        <x-ui.icon name="arrow-right" class="w-3 h-3 transition-transform group-hover:translate-x-1" />
                    </div>
                </div>
            </x-ui.card>
        @endforeach

    </div>
</x-ui.page>
@endsection
