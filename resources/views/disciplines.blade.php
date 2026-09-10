@extends('layouts.app')

@section('title', 'Дисципліни')

@section('meta_description', 'Дисципліни освітньої програми «Розробка комп’ютерних ігор» кафедри ігрових систем ФІОТ КПІ — інтерактивне дерево навичок.')

@section('content')

<section class="relative z-10 pt-16 md:pt-24 min-h-screen flex flex-col">
    <div class="container mx-auto max-w-screen-2xl px-4 md:px-8 relative z-10 flex-shrink-0">
        <x-ui.page-header title="Дерево Навичок" kicker="Освітня програма" subtitle="Етапи підготовки спеціаліста. Наведіть на вузол, щоб підсвітити зв'язки. Shift + Scroll для прокрутки." />
    </div>

    {{-- Мобільна версія: вертикальний таймлайн --}}
    <div class="block lg:hidden container mx-auto px-4 pb-20 mt-4">
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
    <div class="hidden lg:block w-full flex-grow relative overflow-x-auto blueprint-scroll border-y border-[#2a2a35] z-20 bg-[#050508] blueprint-bg">

        <div id="workspace" class="relative min-w-[1300px] h-[750px] p-12 mx-auto flex justify-center items-center">

            <svg id="svg-lines" class="absolute inset-0 w-full h-full pointer-events-none z-0"></svg>

            <div id="nodes-container" class="relative flex gap-16 xl:gap-24 z-10 w-full max-w-[1200px] mx-auto">

                @foreach ($levels as $level => $group)
                    <div class="flex flex-col justify-center gap-10 relative w-64 {{ $level % 2 === 0 ? 'pt-6' : '' }}">
                        <div class="absolute -top-6 text-sm text-fiot-gray border-b border-white/10 w-full pb-1">Рівень {{ $level }}: {{ [1 => 'Фундамент', 2 => 'Ядро логіки', 3 => 'Ігрові системи', 4 => 'Майстерність'][$level] ?? 'Спеціалізація' }}</div>

                        @foreach ($group as $disc)
                            <div id="disc-{{ $disc->id }}" class="skill-node bg-[#111115] {{ $disc->is_boss ? 'border border-[#555] shadow-[0_0_20px_rgba(255,255,255,0.05)] relative z-20' : 'border border-[#333] shadow-lg' }} rounded transition-transform hover:-translate-y-1">
                                <div class="bg-[#1a1a24] px-3 py-1.5 {{ $disc->is_boss ? 'border-l-4 border-purple-500 text-white flex justify-between' : 'border-l-4 border-fiot-primary text-fiot-gray' }}">
                                    <span>{{ $disc->category }}</span>
                                    @if ($disc->is_boss)<span class="text-red-400 animate-pulse">Бос</span>@endif
                                </div>
                                <div class="p-4">
                                    <h3 class="{{ $disc->category === 'Ядро GameDev' ? 'text-fiot-accent' : 'text-white' }} font-bold text-sm mb-1">{{ $disc->name }}</h3>
                                    <p class="text-gray-500 text-[10px] leading-tight">{{ $disc->description }}</p>
                                    @if ($disc->syllabus_file || $disc->syllabus_url)
                                        <a href="{{ $disc->syllabus_file ? asset($disc->syllabus_file) : $disc->syllabus_url }}" target="_blank" class="inline-flex items-center gap-1 mt-3 text-sm text-fiot-accent hover:text-white transition-colors">
                                            Силабус
                                            <x-ui.icon name="arrow-right" class="w-3 h-3" />
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endforeach

            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script>
    // JS працює тільки для десктопу (lg+)
    if (window.innerWidth >= 1024) {
        const connections = @json($connections);

        const svg = document.getElementById('svg-lines');
        const workspace = document.getElementById('workspace');
        let pathElements = [];

        function drawConnections() {
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
@endsection
