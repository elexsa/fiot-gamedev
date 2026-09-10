@extends('layouts.app')

@section('title', 'Освітні програми | Кафедра ігрових систем')

@section('meta_description', 'Освітні програми кафедри ігрових систем ФІОТ КПІ: спеціальності, ступені та опис програм.')

@section('content')
<x-ui.page>
    <x-ui.page-header title="Освітні програми" kicker="Вступникам" subtitle="Програми, за якими готує кафедра. Деталі — у деканаті та на сторінці вступу." />

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-20">

        @forelse ($programs as $program)
            <x-ui.card class="group overflow-hidden">
                @if ($program->image)
                    <div class="h-48 overflow-hidden border-b border-white/10">
                        <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($program->image) }}" alt="{{ $program->name }}" class="h-full w-full object-cover group-hover:scale-105 transition-transform duration-500">
                    </div>
                @endif
                <div class="p-6 flex-1 flex flex-col">
                    <div class="flex flex-wrap items-center gap-2 mb-3">
                        @if ($program->specialty_code)
                            <x-ui.badge>{{ $program->specialty_code }}</x-ui.badge>
                        @endif
                        @if ($program->degree)
                            <x-ui.badge>{{ $program->degree }}</x-ui.badge>
                        @endif
                    </div>
                    <h3 class="text-white font-bold text-xl mb-2">{{ $program->name }}</h3>
                    @if ($program->description)
                        <p class="text-gray-400 text-sm leading-relaxed mb-6 flex-1">{{ $program->description }}</p>
                    @endif
                    <div class="inline-flex items-center gap-2 text-sm text-fiot-gray mt-auto group-hover:text-fiot-primary transition-colors">
                        Детальніше — на сторінці
                        <a href="{{ route('admission') }}" class="text-fiot-accent hover:text-white transition-colors">Вступникам</a>
                        <x-ui.icon name="arrow-right" class="w-3 h-3" />
                    </div>
                </div>
            </x-ui.card>
        @empty
            <x-ui.card class="p-6 md:col-span-2">
                <p class="text-fiot-gray">Освітні програми поки не додані. Додайте їх через адмін-панель.</p>
            </x-ui.card>
        @endforelse

    </div>
</x-ui.page>
@endsection
