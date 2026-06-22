@extends('layouts.app')

@section('title', 'GameDev | ФІОТ')

@section('content')
<section class="relative pt-12 pb-16 lg:pt-24 lg:pb-32 overflow-hidden border-b border-fiot-dark">
    <div class="container mx-auto px-4 md:px-6">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-8 items-center">
            
            <div class="flex flex-col z-10">
                <header class="mb-8">
                    <h1 class="text-4xl sm:text-5xl md:text-6xl lg:text-[5rem] leading-[1.1] md:leading-[0.9] font-bold uppercase tracking-tighter text-white mb-6 break-words">
                        Програмування <br>
                        <span class="text-fiot-gray">комп'ютерних <br> ігор</span>
                    </h1>
                    <p class="text-lg text-fiot-gray font-body max-w-lg leading-relaxed">
                        Офіційна освітня програма за спеціальністю <strong class="text-white font-bold">121 «Інженерія програмного забезпечення»</strong>. Архітектура рушіїв, комп'ютерна графіка та системне програмування на базі найпотужнішого факультету країни.
                    </p>
                </header>

                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="{{ route('admission') }}" class="inline-flex justify-center items-center px-8 py-4 bg-fiot-primary hover:bg-fiot-primary-hover text-white font-bold uppercase tracking-widest text-sm transition-colors">
                        Вступнику
                    </a>
                    <a href="/disciplines" class="inline-flex justify-center items-center px-8 py-4 border border-fiot-dark hover:border-fiot-gray text-fiot-gray hover:text-white font-bold uppercase tracking-widest text-sm transition-colors">
                        Студенту
                    </a>
                </div>
            </div>

            <div class="relative w-full aspect-square lg:aspect-auto lg:h-[600px] bg-fiot-dark/30 border border-fiot-dark flex items-center justify-center overflow-hidden group">
                <div class="absolute top-4 left-4 text-[10px] text-fiot-gray font-mono uppercase tracking-widest z-20">
                    <span class="text-fiot-accent">SYS_</span> Render Mode: Wireframe<br>
                    <span class="text-fiot-accent">OBJ_</span> FICE_Engine_Core
                </div>
                
                <img src="{{ asset('images/wireframe-render.png') }}" alt="Engine Wireframe" class="w-4/5 h-4/5 object-contain opacity-80 mix-blend-screen transition-transform duration-[20s] group-hover:scale-110 relative z-10">
                
                <div class="absolute inset-0 bg-[linear-gradient(to_right,#14161C_1px,transparent_1px),linear-gradient(to_bottom,#14161C_1px,transparent_1px)] bg-[size:2rem_2rem] opacity-50 z-0"></div>
            </div>

        </div>
    </div>
</section>

<section class="py-16 lg:py-24 border-b border-fiot-dark">
    <div class="container mx-auto px-4 md:px-6">
        
        <header class="mb-12">
            <h2 class="text-xs text-fiot-accent font-bold uppercase tracking-[0.2em] mb-2">Технічна база</h2>
            <h3 class="text-2xl md:text-3xl font-bold uppercase tracking-tight text-white">Інженерний підхід</h3>
        </header>

        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6 auto-rows-fr">
            
            <article class="md:col-span-2 lg:col-span-2 bg-fiot-dark border border-fiot-dark p-8 flex flex-col justify-between hover:border-fiot-primary/50 transition-colors">
                <div>
                    <h4 class="text-[10px] text-fiot-gray font-bold uppercase tracking-widest mb-6 border-b border-fiot-black pb-2">Основний стек</h4>
                    <ul class="space-y-3 font-body">
                        <li class="flex items-center gap-3 text-white">
                            <span class="w-1.5 h-1.5 bg-fiot-primary"></span>
                            <span class="font-bold">C++ / C#</span> — Системна архітектура та логіка
                        </li>
                        <li class="flex items-center gap-3 text-white">
                            <span class="w-1.5 h-1.5 bg-fiot-primary"></span>
                            <span class="font-bold">Unreal Engine 5</span> — AAA-розробка
                        </li>
                        <li class="flex items-center gap-3 text-white">
                            <span class="w-1.5 h-1.5 bg-fiot-primary"></span>
                            <span class="font-bold">HLSL / GLSL</span> — Програмування шейдерів
                        </li>
                    </ul>
                </div>
            </article>

            <article class="bg-fiot-dark border border-fiot-dark p-8 flex flex-col justify-between hover:border-fiot-accent/50 transition-colors relative overflow-hidden">
                <div class="relative z-10">
                    <h4 class="text-[10px] text-fiot-gray font-bold uppercase tracking-widest mb-6 border-b border-fiot-black pb-2">Локація</h4>
                    <div class="text-3xl font-bold text-white mb-1">18 Корпус</div>
                    <div class="text-sm text-fiot-gray font-body">Лабораторії та спеціалізовані комп'ютерні класи ФІОТ.</div>
                </div>
                <div class="absolute -bottom-2 -right-2 text-[5rem] md:-bottom-4 md:-right-4 md:text-[8rem] font-black text-fiot-black select-none pointer-events-none leading-none">18</div>
            </article>

            <article class="bg-fiot-dark border border-fiot-dark p-8 flex flex-col justify-between hover:border-fiot-gray transition-colors">
                <div>
                    <h4 class="text-[10px] text-fiot-gray font-bold uppercase tracking-widest mb-6 border-b border-fiot-black pb-2">Фундамент</h4>
                    <div class="text-lg font-bold text-white mb-2">Математика ігрових світів</div>
                    <div class="text-sm text-fiot-gray font-body">Лінійна алгебра, дискретна математика та фізика як основа для написання власних рушіїв.</div>
                </div>
            </article>

        </div>
    </div>
</section>

<section class="py-16 lg:py-24">
    <div class="container mx-auto px-4 md:px-6">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            
            <div class="border border-fiot-dark bg-fiot-black p-8 md:p-12 flex flex-col justify-between">
                <div>
                    <h2 class="text-2xl md:text-3xl font-bold uppercase tracking-tight text-white mb-6">Вступникам</h2>
                    <ul class="space-y-4 mb-12">
                        <li><a href="#" class="text-fiot-gray hover:text-fiot-primary font-body border-b border-transparent hover:border-fiot-primary transition-all">Правила прийому 2026</a></li>
                        <li><a href="#" class="text-fiot-gray hover:text-fiot-primary font-body border-b border-transparent hover:border-fiot-primary transition-all">Конкурсні предмети та бали</a></li>
                        <li><a href="#" class="text-fiot-gray hover:text-fiot-primary font-body border-b border-transparent hover:border-fiot-primary transition-all">Контакти відбіркової комісії</a></li>
                    </ul>
                </div>
                <a href="{{ route('admission') }}" class="w-full block text-center px-8 py-4 bg-fiot-primary hover:bg-fiot-primary-hover text-white font-bold uppercase tracking-widest text-sm transition-colors">
                    Деталі вступу
                </a>
            </div>

            <div class="border border-fiot-dark bg-fiot-black p-8 md:p-12 flex flex-col justify-between">
                <div>
                    <h2 class="text-2xl md:text-3xl font-bold uppercase tracking-tight text-white mb-6">Студентам</h2>
                    <ul class="space-y-4 mb-12">
                        <li><a href="/disciplines" class="text-fiot-gray hover:text-white font-body border-b border-transparent hover:border-white transition-all">Силабуси (Дерево навичок)</a></li>
                        <li><a href="#" class="text-fiot-gray hover:text-white font-body border-b border-transparent hover:border-white transition-all">Розклад занять</a></li>
                        <li><a href="#" class="text-fiot-gray hover:text-white font-body border-b border-transparent hover:border-white transition-all">Викладацький склад</a></li>
                    </ul>
                </div>
                <a href="/disciplines" class="w-full block text-center px-8 py-4 border border-fiot-dark hover:border-fiot-gray text-fiot-gray hover:text-white font-bold uppercase tracking-widest text-sm transition-colors">
                    Освітній процес
                </a>
            </div>

        </div>
    </div>
</section>
@endsection