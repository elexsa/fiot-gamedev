@extends('layouts.app')

@section('title', 'Про кафедру')

@section('meta_description', 'Про кафедру комп\'ютерних ігор ФІОТ КПІ: місія, викладацький склад та матеріально-технічна база.')

@section('content')
<x-ui.page>
    <x-ui.page-header title="Про кафедру" />

        {{-- Історія та місія --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 mb-20">

            <div class="reveal-on-scroll">
                <div class="border-fiot-accent ">
                    <h2 class="text-xl font-bold text-white tracking-tight mb-2">Історія і місія чи ше шось</h2>
                </div>
                <p class="text-fiot-gray text-lg leading-relaxed mb-6">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ми готуємо інженерів, здатних проєктувати та створювати ігри світового рівня — від низькорівневої графіки до цілісного геймдизайну.
                </p>
                <p class="text-fiot-gray text-lg leading-relaxed">
                    Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                </p>
            </div>

            <div class="reveal-on-scroll relative">
                <x-ui.placeholder height="h-[300px]" label="Можливо фото викладачів чи котика якогось"/>
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
        <div class="reveal-on-scroll mb-12">
            <div class="border-fiot-accent ">
                <h2 class="text-xl font-bold text-white tracking-tight mb-2">Викладачі</h2>
            </div>
            <p class="text-fiot-gray text-sm mb-8">Lore ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                @foreach ($faculty as $person)
                    <x-ui.card class="group p-6">
                        <div class="flex items-start gap-4">
                            @if ($person->photo)
                                <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($person->photo) }}" alt="{{ $person->name }}" loading="lazy" decoding="async" width="56" height="56" class="w-14 h-14 shrink-0 rounded-xl border border-white/10 object-cover overflow-hidden">
                            @else
                                <x-ui.placeholder type="avatar" size="md" :text="mb_substr($person->name, 0, 1)"/>
                            @endif
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
            <x-ui.placeholder height="h-[350px]" label="Фото приміщень"/>
            <div class="order-1 lg:order-2">
                <div class="border-fiot-accent ">
                    <h2 class="text-xl font-bold text-white tracking-tight mb-2">Матеріально-технічна база</h2>
                </div>
                <p class="text-fiot-gray text-lg leading-relaxed mb-6">
                    Lorem ipsum dolor sit amet consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                </p>
                <p class="text-fiot-gray text-lg leading-relaxed">
                    Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                </p>
            </div>
        </div>

    </x-ui.page>
@endsection