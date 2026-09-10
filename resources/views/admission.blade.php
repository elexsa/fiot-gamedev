@extends('layouts.app')

@section('title', 'Вступникам')

@section('meta_description', 'Вступ на кафедру ігрових систем ФІОТ: етапи вступу, калькулятор конкурсного бала та освітні програми.')

@section('content')
<x-ui.page>
    <x-ui.page-header title="Вступ" subtitle="Дорожня карта вступу, калькулятор конкурсного бала та освітні програми кафедри.">
        <div class="flex flex-col sm:flex-row gap-4 mt-8">
            <x-ui.button href="https://vstup.edbo.gov.ua/" variant="primary" size="lg">Подати заяву</x-ui.button>
            <x-ui.button href="#programs" variant="outline" size="lg">Освітні програми</x-ui.button>
        </div>
    </x-ui.page-header>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 mb-20">
        <div class="lg:col-span-7">
            <div class="mb-8">
                <h2 class="text-3xl md:text-4xl font-bold tracking-tight text-white">Етапи вступу</h2>
            </div>
            @if (!empty($steps))
                <x-ui.steps :steps="$steps" />
            @else
                <x-ui.card class="p-6">
                    <p class="text-fiot-gray text-sm">Етапи вступу поки не додані. Зачекайте поки їх додадуть через адмін-панель</p>
                </x-ui.card>
            @endif
        </div>
        <div class="lg:col-span-5">
            <x-admission.calculator :config="$calculator" />
        </div>
    </div>
</x-ui.page>

<x-ui.section id="programs" title="Освітні програми" subtitle="lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.">
    @if ($programs->isNotEmpty())
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach ($programs as $program)
                <x-program.card :program="$program" />
            @endforeach
        </div>
        <div class="mt-8">
            <x-ui.button href="{{ route('programs') }}" variant="outline" size="md" class="group">
                Усі програми
                <x-ui.icon name="arrow-right" class="w-3 h-3 ml-2 transition-transform group-hover:translate-x-1" />
            </x-ui.button>
        </div>
    @else
        <x-ui.card class="p-6">
            <p class="text-fiot-gray text-sm">Освітні програми поки не додані. Їх додадуть через адмін-панель</p>
        </x-ui.card>
    @endif
</x-ui.section>

<x-ui.section title="Потрібна допомога" subtitle="Напишіть нам — допоможемо зі всім з метеоритом що летить на динозаврів, з пріоритетами, документами та питаннями про програму.">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-4xl">
        <x-ui.card interactive class="group p-6 flex items-center gap-5">
            <span class="text-fiot-gray transition-colors group-hover:text-white">
                <x-ui.icon name="telegram" class="w-10 h-10" />
            </span>
            <span>
                <span class="block text-white font-bold text-lg mb-1">Telegram</span>
                <a href="{{ \App\Models\SiteSetting::get('contacts.social.telegram', '#') }}" class="text-sm text-fiot-gray transition-colors group-hover:text-white">Написати в Telegram</a>
            </span>
        </x-ui.card>
        <x-ui.card interactive class="group p-6 flex items-center gap-5">
            <span class="text-fiot-gray transition-colors group-hover:text-white">
                <x-ui.icon name="discord" class="w-10 h-10" />
            </span>
            <span>
                <span class="block text-white font-bold text-lg mb-1">Discord</span>
                <a href="{{ \App\Models\SiteSetting::get('contacts.social.discord', '#') }}" class="text-sm text-fiot-gray transition-colors group-hover:text-white">Долучитись до спільноти</a>
            </span>
        </x-ui.card>
    </div>
</x-ui.section>
@endsection
