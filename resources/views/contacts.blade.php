@extends('layouts.app')

@section('title', 'Контакти | Кафедра ігрових систем')

@section('meta_description', 'Контакти кафедри ігрових систем ФІОТ КПІ: адреса (корпус 18), телефон, email, Telegram та Discord спільноти.')

@section('content')
<x-ui.page>
    <x-ui.page-header title="Контакти" kicker="[GET_IN_TOUCH] // Зв'яжіться з нами" subtitle="Питання щодо вступу, навчання чи співпраці — ми на зв'язку." />

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-16">

        <x-ui.card interactive href="tel:{{ preg_replace('/[^0-9+]/', '', config('content.contacts.phone')) }}" class="p-8">
            <div class="text-[10px] font-mono uppercase tracking-widest text-fiot-gray mb-3">Телефон</div>
            <div class="text-white font-bold text-lg font-mono">{{ config('content.contacts.phone') }}</div>
            <div class="text-fiot-gray text-sm mt-2">Пн–Пт, 10:00–17:00</div>
        </x-ui.card>

        <x-ui.card interactive href="mailto:{{ config('content.contacts.email') }}" class="p-8">
            <div class="text-[10px] font-mono uppercase tracking-widest text-fiot-gray mb-3">Email</div>
            <div class="text-white font-bold text-lg font-mono">{{ config('content.contacts.email') }}</div>
            <div class="text-fiot-gray text-sm mt-2">Відповідаємо протягом 1–2 робочих днів</div>
        </x-ui.card>

        <x-ui.card class="p-8 lg:col-span-2">
            <div class="text-[10px] font-mono uppercase tracking-widest text-fiot-gray mb-3">Адреса</div>
            <div class="text-white font-bold text-lg mb-1">{{ config('content.contacts.address') }}</div>
            <div class="mt-6 h-64 bg-fiot-dark/40 border border-white/10 rounded-xl flex items-center justify-center relative overflow-hidden">
                <div class="absolute inset-0 opacity-10 bg-[linear-gradient(to_right,#4D11CC_1px,transparent_1px),linear-gradient(to_bottom,#4D11CC_1px,transparent_1px)] bg-[length:30px_30px]"></div>
                <span class="text-fiot-gray/50 text-xs font-mono uppercase tracking-widest z-10">[MAP: Корпус 18, КПІ]</span>
            </div>
        </x-ui.card>

        <x-ui.card interactive href="{{ config('content.contacts.social.telegram') }}" class="p-8">
            <div class="flex items-center gap-3 mb-3">
                <x-ui.icon name="telegram" class="w-6 h-6 text-[#2AABEE]" />
                <div class="text-white font-bold">Telegram</div>
            </div>
            <div class="text-fiot-gray text-sm">Офіційний чат для абітурієнтів та студентів</div>
        </x-ui.card>

        <x-ui.card interactive href="{{ config('content.contacts.social.discord') }}" class="p-8">
            <div class="flex items-center gap-3 mb-3">
                <x-ui.icon name="discord" class="w-6 h-6 text-[#5865F2]" />
                <div class="text-white font-bold">Discord</div>
            </div>
            <div class="text-fiot-gray text-sm">Спільнота студентів, проєкти та тіммейти</div>
        </x-ui.card>

    </div>
</x-ui.page>
@endsection
