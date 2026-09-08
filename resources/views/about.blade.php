@extends('layouts.app')

@section('title', 'Про кафедру | Кафедра ігрових систем')

@section('meta_description', 'Про кафедру ігрових систем ФІОТ КПІ: місія, викладацький склад та матеріально-технічна база.')

@section('content')
<x-ui.page>
    <x-ui.page-header title="Про кафедру" kicker="Про кафедру" subtitle="Хто ми, чому нас варто обрати та хто проведе вас по грі." />

        {{-- Історія та місія --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 mb-20">

            <div class="reveal-on-scroll">
                <div class="border-l-2 border-fiot-accent pl-5">
                    <h2 class="text-xl font-bold text-white tracking-tight mb-2">Наша місія</h2>
                </div>
                <p class="text-fiot-gray text-lg leading-relaxed mb-6">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ми готуємо інженерів, здатних проєктувати та створювати ігри світового рівня — від низькорівневої графіки до цілісного геймдизайну.
                </p>
                <p class="text-fiot-gray text-lg leading-relaxed">
                    Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Поєднання фундаментальної інженерної освіти КПІ з практичним досвідом індустріальних партнерів.
                </p>
            </div>

            <div class="reveal-on-scroll relative">
                <div class="h-[300px] bg-fiot-dark/40 border border-white/10 rounded-2xl flex items-center justify-center relative overflow-hidden shadow-2xl">
                    <div class="absolute inset-0 opacity-10 bg-[linear-gradient(45deg,#4D11CC_1px,transparent_1px)] bg-[length:20px_20px]"></div>
                    <span class="text-sm text-fiot-gray z-10">Фото команди — буде додано</</span>
                </div>
            </div>

        </div>

        {{-- Цифри --}}
        <div class="reveal-on-scroll grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-20">
            @foreach (config('content.stats') as $stat)
                <x-ui.card class="text-center py-6 hover:border-fiot-primary/50">
                    <x-ui.stat :value="$stat['value']" :label="$stat['label']" class="!py-0" />
                </x-ui.card>
            @endforeach
        </div>

        {{-- Викладачі --}}
        <div class="reveal-on-scroll mb-12">
            <div class="border-l-2 border-fiot-accent pl-5">
                <h2 class="text-xl font-bold text-white tracking-tight mb-2">Викладацький склад</h2>
            </div>
            <p class="text-fiot-gray text-sm mb-8">Ментори й викладачі, які ведуть студентів через програму.</p>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                @foreach ($faculty as $person)
                    <x-ui.card interactive class="group p-6">
                        <div class="flex items-start gap-4">
                            <div class="w-14 h-14 shrink-0 rounded-xl border border-white/10 bg-gradient-to-br from-fiot-primary/20 to-fiot-accent/10 flex items-center justify-center font-bold text-lg text-white/70 group-hover:border-fiot-accent/40 transition-colors overflow-hidden">
                                @if ($person->photo)
                                    <img src="{{ asset($person->photo) }}" alt="{{ $person->name }}" class="w-full h-full object-cover">
                                @else
                                    {{ mb_substr($person->name, 0, 1) }}
                                @endif
                            </div>
                            <div>
                                <h3 class="text-white font-bold mb-1">{{ $person->name }}</h3>
                                <p class="text-sm text-fiot-gray mb-2">{{ $person->role }}</p>
                                <p class="text-gray-400 text-xs leading-relaxed">{{ $person->focus }}</p>
                            </div>
                        </div>
                    </x-ui.card>
                @endforeach

            </div>
        </div>

        {{-- Матеріальна база --}}
        <div class="reveal-on-scroll grid grid-cols-1 lg:grid-cols-2 gap-16 items-center border-t border-white/10 pt-16">
            <div class="h-[350px] bg-fiot-dark/40 border border-white/10 rounded-2xl relative flex items-center justify-center overflow-hidden">
                <div class="absolute inset-0 opacity-10 bg-[linear-gradient(to_right,#4D11CC_1px,transparent_1px),linear-gradient(to_bottom,#4D11CC_1px,transparent_1px)] bg-[length:30px_30px]"></div>
                <span class="text-sm text-fiot-gray z-10">Фото класів — буде додано</</span>
            </div>
            <div class="order-1 lg:order-2">
                <div class="border-l-2 border-fiot-accent pl-5">
                    <h2 class="text-xl font-bold text-white tracking-tight mb-2">Матеріально-технічна база</h2>
                </div>
                <p class="text-fiot-gray text-lg leading-relaxed mb-6">
                    Lorem ipsum dolor sit amet: сучасні комп'ютерні класи з ліцензійним ПЗ, лабораторії розробки та тестування ігор, простір для командних проєктів.
                </p>
                <p class="text-fiot-gray text-lg leading-relaxed">
                    Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                </p>
            </div>
        </div>

    </x-ui.page>
@endsection