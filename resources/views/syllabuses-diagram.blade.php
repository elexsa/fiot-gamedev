@extends('layouts.app')

@section('title', 'Діаграма дисциплін | Студентам')

@section('meta_description', 'Діаграма дисциплін за курсами, семестрами та циклами підготовки.')

@section('content')
<x-ui.page>
    <x-ui.page-header title="Діаграма дисциплін" kicker="Студентам" subtitle="Навчальний план очима студента: курси, семестри та цикли." />

    <div class="flex flex-wrap items-center gap-3 mb-8">
        <x-ui.button href="{{ route('syllabuses') }}" variant="outline" size="sm">Силабуси</x-ui.button>
        <x-ui.button href="{{ route('syllabuses.diagram') }}" variant="{{ $filters['mode'] === 'skill' ? 'outline' : 'primary' }}" size="sm">Діаграма дисциплін</x-ui.button>
        <x-ui.button href="{{ route('syllabuses.diagram', ['mode' => 'skill']) }}" variant="{{ $filters['mode'] === 'skill' ? 'primary' : 'outline' }}" size="sm">Дерево навичок</x-ui.button>
    </div>

    <form method="GET" action="{{ route('syllabuses.diagram') }}" class="bg-fiot-dark/40 border border-white/10 rounded-2xl p-5 md:p-6 mb-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        <label class="flex flex-col gap-2 text-sm">
            <span class="text-fiot-gray uppercase tracking-widest text-[11px] font-bold">Освітня програма</span>
            <select name="program_id" class="bg-[#0b0c0f] border border-white/10 rounded-xl px-4 py-2.5 text-white focus:border-fiot-accent/60 outline-none">
                <option value="">Всі програми</option>
                @foreach ($programs as $program)
                    <option value="{{ $program->id }}" @selected((string) $filters['program_id'] === (string) $program->id)>{{ $program->name }}</option>
                @endforeach
            </select>
        </label>
        <label class="flex flex-col gap-2 text-sm">
            <span class="text-fiot-gray uppercase tracking-widest text-[11px] font-bold">Освітній рівень</span>
            <select name="education_level" class="bg-[#0b0c0f] border border-white/10 rounded-xl px-4 py-2.5 text-white focus:border-fiot-accent/60 outline-none">
                <option value="">Всі рівні</option>
                @foreach ($educationLevels as $level)
                    <option value="{{ $level }}" @selected($filters['education_level'] === $level)>{{ $level }}</option>
                @endforeach
            </select>
        </label>
        <label class="flex flex-col gap-2 text-sm">
            <span class="text-fiot-gray uppercase tracking-widest text-[11px] font-bold">Тип діаграми</span>
            <select name="mode" class="bg-[#0b0c0f] border border-white/10 rounded-xl px-4 py-2.5 text-white focus:border-fiot-accent/60 outline-none">
                <option value="courses" @selected($filters['mode'] === 'courses')>Курси</option>
                <option value="cycles" @selected($filters['mode'] === 'cycles')>Цикли</option>
                <option value="skill" @selected($filters['mode'] === 'skill')>Дерево навичок</option>
            </select>
        </label>
        <div class="flex items-end gap-3 lg:col-span-3">
            <button type="submit" class="btn btn-primary btn-md">Застосувати</button>
            <a href="{{ route('syllabuses.diagram') }}" class="btn btn-outline btn-md">Скинути</a>
        </div>
    </form>

    @if ($filters['mode'] === 'skill')
        <p class="text-sm text-fiot-gray mb-6">Ігровий перегляд тих самих дисциплін: наведи на вузол, щоб підсвітити зв'язки. На мобільному — вертикальний таймлайн.</p>

        {{-- Мобільна версія: вертикальний таймлайн --}}
        <div class="block lg:hidden pb-20 mt-4">
            <div class="relative ml-2 md:ml-4">
                <div class="absolute left-[23px] top-6 bottom-6 w-[2px] bg-[#2a2a35] z-0"></div>

                @foreach ($levels as $level => $group)
                    <div class="relative flex items-start gap-6 md:gap-8 mb-12 group z-10">
                        <div class="w-12 h-12 shrink-0 rounded-full border-2 {{ $loop->last ? 'border-fiot-accent bg-[#0b0c0f] text-fiot-accent shadow-[0_0_15px_rgba(18,230,49,0.3)]' : 'border-[#555] bg-[#0b0c0f] text-gray-400' }} flex items-center justify-center font-bold text-lg">
                            {{ str_pad($level, 2, '0', STR_PAD_LEFT) }}
                        </div>
                        <div class="flex-1">
                            <h2 class="text-sm text-fiot-gray mb-4 mt-3">Рівень {{ $level }}: {{ [1 => 'Фундамент', 2 => 'Ядро логіки', 3 => 'Ігрові системи', 4 => 'Майстерність'][$level] ?? 'Спеціалізація' }}</h2>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                @foreach ($group as $disc)
                                    <div class="bg-[#111115] border {{ $disc->is_boss ? 'border-fiot-accent/40 shadow-[0_0_15px_rgba(18,230,49,0.05)]' : 'border-[#2a2a35]' }} p-5 rounded-xl shadow-lg">
                                        <h3 class="text-white font-bold text-sm mb-1 flex justify-between">
                                            {{ $disc->name }}
                                            @if ($disc->is_boss)<span class="text-red-400 text-xs">Бос</span>@endif
                                        </h3>
                                        <p class="text-gray-500 text-xs">{{ $disc->description }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>

        {{-- Десктопна версія: інтерактивне дерево --}}
        <div class="hidden lg:block w-full relative overflow-x-auto blueprint-scroll border border-[#2a2a35] rounded-2xl z-20 bg-[#050508] blueprint-bg mb-20">

            <div id="workspace" class="relative min-w-[1300px] h-[750px] p-12 mx-auto flex justify-center items-center">

                <svg id="svg-lines" class="absolute inset-0 w-full h-full pointer-events-none z-0"></svg>

                <div id="nodes-container" class="relative flex gap-16 xl:gap-24 z-10 w-full max-w-[1200px] mx-auto">

                    @foreach ($levels as $level => $group)
                        <div class="flex flex-col justify-center gap-10 relative w-64 {{ $level % 2 === 0 ? 'pt-6' : '' }}">
                            <div class="absolute -top-6 text-sm text-fiot-gray border-b border-white/10 w-full pb-1">Рівень {{ $level }}: {{ [1 => 'Фундамент', 2 => 'Ядро логіки', 3 => 'Ігрові системи', 4 => 'Майстерність'][$level] ?? 'Спеціалізація' }}</div>

                            @foreach ($group as $disc)
                                <div id="disc-{{ $disc->id }}" class="skill-node relative bg-[#111115] border border-[#333] p-5 rounded-xl shadow-lg transition-all duration-300 hover:scale-[1.03] cursor-pointer">
                                    <div class="flex justify-between items-start gap-2 mb-2">
                                        <h3 class="text-white font-bold text-sm leading-snug">{{ $disc->name }}</h3>
                                        @if ($disc->is_boss)<span class="text-red-400 text-xs shrink-0 font-mono">[BOSS]</span>@endif
                                    </div>
                                    <p class="text-gray-500 text-xs leading-relaxed mb-3">{{ $disc->description }}</p>
                                    <div class="flex flex-wrap gap-1.5 text-[10px]">
                                        @if ($disc->category)<span class="px-2 py-0.5 rounded bg-white/5 border border-white/10 text-gray-400">{{ $disc->category }}</span>@endif
                                        @if ($disc->cycle)<span class="px-2 py-0.5 rounded bg-white/5 border border-white/10 text-gray-400">{{ $disc->cycle }}</span>@endif
                                        @if ($disc->credits)<span class="px-2 py-0.5 rounded bg-white/5 border border-white/10 text-gray-400">{{ $disc->credits }} ЄКТС</span>@endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endforeach

                </div>
            </div>
        </div>
    @elseif ($filters['mode'] === 'cycles')
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-20">
            @forelse ($byCycle as $cycle => $group)
                <x-ui.card class="p-6">
                    <h2 class="text-white font-bold text-lg mb-1">{{ $cycle }}</h2>
                    <p class="text-sm text-fiot-gray mb-4">Дисциплін: {{ $group->count() }}</p>
                    <ul class="space-y-3">
                        @foreach ($group as $disc)
                            <li class="flex items-start justify-between gap-3 border-b border-white/5 pb-3 last:border-0 last:pb-0">
                                <div>
                                    <div class="text-white text-sm font-bold">{{ $disc->name }}</div>
                                    <div class="text-xs text-fiot-gray mt-1">{{ $disc->course ? $disc->course . ' курс' : '' }}{{ $disc->semester ? ' · ' . $disc->semester . ' семестр' : '' }}{{ $disc->credits ? ' · ' . $disc->credits . ' ЄКТС' : '' }}</div>
                                </div>
                                @if ($disc->syllabus_file)
                                    <a href="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($disc->syllabus_file) }}" target="_blank" class="text-xs text-fiot-accent hover:text-white shrink-0 transition-colors">Силабус</a>
                                @elseif ($disc->syllabus_url)
                                    <a href="{{ $disc->syllabus_url }}" target="_blank" class="text-xs text-fiot-accent hover:text-white shrink-0 transition-colors">Силабус</a>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </x-ui.card>
            @empty
                <x-ui.card class="p-6 lg:col-span-2"><p class="text-fiot-gray">Немає дисциплін за цими фільтрами.</p></x-ui.card>
            @endforelse
        </div>
    @else
        <div class="space-y-10 mb-20">
            @forelse ($byCourse as $course => $group)
                <section>
                    <h2 class="text-white font-bold text-xl mb-4">{{ $course ? $course . ' курс' : 'Без курсу' }}</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach ($group->groupBy(fn ($d) => $d->semester ?? 0)->sortKeys() as $semester => $semGroup)
                            <x-ui.card class="p-6">
                                <h3 class="text-fiot-accent font-bold text-sm uppercase tracking-widest mb-4">{{ $semester ? $semester . ' семестр' : 'Без семестру' }} · {{ $semGroup->count() }}</h3>
                                <ul class="space-y-3">
                                    @foreach ($semGroup as $disc)
                                        <li class="border-b border-white/5 pb-3 last:border-0 last:pb-0">
                                            <div class="text-white text-sm font-bold">{{ $disc->name }}</div>
                                            <div class="text-xs text-fiot-gray mt-1">{{ $disc->cycle ?? 'Без циклу' }}{{ $disc->credits ? ' · ' . $disc->credits . ' ЄКТС' : '' }}{{ $disc->hours ? ' · ' . $disc->hours . ' год' : '' }}</div>
                                        </li>
                                    @endforeach
                                </ul>
                            </x-ui.card>
                        @endforeach
                    </div>
                </section>
            @empty
                <x-ui.card class="p-6"><p class="text-fiot-gray">Немає дисциплін за цими фільтрами.</p></x-ui.card>
            @endforelse
        </div>
    @endif
</x-ui.page>
@endsection

@section('scripts')
@if (($filters['mode'] ?? 'courses') === 'skill')
<script>
    if (window.innerWidth >= 1024) {
        const connections = @json($connections);

        const svg = document.getElementById('svg-lines');
        const workspace = document.getElementById('workspace');
        let pathElements = [];

        function drawConnections() {
            if (!svg || !workspace) return;
            svg.innerHTML = '';
            pathElements = [];

            const wsRect = workspace.getBoundingClientRect();

            connections.forEach(([id1, id2]) => {
                const el1 = document.getElementById(id1);
                const el2 = document.getElementById(id2);
                if(!el1 || !el2) return;

                const rect1 = el1.getBoundingClientRect();
                const rect2 = el2.getBoundingClientRect();

                const x1 = rect1.right - wsRect.left;
                const y1 = rect1.top + rect1.height / 2 - wsRect.top;
                const x2 = rect2.left - wsRect.left;
                const y2 = rect2.top + rect2.height / 2 - wsRect.top;

                const offset = Math.abs(x2 - x1) / 2;
                const pathData = `M ${x1} ${y1} C ${x1 + offset} ${y1}, ${x2 - offset} ${y2}, ${x2} ${y2}`;

                const path = document.createElementNS('http://www.w3.org/2000/svg', 'path');
                path.setAttribute('d', pathData);
                path.setAttribute('fill', 'none');
                path.setAttribute('stroke', '#2a2a35');
                path.setAttribute('stroke-width', '2');
                path.classList.add('transition-colors', 'duration-300');

                svg.appendChild(path);
                pathElements.push({ id1, id2, path });
            });
        }

        document.querySelectorAll('.skill-node').forEach(node => {
            node.addEventListener('mouseenter', () => {
                node.classList.add('border-fiot-accent', 'shadow-[0_0_20px_rgba(18,230,49,0.25)]');
                node.classList.remove('border-[#333]');

                pathElements.forEach(p => {
                    if(p.id1 === node.id || p.id2 === node.id) {
                        p.path.setAttribute('stroke', '#12e631');
                        p.path.setAttribute('stroke-width', '3');
                        svg.appendChild(p.path);
                    } else {
                        p.path.setAttribute('stroke', '#15151a');
                    }
                });
            });

            node.addEventListener('mouseleave', () => {
                node.classList.remove('border-fiot-accent', 'shadow-[0_0_20px_rgba(18,230,49,0.25)]');
                node.classList.add('border-[#333]');
                pathElements.forEach(p => {
                    p.path.setAttribute('stroke', '#2a2a35');
                    p.path.setAttribute('stroke-width', '2');
                });
            });
        });

        setTimeout(drawConnections, 100);
        window.addEventListener('resize', drawConnections);
    }
</script>
@endif
@endsection
