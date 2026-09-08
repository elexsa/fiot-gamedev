@extends('layouts.app')

@section('title', 'Про кафедру | F2 GameDev')

@section('meta_description', 'Про кафедру розробки комп’ютерних ігор ФІОТ КПІ: історія, місія, викладацький склад та матеріально-технічна база.')

@section('content')
<section class="relative z-10 pt-16 md:pt-24 min-h-screen flex flex-col pb-20">
    <div class="container mx-auto max-w-screen-xl px-4 md:px-8 relative z-10">

        <div class="mb-12 md:mb-16 border-l-4 border-white pl-4 md:pl-6">
            <h1 class="text-3xl md:text-5xl lg:text-6xl font-bold tracking-tighter mb-2 text-white uppercase">
                Про кафедру
            </h1>
            <p class="text-gray-400 max-w-2xl text-[10px] md:text-xs lg:text-sm font-mono">
                [PLAYER_HANDBOOK] // Хто ми, чому нас варто обрати та хто проведе вас по грі.
            </p>
        </div>

        {{-- Історія та місія --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 mb-20">

            <div class="reveal-on-scroll">
                <h2 class="text-xl font-bold text-white mb-6 uppercase tracking-widest flex items-center gap-3">
                    <span class="w-2 h-2 bg-fiot-accent rounded-sm shadow-[0_0_8px_rgba(18,230,49,0.8)]"></span>
                    Наша місія
                </h2>
                <p class="text-fiot-gray text-lg leading-relaxed mb-6">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ми готуємо інженерів, здатних проєктувати та створювати ігри світового рівня — від низькорівневої графіки до цілісного геймдизайну.
                </p>
                <p class="text-fiot-gray text-lg leading-relaxed">
                    Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Поєднання фундаментальної інженерної освіти КПІ з практичним досвідом індустріальних партнерів.
                </p>
            </div>

            <div class="reveal-on-scroll relative">
                <div class="h-[300px] bg-[#080809]/40 border border-fiot-dark rounded-xl flex items-center justify-center relative overflow-hidden shadow-2xl">
                    <div class="absolute inset-0 opacity-10 bg-[linear-gradient(45deg,#4D11CC_1px,transparent_1px)] bg-[length:20px_20px]"></div>
                    <span class="text-fiot-gray/50 text-xs font-mono uppercase tracking-widest z-10">[IMAGE: Команда кафедри]</span>
                </div>
            </div>

        </div>

        {{-- Цифри --}}
        <div class="reveal-on-scroll grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-20">
            @foreach (config('content.stats') as $stat)
                <div class="bg-[#0b0c0f] border border-[#2a2a35] rounded-xl p-6 md:p-8 text-center hover:border-fiot-primary/50 transition-colors">
                    <div class="text-3xl md:text-4xl font-bold text-white tracking-tighter mb-2">{{ $stat['value'] }}</div>
                    <div class="text-[10px] md:text-xs text-gray-500 font-mono uppercase tracking-widest">{{ $stat['label'] }}</div>
                </div>
            @endforeach
        </div>

        {{-- Викладачі --}}
        <div class="reveal-on-scroll mb-12">
            <h2 class="text-xl font-bold text-white mb-2 uppercase tracking-widest flex items-center gap-3">
                <span class="w-2 h-2 bg-fiot-accent rounded-sm shadow-[0_0_8px_rgba(18,230,49,0.8)]"></span>
                Викладацький склад
            </h2>
            <p class="text-gray-400 text-xs font-mono mb-8">// [PARTY_MEMBERS] — ментори, які ведуть вас до фінального боса</p>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                @foreach (config('content.faculty') as $person)
                    <div class="group bg-[#0b0c0f] border border-[#2a2a35] rounded-xl p-6 hover:border-fiot-accent/40 hover:shadow-[0_0_20px_rgba(18,230,49,0.06)] transition-all duration-300">
                        <div class="flex items-start gap-4">
                            <div class="w-14 h-14 shrink-0 rounded-lg border border-[#2a2a35] bg-gradient-to-br from-fiot-primary/20 to-fiot-accent/10 flex items-center justify-center font-bold text-lg text-white/70 group-hover:border-fiot-accent/40 transition-colors">
                                {{ mb_substr($person['name'], 0, 1) }}
                            </div>
                            <div>
                                <h3 class="text-white font-bold mb-1">{{ $person['name'] }}</h3>
                                <p class="text-[10px] text-fiot-accent font-mono uppercase tracking-widest mb-2">{{ $person['role'] }}</p>
                                <p class="text-gray-400 text-xs leading-relaxed">{{ $person['focus'] }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>

        {{-- Матеріальна база --}}
        <div class="reveal-on-scroll grid grid-cols-1 lg:grid-cols-2 gap-16 items-center border-t border-[#2a2a35] pt-16">
            <div class="h-[350px] bg-fiot-dark rounded-xl overflow-hidden border border-fiot-dark relative order-2 lg:order-1 flex items-center justify-center">
                <div class="absolute inset-0 opacity-10 bg-[linear-gradient(to_right,#4D11CC_1px,transparent_1px),linear-gradient(to_bottom,#4D11CC_1px,transparent_1px)] bg-[length:30px_30px]"></div>
                <span class="text-fiot-gray/50 text-xs font-mono uppercase tracking-widest z-10">[IMAGE: Комп'ютерні класи]</span>
            </div>
            <div class="order-1 lg:order-2">
                <h2 class="text-xl font-bold text-white mb-6 uppercase tracking-widest flex items-center gap-3">
                    <span class="w-2 h-2 bg-fiot-accent rounded-sm shadow-[0_0_8px_rgba(18,230,49,0.8)]"></span>
                    Матеріально-технічна база
                </h2>
                <p class="text-fiot-gray text-lg leading-relaxed mb-6">
                    Lorem ipsum dolor sit amet: сучасні комп'ютерні класи з ліцензійним ПЗ, лабораторії розробки та тестування ігор, простір для командних проєктів.
                </p>
                <p class="text-fiot-gray text-lg leading-relaxed">
                    Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                </p>
            </div>
        </div>

    </div>
</section>
@endsection