@extends('layouts.app')

@section('title', 'Дерево Навичок | F2 GameDev')

@section('content')

<section class="relative z-10 pt-16 md:pt-24 min-h-screen flex flex-col">
    <div class="container mx-auto max-w-screen-2xl px-4 md:px-8 relative z-10 flex-shrink-0">
        <div class="mb-8 md:mb-10 border-l-4 border-white pl-4 md:pl-6 w-max">
            <h1 class="text-3xl md:text-5xl lg:text-6xl font-bold tracking-tighter mb-2 text-white uppercase">
                Дерево Навичок
            </h1>
            <p class="text-gray-400 max-w-2xl text-[10px] md:text-xs lg:text-sm font-mono hidden lg:block">
                [F2_ОПП_2026] // Наведіть на вузол, щоб підсвітити зв'язки. Shift + Scroll для прокрутки.
            </p>
            <p class="text-gray-400 max-w-2xl text-[10px] md:text-xs font-mono lg:hidden">
                [F2_ОПП_2026] // Етапи підготовки спеціаліста
            </p>
        </div>
    </div>

    <div class="block lg:hidden container mx-auto px-4 pb-20 mt-4">
        <div class="relative ml-2 md:ml-4">
            <div class="absolute left-[23px] top-6 bottom-6 w-[2px] bg-[#2a2a35] z-0"></div>

            <div class="relative flex items-start gap-6 md:gap-8 mb-12 group z-10">
                <div class="w-12 h-12 shrink-0 rounded-full border-2 border-[#555] bg-[#0b0c0f] text-gray-400 flex items-center justify-center font-bold text-lg font-mono shadow-lg">
                    01
                </div>
                <div class="flex-1">
                    <h2 class="text-xs text-gray-400 font-mono tracking-widest uppercase mb-4 mt-3">Рівень 1: Фундамент</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="bg-[#111115] border border-[#2a2a35] p-5 rounded-xl shadow-lg">
                            <h3 class="text-white font-bold text-sm mb-1">Дискретна математика</h3>
                            <p class="text-gray-500 text-xs">Графи, логіка, теорія множин.</p>
                        </div>
                        <div class="bg-[#111115] border border-[#2a2a35] p-5 rounded-xl shadow-lg">
                            <h3 class="text-white font-bold text-sm mb-1">Основи програмування</h3>
                            <p class="text-gray-500 text-xs">Синтаксис C++, пам'ять, вказівники.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="relative flex items-start gap-6 md:gap-8 mb-12 group z-10">
                <div class="w-12 h-12 shrink-0 rounded-full border-2 border-[#555] bg-[#0b0c0f] text-gray-400 flex items-center justify-center font-bold text-lg font-mono shadow-lg">
                    02
                </div>
                <div class="flex-1">
                    <h2 class="text-xs text-gray-400 font-mono tracking-widest uppercase mb-4 mt-3">Рівень 2: Ядро логіки</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="bg-[#111115] border border-[#2a2a35] p-5 rounded-xl shadow-lg">
                            <h3 class="text-white font-bold text-sm mb-1">Лінійна алгебра</h3>
                            <p class="text-gray-500 text-xs">Вектори, матриці, трансформації.</p>
                        </div>
                        <div class="bg-[#111115] border border-[#2a2a35] p-5 rounded-xl shadow-lg">
                            <h3 class="text-white font-bold text-sm mb-1">Об'єктно-орієнтоване ПЗ</h3>
                            <p class="text-gray-500 text-xs">Класи, патерни, SOLID.</p>
                        </div>
                        <div class="bg-[#111115] border border-[#2a2a35] p-5 rounded-xl shadow-lg">
                            <h3 class="text-white font-bold text-sm mb-1">Алгоритми та СД</h3>
                            <p class="text-gray-500 text-xs">Оптимізація, дерева, A* пошук.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="relative flex items-start gap-6 md:gap-8 mb-12 group z-10">
                <div class="w-12 h-12 shrink-0 rounded-full border-2 border-[#555] bg-[#0b0c0f] text-gray-400 flex items-center justify-center font-bold text-lg font-mono shadow-lg">
                    03
                </div>
                <div class="flex-1">
                    <h2 class="text-xs text-gray-400 font-mono tracking-widest uppercase mb-4 mt-3">Рівень 3: Ігрові системи</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="bg-[#111115] border border-[#2a2a35] p-5 rounded-xl shadow-lg">
                            <h3 class="text-white font-bold text-sm mb-1">Програмування графіки</h3>
                            <p class="text-gray-500 text-xs">Шейдери, DirectX, GPU.</p>
                        </div>
                        <div class="bg-[#111115] border border-[#2a2a35] p-5 rounded-xl shadow-lg">
                            <h3 class="text-white font-bold text-sm mb-1">Ігрові рушії</h3>
                            <p class="text-gray-400 text-xs">Архітектура рушіїв, фізика.</p>
                        </div>
                        <div class="bg-[#111115] border border-[#2a2a35] p-5 rounded-xl shadow-lg">
                            <h3 class="text-white font-bold text-sm mb-1">Архітектура ПЗ / DevOps</h3>
                            <p class="text-gray-500 text-xs">Мікросервіси, CI/CD, сервери.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="relative flex items-start gap-6 md:gap-8 group z-10">
                <div class="w-12 h-12 shrink-0 rounded-full border-2 border-fiot-accent bg-[#0b0c0f] text-fiot-accent flex items-center justify-center font-bold text-lg font-mono shadow-[0_0_15px_rgba(18,230,49,0.3)]">
                    04
                </div>
                <div class="flex-1">
                    <h2 class="text-xs text-fiot-accent font-mono tracking-widest uppercase mb-4 mt-3">Рівень 4: Майстерність</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="bg-[#111115] border border-fiot-accent/40 p-5 rounded-xl shadow-[0_0_15px_rgba(18,230,49,0.05)] relative overflow-hidden">
                            <h3 class="text-white font-bold text-sm mb-1 flex justify-between relative z-10">
                                Unreal Engine 5 <span class="text-red-400 text-[10px] animate-pulse uppercase">Бос</span>
                            </h3>
                            <p class="text-gray-400 text-xs relative z-10">Проєкти ААА-рівня, Blueprints + C++.</p>
                        </div>
                        <div class="bg-[#111115] border border-[#2a2a35] p-5 rounded-xl shadow-lg">
                            <h3 class="text-white font-bold text-sm mb-1">Військові симулятори</h3>
                            <p class="text-gray-500 text-xs">Симуляція бойових дій, балістика.</p>
                        </div>
                        <div class="bg-[#111115] border border-[#2a2a35] p-5 rounded-xl shadow-lg">
                            <h3 class="text-white font-bold text-sm mb-1">Штучний інтелект (AI)</h3>
                            <p class="text-gray-500 text-xs">Поведінкові дерева, Data Mining.</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>


    <div class="hidden lg:block w-full flex-grow relative overflow-x-auto blueprint-scroll border-y border-[#2a2a35] z-20 bg-[#050508] blueprint-bg">
        
        <div id="workspace" class="relative min-w-[1300px] h-[750px] p-12 mx-auto flex justify-center items-center">
            
            <svg id="svg-lines" class="absolute inset-0 w-full h-full pointer-events-none z-0"></svg>

            <div id="nodes-container" class="relative flex gap-16 xl:gap-24 z-10 w-full max-w-[1200px] mx-auto">
                
                <div class="flex flex-col justify-center gap-16 relative w-64">
                    <div class="absolute -top-6 text-[10px] text-gray-600 font-mono uppercase tracking-widest border-b border-gray-800 w-full pb-1">Рівень 1: Фундамент</div>
                    
                    <div id="node-math" class="skill-node bg-[#111115] border border-[#333] rounded shadow-lg transition-transform hover:-translate-y-1">
                        <div class="bg-[#1a1a24] border-l-4 border-blue-500 px-3 py-1.5 text-[10px] font-mono text-gray-300 uppercase tracking-wider">Математика</div>
                        <div class="p-4">
                            <h3 class="text-white font-bold text-sm mb-1">Дискретна математика</h3>
                            <p class="text-gray-500 text-[10px] leading-tight">Графи, логіка, теорія множин.</p>
                        </div>
                    </div>

                    <div id="node-cpp" class="skill-node bg-[#111115] border border-[#333] rounded shadow-lg transition-transform hover:-translate-y-1">
                        <div class="bg-[#1a1a24] border-l-4 border-blue-500 px-3 py-1.5 text-[10px] font-mono text-gray-300 uppercase tracking-wider">Програмування</div>
                        <div class="p-4">
                            <h3 class="text-white font-bold text-sm mb-1">Основи програмування</h3>
                            <p class="text-gray-500 text-[10px] leading-tight">Синтаксис C++, пам'ять, вказівники.</p>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col justify-center gap-10 relative w-64 pt-6">
                    <div class="absolute -top-6 text-[10px] text-gray-600 font-mono uppercase tracking-widest border-b border-gray-800 w-full pb-1">Рівень 2: Ядро логіки</div>

                    <div id="node-linalg" class="skill-node bg-[#111115] border border-[#333] rounded shadow-lg transition-transform hover:-translate-y-1">
                        <div class="bg-[#1a1a24] border-l-4 border-yellow-500 px-3 py-1.5 text-[10px] font-mono text-gray-300 uppercase tracking-wider">Математика</div>
                        <div class="p-4">
                            <h3 class="text-white font-bold text-sm mb-1">Лінійна алгебра</h3>
                            <p class="text-gray-500 text-[10px] leading-tight">Вектори, матриці, трансформації.</p>
                        </div>
                    </div>

                    <div id="node-oop" class="skill-node bg-[#111115] border border-[#333] rounded shadow-lg transition-transform hover:-translate-y-1">
                        <div class="bg-[#1a1a24] border-l-4 border-yellow-500 px-3 py-1.5 text-[10px] font-mono text-gray-300 uppercase tracking-wider">Інженерія</div>
                        <div class="p-4">
                            <h3 class="text-white font-bold text-sm mb-1">Об'єктно-орієнтоване ПЗ</h3>
                            <p class="text-gray-500 text-[10px] leading-tight">Класи, патерни, SOLID.</p>
                        </div>
                    </div>

                    <div id="node-algo" class="skill-node bg-[#111115] border border-[#333] rounded shadow-lg transition-transform hover:-translate-y-1">
                        <div class="bg-[#1a1a24] border-l-4 border-yellow-500 px-3 py-1.5 text-[10px] font-mono text-gray-300 uppercase tracking-wider">Логіка</div>
                        <div class="p-4">
                            <h3 class="text-white font-bold text-sm mb-1">Алгоритми та СД</h3>
                            <p class="text-gray-500 text-[10px] leading-tight">Оптимізація, дерева, пошук шляху.</p>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col justify-center gap-10 relative w-64">
                    <div class="absolute -top-6 text-[10px] text-gray-600 font-mono uppercase tracking-widest border-b border-gray-800 w-full pb-1">Рівень 3: Ігрові системи</div>

                    <div id="node-graphics" class="skill-node bg-[#111115] border border-[#333] rounded shadow-lg transition-transform hover:-translate-y-1">
                        <div class="bg-[#1a1a24] border-l-4 border-fiot-accent px-3 py-1.5 text-[10px] font-mono text-gray-300 uppercase tracking-wider">Рендер</div>
                        <div class="p-4">
                            <h3 class="text-white font-bold text-sm mb-1">Програмування графіки</h3>
                            <p class="text-gray-500 text-[10px] leading-tight">Шейдери, DirectX, робота з GPU.</p>
                        </div>
                    </div>

                    <div id="node-engine" class="skill-node bg-[#111115] border border-fiot-accent shadow-[0_0_15px_rgba(18,230,49,0.15)] rounded transition-transform hover:-translate-y-1 relative z-20">
                        <div class="bg-[#1a1a24] border-l-4 border-fiot-accent px-3 py-1.5 text-[10px] font-mono text-white uppercase tracking-wider">Ядро GameDev</div>
                        <div class="p-4">
                            <h3 class="text-fiot-accent font-bold text-sm mb-1">Ігрові рушії</h3>
                            <p class="text-gray-400 text-[10px] leading-tight">Базова архітектура рушіїв, фізика.</p>
                        </div>
                    </div>

                    <div id="node-arch" class="skill-node bg-[#111115] border border-[#333] rounded shadow-lg transition-transform hover:-translate-y-1">
                        <div class="bg-[#1a1a24] border-l-4 border-fiot-accent px-3 py-1.5 text-[10px] font-mono text-gray-300 uppercase tracking-wider">Інфраструктура</div>
                        <div class="p-4">
                            <h3 class="text-white font-bold text-sm mb-1">Архітектура ПЗ / DevOps</h3>
                            <p class="text-gray-500 text-[10px] leading-tight">Мікросервіси, CI/CD, сервери.</p>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col justify-center gap-10 relative w-64 pt-6">
                    <div class="absolute -top-6 text-[10px] text-gray-600 font-mono uppercase tracking-widest border-b border-gray-800 w-full pb-1">Рівень 4: Майстерність</div>

                    <div id="node-ue5" class="skill-node bg-[#111115] border border-[#555] rounded shadow-[0_0_20px_rgba(255,255,255,0.05)] transition-transform hover:-translate-y-1">
                        <div class="bg-[#1a1a24] border-l-4 border-purple-500 px-3 py-1.5 text-[10px] font-mono text-white uppercase tracking-wider flex justify-between">
                            <span>Unreal Engine 5</span>
                            <span class="text-red-400 animate-pulse">Бос</span>
                        </div>
                        <div class="p-4">
                            <h3 class="text-white font-bold text-sm mb-1">Розробка ігрових систем</h3>
                            <p class="text-gray-400 text-[10px] leading-tight">Проєкти ААА-рівня, Blueprints + C++.</p>
                        </div>
                    </div>

                    <div id="node-sim" class="skill-node bg-[#111115] border border-[#333] rounded shadow-lg transition-transform hover:-translate-y-1">
                        <div class="bg-[#1a1a24] border-l-4 border-purple-500 px-3 py-1.5 text-[10px] font-mono text-gray-300 uppercase tracking-wider">Спеціалізація</div>
                        <div class="p-4">
                            <h3 class="text-white font-bold text-sm mb-1">Військові симулятори</h3>
                            <p class="text-gray-500 text-[10px] leading-tight">Симуляція бойових дій, фізика балістики.</p>
                        </div>
                    </div>

                    <div id="node-ai" class="skill-node bg-[#111115] border border-[#333] rounded shadow-lg transition-transform hover:-translate-y-1">
                        <div class="bg-[#1a1a24] border-l-4 border-purple-500 px-3 py-1.5 text-[10px] font-mono text-gray-300 uppercase tracking-wider">Інтелект</div>
                        <div class="p-4">
                            <h3 class="text-white font-bold text-sm mb-1">Штучний інтелект (AI)</h3>
                            <p class="text-gray-500 text-[10px] leading-tight">Поведінкові дерева, машинні навчання.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script>
    // JS працює тільки для десктопу (lg+)
    if (window.innerWidth >= 1024) {
        const connections = [
            ['node-math', 'node-linalg'],
            ['node-math', 'node-algo'],
            ['node-cpp', 'node-oop'],
            ['node-cpp', 'node-algo'],
            ['node-linalg', 'node-graphics'],
            ['node-oop', 'node-engine'],
            ['node-oop', 'node-arch'],
            ['node-algo', 'node-engine'],
            ['node-algo', 'node-ai'],
            ['node-engine', 'node-ue5'],
            ['node-engine', 'node-sim'],
            ['node-arch', 'node-sim'],
            ['node-algo', 'node-ai']
        ];

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
                if(node.id !== 'node-engine' && node.id !== 'node-ue5') {
                    node.classList.remove('border-fiot-accent', 'shadow-[0_0_20px_rgba(18,230,49,0.25)]');
                    node.classList.add('border-[#333]');
                }
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