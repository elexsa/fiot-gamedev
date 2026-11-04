@extends('layouts.app')

@section('title', 'Про кафедру')

@section('meta_description', 'Про кафедру ігрових та інтелектуальних систем ФІОТ КПІ: місія, викладацький склад та матеріально-технічна база.')

@section('content')
<x-ui.page>
    <x-ui.page-header title="Про кафедру" />

        {{-- Історія та місія --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 mb-20">

            <div class="reveal-on-scroll">
                <div class="border-fiot-accent ">
                    <h2 class="text-xl font-bold text-white tracking-tight mb-2">Історія</h2>
                </div>
                <p class="text-fiot-gray text-lg leading-relaxed mb-6">
                    Кафедра працює з 01.07.2026.
                </p>
                <div class="border-fiot-accent ">
                    <h2 class="text-xl font-bold text-white tracking-tight mb-2">Мета</h2>
                </div>
                <p class="text-fiot-gray text-lg leading-relaxed">
                    Наша мета — підготовка інженерів-розробників, здатних проєктувати та втілювати складні технологічні рішення.
                </p>
            </div>

            <div class="reveal-on-scroll relative">
                <x-ui.placeholder height="h-[300px]" label="Фото викладачів"/>
            </div>

        </div>

        {{-- Цифри --}}
        @php $stats = \App\Models\SiteSetting::get('stats', []); @endphp
        @if (!empty($stats))
        <div class="reveal-on-scroll grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-20">
            @foreach ($stats as $stat)
                <x-ui.card class="text-center py-6 hover:border-fiot-primary/50">
                    <x-ui.stat :value="$stat['value']" :label="$stat['label']" class="!py-0" />
                </x-ui.card>
            @endforeach
        </div>
        @endif

        {{-- Викладачі --}}
        @include('staff.staff_info')

        {{-- Матеріальна база --}}
        <div class="reveal-on-scroll grid grid-cols-1 lg:grid-cols-2 gap-16 items-center border-t border-white/10 pt-16">
            <x-ui.placeholder height="h-[350px]" label="Фото приміщень"/>
            <div class="order-1 lg:order-2">
                <div class="border-fiot-accent ">
                    <h2 class="text-xl font-bold text-white tracking-tight mb-2">Матеріально-технічна база</h2>
                </div>
                <p class="text-fiot-gray text-lg leading-relaxed mb-6">
                    Матеріально-технічна база кафедри відповідає сучасним вимогам освітніх стандартів.
                </p>
            </div>
        </div>

    </x-ui.page>
@endsection