@extends('layouts.app')

@section('title', 'Кафедра ігрових та інтелектуальних систем')

@section('meta_description', 'Кафедра ігрових та інтелектуальних систем ФІОТ КПІ ім. Ігоря Сікорського. Освітня програма «Розробка комп’ютерних ігор»: ігрові рушії, комп’ютерна графіка, ШІ та системна інженерія.')

@section('content')
<main class="flex flex-col relative overflow-hidden">
    
    <section class="min-h-[calc(100vh-80px)] flex items-center relative px-6 py-12 justify-center flex-col overflow-hidden">
        <div class="absolute inset-0 pointer-events-none opacity-[0.04] bg-[radial-gradient(circle,white_1px,transparent_1px)] bg-[length:40px_40px]"></div>
        
        <div class="container mx-auto flex flex-col lg:flex-row items-center justify-between gap-12 z-10 my-auto">
            <div class="w-full lg:w-1/2 flex flex-col justify-center gap-8 text-center lg:text-left">
                <h1 class="text-white text-5xl md:text-7xl font-bold tracking-tight leading-[1.05] max-w-lg mx-auto lg:mx-0">
                    Кафедра ігрових та інтелектуальних систем
                </h1>
                <p class="text-fiot-gray text-lg leading-relaxed max-w-lg mx-auto lg:mx-0">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud
                </p>
                <div class="flex flex-col sm:flex-row gap-6 mt-4 justify-center lg:justify-start w-full max-w-lg mx-auto lg:mx-0">
                    <x-ui.button href="{{ route('about') }}" variant="primary" size="lg">Вступнику</x-ui.button>
                    <x-ui.button href="{{ route('syllabuses') }}" variant="secondary" size="lg">Студенту</x-ui.button>
                </div>
            </div>

            <div class="w-full lg:w-1/2 h-[400px] lg:h-[500px] flex items-center justify-center relative z-10">

                <x-snake />

            </div>
        </div>
        
        <div class="absolute bottom-0 left-0 w-full h-48 bg-gradient-to-t from-[#080809] to-transparent pointer-events-none z-20"></div>
    </section>

    <section class="relative z-10 py-20 md:py-28 px-6 bg-gradient-to-b from-[#080809] to-[#14161C]">
        <div class="container mx-auto grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">

            <div>
                <div class="border-l-2 border-fiot-accent pl-5">
                    <h3 class="text-white text-3xl md:text-4xl font-bold tracking-tight mb-2">Про кафедру</h3>
                </div>
                <p class="text-fiot-gray text-lg leading-relaxed mb-6 mt-6">
                    Кафедра готує фахівців за спеціальністю <strong class="text-white">F2 Інженерія програмного забезпечення</strong> в межах освітньої програми «Розробка комп'ютерних ігор».
                </p>
                <p class="text-fiot-gray text-lg leading-relaxed">
                    Математика, комп'ютерна графіка та програмування, блабабла.
                </p>
            </div>

            <x-ui.placeholder height="h-[350px]" label="[якесь фото]" />

        </div>
    </section>

    <section class="relative z-10 py-20 md:py-28 px-6 border-t border-white/5">
        <div class="container mx-auto grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
            <x-ui.placeholder height="h-[400px]" label="18 Корпус" />
            <div>
                <div class="border-r-2 border-fiot-accent pr-5">
                    <h3 class="text-white text-right text-3xl md:text-4xl font-bold tracking-tight mb-2">Розсташування</h3>
                </div>
                <p class="text-fiot-gray text-lg leading-relaxed text-right">
                    Ми знаходимося в легендарному 18-му корпусі ФІОТ, з дуже гарним вітражем.
                </p>
            </div>
        </div>
    </section>

    {{-- Статистика --}}
    @php $stats = \App\Models\SiteSetting::get('stats', []); @endphp
    @if (!empty($stats))
    <section class="relative z-10 py-16 px-6 border-t border-white/5 bg-[#0b0c0f]">
        <div class="container mx-auto grid grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach ($stats as $stat)
                <x-ui.stat :value="$stat['value']" :label="$stat['label']" />
            @endforeach
        </div>
    </section>
    @endif

    {{-- Останні новини --}}
    <section class="relative z-10 py-20 md:py-28 px-6 border-t border-white/5">
        <div class="container mx-auto max-w-screen-xl">

            <div class="flex flex-col md:flex-row justify-between md:items-end gap-4 mb-12">
                <div class="max-w-2xl">
                    <div class="border-l-2 border-fiot-accent pl-5">
                        <h3 class="text-white text-3xl md:text-4xl font-bold tracking-tight mb-2">Останні новини</h3>
                    </div>
                </div>
                <x-ui.button href="{{ route('news') }}" variant="outline" size="md" class="group">
                    Усі новини
                    <x-ui.icon name="arrow-right" class="w-3 h-3 ml-2 transition-transform group-hover:translate-x-1" />
                </x-ui.button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach ($latestNews as $item)
                    <x-ui.card :href="route('news.article', $item)" interactive class="group p-0 overflow-hidden">
                        @if ($item->cover_image)
                            <div class="h-40 overflow-hidden border-b border-white/10">
                                <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($item->cover_image) }}" alt="{{ $item->title }}" loading="lazy" decoding="async" class="h-full w-full object-cover transition-transform duration-500">
                            </div>
                        @endif
                        <div class="p-6 flex flex-col flex-1">
                            <h4 class="text-white font-bold mb-3 group-hover:text-fiot-accent transition-colors">{{ $item->title }}</h4>
                            <p class="text-gray-400 text-sm leading-relaxed flex-1">{{ $item->excerpt }}</p>

                            <div class="flex items-center justify-between mt-2">
                                <x-ui.badge>{{ $item->tag }}</x-ui.badge>
                                <time class="text-sm text-fiot-gray" datetime="{{ $item->published_at->toDateString() }}">
                                    {{ $item->published_at->translatedFormat('d.m.Y') }}
                                </time>
                            </div>
                        </div>
                    </x-ui.card>
                @endforeach
            </div>

        </div>
    </section>

</main>
@endsection
