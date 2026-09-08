@extends('layouts.app')

@section('title', 'Кафедра ігрових систем | ФІОТ КПІ')

@section('meta_description', 'Кафедра ігрових систем ФІОТ КПІ ім. Ігоря Сікорського. Освітня програма «Розробка комп’ютерних ігор»: ігрові рушії, комп’ютерна графіка, ШІ та системна інженерія.')

@section('content')
<main class="flex flex-col relative overflow-hidden">
    
    <section class="min-h-[calc(100vh-80px)] flex items-center relative px-6 py-12 justify-center flex-col overflow-hidden">
        <div class="absolute inset-0 pointer-events-none opacity-[0.04] bg-[radial-gradient(circle,white_1px,transparent_1px)] bg-[length:40px_40px]"></div>
        
        <div class="container mx-auto flex flex-col lg:flex-row items-center justify-between gap-12 z-10 my-auto">
            <div class="w-full lg:w-1/2 flex flex-col justify-center gap-8 text-center lg:text-left">
                <x-ui.badge color="neutral" class="mx-auto lg:mx-0 w-max">Освітня програма «Розробка комп’ютерних ігор»</x-ui.badge>
                <h1 class="text-white text-5xl md:text-7xl font-bold tracking-tight leading-[1.05] max-w-lg mx-auto lg:mx-0">
                    Ігрові<br>системи
                </h1>
                <p class="text-fiot-gray text-lg leading-relaxed max-w-lg mx-auto lg:mx-0">
                    Кафедра ФІОТ КПІ. Готуємо інженерів, які створюють комп'ютерні ігри — від рушія до релізу.
                </p>
                <div class="flex flex-col sm:flex-row gap-6 mt-4 justify-center lg:justify-start w-full max-w-lg mx-auto lg:mx-0">
                    <x-ui.button href="{{ route('admission') }}" variant="primary" size="lg">Вступнику</x-ui.button>
                    <x-ui.button href="{{ route('disciplines') }}" variant="secondary" size="lg">Студенту</x-ui.button>
                </div>
            </div>

            <div class="w-full lg:w-1/2 h-[400px] lg:h-[500px] flex items-center justify-center relative z-10">
                <model-viewer 
                    src="{{ asset('models/cool_fice_frog.glb') }}" 
                    alt="Cyber frog"
                    auto-rotate
                    rotation-per-second="15deg"
                    camera-controls
                    disable-zoom
                    shadow-intensity="1.5"
                    class="w-full h-full outline-none">
                </model-viewer>
            </div>
        </div>
        
        <div class="absolute bottom-0 left-0 w-full h-48 bg-gradient-to-t from-[#080809] to-transparent pointer-events-none z-20"></div>
    </section>

    <section class="relative z-10 py-20 md:py-28 px-6 bg-gradient-to-b from-[#080809] to-[#14161C]">
        <div class="container mx-auto grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">

            <div>
                <div class="border-l-2 border-fiot-accent pl-5">
                    <p class="text-sm text-fiot-gray mb-3">Про кафедру</p>
                    <h3 class="text-white text-3xl md:text-4xl font-bold tracking-tight mb-2">Хто ми</h3>
                </div>
                <p class="text-fiot-gray text-lg leading-relaxed mb-6 mt-6">
                    Кафедра готує фахівців за спеціальністю <strong class="text-white">121 «Інженерія програмного забезпечення»</strong> в межах освітньої програми «Розробка комп'ютерних ігор».
                </p>
                <p class="text-fiot-gray text-lg leading-relaxed">
                    Глибока математика, комп'ютерна графіка та системне програмування на базі ФІОТ.
                </p>
            </div>

            <div class="h-[350px] bg-[#080809]/40 border border-white/10 rounded-2xl flex items-center justify-center relative overflow-hidden shadow-2xl">
                <div class="absolute inset-0 opacity-10 bg-[linear-gradient(45deg,#4D11CC_1px,transparent_1px)] bg-[length:20px_20px]"></div>
                <span class="text-sm text-fiot-gray z-10">[Render: Raytracing Engine]</span>
            </div>

        </div>
    </section>

    <section class="relative z-10 py-20 md:py-28 px-6 border-t border-white/5">
        <div class="container mx-auto grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
            <div class="h-[400px] bg-fiot-dark/40 border border-white/10 rounded-2xl relative flex items-center justify-center overflow-hidden">
                <div class="absolute inset-0 opacity-10 bg-[linear-gradient(to_right,#4D11CC_1px,transparent_1px),linear-gradient(to_bottom,#4D11CC_1px,transparent_1px)] bg-[length:30px_30px]"></div>
                <span class="text-sm text-fiot-gray z-10">Корпус 18 — буде додано фото</</span>
                <div class="absolute bottom-6 left-6 font-bold tracking-widest text-sm z-10">КОРПУС 18</div>
            </div>
            <div>
                <div class="border-l-2 border-fiot-accent pl-5">
                    <p class="text-sm text-fiot-gray mb-3">Кампус</p>
                    <h3 class="text-white text-3xl md:text-4xl font-bold tracking-tight mb-2">Фізична база кафедри</h3>
                </div>
                <p class="text-fiot-gray text-lg leading-relaxed">
                    Ми знаходимося в серці технічного університету — легендарному 18-му корпусі ФІОТ.
                </p>
            </div>
        </div>
    </section>

    {{-- Статистика --}}
    <section class="relative z-10 py-16 px-6 border-t border-white/5 bg-[#0b0c0f]">
        <div class="container mx-auto grid grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach (config('content.stats') as $stat)
                <x-ui.stat :value="$stat['value']" :label="$stat['label']" />
            @endforeach
        </div>
    </section>

    {{-- Останні новини --}}
    <section class="relative z-10 py-20 md:py-28 px-6 border-t border-white/5">
        <div class="container mx-auto max-w-screen-xl">

            <div class="flex flex-col md:flex-row justify-between md:items-end gap-4 mb-12">
                <div class="max-w-2xl">
                    <div class="border-l-2 border-fiot-accent pl-5">
                        <p class="text-sm text-fiot-gray mb-3">Новини кафедри</p>
                        <h3 class="text-white text-3xl md:text-4xl font-bold tracking-tight mb-2">Останні новини</h3>
                    </div>
                    <p class="text-fiot-gray">Події, оновлення та досягнення кафедри й освітньої програми.</p>
                </div>
                <x-ui.button href="{{ route('news') }}" variant="outline" size="md" class="group">
                    Усі новини
                    <x-ui.icon name="arrow-right" class="w-3 h-3 ml-2 transition-transform group-hover:translate-x-1" />
                </x-ui.button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach ($latestNews as $item)
                    <x-ui.card :href="route('news.article', $item)" interactive class="group p-6">
                        <div class="flex items-center justify-between mb-4">
                            <x-ui.badge>{{ $item->tag }}</x-ui.badge>
                            <time class="text-sm text-fiot-gray" datetime="{{ $item->published_at->toDateString() }}">
                                {{ $item->published_at->translatedFormat('d.m.Y') }}
                            </time>
                        </div>
                        <h4 class="text-white font-bold mb-3 group-hover:text-fiot-accent transition-colors">{{ $item->title }}</h4>
                        <p class="text-gray-400 text-sm leading-relaxed flex-1">{{ $item->excerpt }}</p>
                    </x-ui.card>
                @endforeach
            </div>

        </div>
    </section>

</main>
@endsection
