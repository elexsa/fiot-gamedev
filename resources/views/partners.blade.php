@extends('layouts.app')

@section('title', 'Партнери | Кафедра ігрових систем')

@section('meta_description', 'Індустріальні партнери кафедри ігрових систем ФІОТ КПІ: менторство, стажування та працевлаштування для студентів.')

@section('content')
<x-ui.page>
    <x-ui.page-header title="Партнери" kicker="[INDUSTRY_NETWORK]" subtitle="Компанії, з якими ми співпрацюємо. Менторство, стажування та працевлаштування для студентів." />

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-20">
            
            <a href="https://kyiv.ubisoft.com/" target="_blank" class="group flex flex-col bg-fiot-dark/40 border border-white/10 rounded-2xl overflow-hidden hover:border-fiot-accent/40 hover:-translate-y-1 hover:shadow-[0_12px_40px_rgba(0,0,0,0.45)] transition-all duration-300">
                <div class="h-32 flex items-center justify-center bg-[#111115] border-b border-[#2a2a35] group-hover:bg-[#16161a] transition-colors p-8 relative overflow-hidden">
                    <img src="{{ asset('images/logos/ubisoft.png') }}" alt="Ubisoft" class="max-h-full max-w-full object-contain grayscale opacity-40 group-hover:grayscale-0 group-hover:opacity-100 transition-all duration-500 relative z-10">
                </div>
                <div class="p-6 flex-1 flex flex-col">
                    <h3 class="text-white font-bold text-xl mb-2">Ubisoft Kyiv</h3>
                    <p class="text-gray-400 text-sm leading-relaxed mb-6 flex-1">Розробка ААА-проєктів світового рівня. Менторство зі створення ігрових рушіїв та C++ програмування.</p>
                    <div class="text-[10px] text-gray-500 font-mono uppercase tracking-widest flex items-center gap-2 mt-auto group-hover:text-white transition-colors">
                        Відвідати сайт 
                        <svg class="w-3 h-3 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </div>
                </div>
            </a>

            <a href="https://gen.tech/" target="_blank" class="group flex flex-col bg-fiot-dark/40 border border-white/10 rounded-2xl overflow-hidden hover:border-fiot-accent/40 hover:-translate-y-1 hover:shadow-[0_12px_40px_rgba(0,0,0,0.45)] transition-all duration-300">
                <div class="h-32 flex items-center justify-center bg-[#111115] border-b border-[#2a2a35] group-hover:bg-[#16161a] transition-colors p-8 relative overflow-hidden">
                    <img src="{{ asset('images/logos/genesis.png') }}" alt="Genesis" class="max-h-full max-w-full object-contain grayscale opacity-40 group-hover:grayscale-0 group-hover:opacity-100 transition-all duration-500 relative z-10">
                </div>
                <div class="p-6 flex-1 flex flex-col">
                    <h3 class="text-white font-bold text-xl mb-2">Genesis</h3>
                    <p class="text-gray-400 text-sm leading-relaxed mb-6 flex-1">Продуктове ІТ та створення мобільних ігор. Можливості стажування через Genesis IT School та профільні хакатони.</p>
                    <div class="text-[10px] text-gray-500 font-mono uppercase tracking-widest flex items-center gap-2 mt-auto group-hover:text-white transition-colors">
                        Відвідати сайт 
                        <svg class="w-3 h-3 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </div>
                </div>
            </a>

            <a href="https://sigma.software/" target="_blank" class="group flex flex-col bg-fiot-dark/40 border border-white/10 rounded-2xl overflow-hidden hover:border-fiot-accent/40 hover:-translate-y-1 hover:shadow-[0_12px_40px_rgba(0,0,0,0.45)] transition-all duration-300">
                <div class="h-32 flex items-center justify-center bg-[#111115] border-b border-[#2a2a35] group-hover:bg-[#16161a] transition-colors p-8 relative overflow-hidden">
                    <img src="{{ asset('images/logos/sigma-software.png') }}" alt="Sigma Software" class="max-h-full max-w-full object-contain grayscale opacity-40 group-hover:grayscale-0 group-hover:opacity-100 transition-all duration-500 relative z-10">
                </div>
                <div class="p-6 flex-1 flex flex-col">
                    <h3 class="text-white font-bold text-xl mb-2">Sigma Software</h3>
                    <p class="text-gray-400 text-sm leading-relaxed mb-6 flex-1">Експертиза у сферах AR/VR та GameDev аутсорсу. Спільні навчальні кемпи для студентів ФІОТ.</p>
                    <div class="text-[10px] text-gray-500 font-mono uppercase tracking-widest flex items-center gap-2 mt-auto group-hover:text-white transition-colors">
                        Відвідати сайт 
                        <svg class="w-3 h-3 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </div>
                </div>
            </a>

            <a href="https://macpaw.com/uk" target="_blank" class="group flex flex-col bg-fiot-dark/40 border border-white/10 rounded-2xl overflow-hidden hover:border-fiot-accent/40 hover:-translate-y-1 hover:shadow-[0_12px_40px_rgba(0,0,0,0.45)] transition-all duration-300">
                <div class="h-32 flex items-center justify-center bg-[#111115] border-b border-[#2a2a35] group-hover:bg-[#16161a] transition-colors p-8 relative overflow-hidden">
                    <img src="{{ asset('images/logos/macpaw.png') }}" alt="MacPaw" class="max-h-full max-w-full object-contain grayscale opacity-40 group-hover:grayscale-0 group-hover:opacity-100 transition-all duration-500 relative z-10">
                </div>
                <div class="p-6 flex-1 flex flex-col">
                    <h3 class="text-white font-bold text-xl mb-2">MacPaw</h3>
                    <p class="text-gray-400 text-sm leading-relaxed mb-6 flex-1">Продуктова компанія екосистеми Apple. Підтримка студентських ініціатив та програми MacPaw Internship.</p>
                    <div class="text-[10px] text-gray-500 font-mono uppercase tracking-widest flex items-center gap-2 mt-auto group-hover:text-white transition-colors">
                        Відвідати сайт 
                        <svg class="w-3 h-3 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </div>
                </div>
            </a>

            <a href="https://careers.epam.ua/" target="_blank" class="group flex flex-col bg-fiot-dark/40 border border-white/10 rounded-2xl overflow-hidden hover:border-fiot-accent/40 hover:-translate-y-1 hover:shadow-[0_12px_40px_rgba(0,0,0,0.45)] transition-all duration-300">
                <div class="h-32 flex items-center justify-center bg-[#111115] border-b border-[#2a2a35] group-hover:bg-[#16161a] transition-colors p-8 relative overflow-hidden">
                    <img src="{{ asset('images/logos/epam.png') }}" alt="EPAM" class="max-h-full max-w-full object-contain grayscale opacity-40 group-hover:grayscale-0 group-hover:opacity-100 transition-all duration-500 relative z-10">
                </div>
                <div class="p-6 flex-1 flex flex-col">
                    <h3 class="text-white font-bold text-xl mb-2">EPAM Systems</h3>
                    <p class="text-gray-400 text-sm leading-relaxed mb-6 flex-1">Один з найбільших гравців IT-ринку України. Доступ до програм EPAM University Programs та лабораторій.</p>
                    <div class="text-[10px] text-gray-500 font-mono uppercase tracking-widest flex items-center gap-2 mt-auto group-hover:text-white transition-colors">
                        Відвідати сайт 
                        <svg class="w-3 h-3 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </div>
                </div>
            </a>

            <a href="https://fraglab.com/" target="_blank" class="group flex flex-col bg-fiot-dark/40 border border-white/10 rounded-2xl overflow-hidden hover:border-fiot-accent/40 hover:-translate-y-1 hover:shadow-[0_12px_40px_rgba(0,0,0,0.45)] transition-all duration-300">
                <div class="h-32 flex items-center justify-center bg-[#111115] border-b border-[#2a2a35] group-hover:bg-[#16161a] transition-colors p-8 relative overflow-hidden">
                    <img src="{{ asset('images/logos/fraglab.png') }}" alt="Frag Lab" class="max-h-full max-w-full object-contain grayscale opacity-40 group-hover:grayscale-0 group-hover:opacity-100 transition-all duration-500 relative z-10">
                </div>
                <div class="p-6 flex-1 flex flex-col">
                    <h3 class="text-white font-bold text-xl mb-2">Frag Lab</h3>
                    <p class="text-gray-400 text-sm leading-relaxed mb-6 flex-1">Київська студія з розробки next-gen шутерів (Shatterline). Спеціалісти з Amazon Lumberyard та ігрової архітектури.</p>
                    <div class="text-[10px] text-gray-500 font-mono uppercase tracking-widest flex items-center gap-2 mt-auto group-hover:text-white transition-colors">
                        Відвідати сайт 
                        <svg class="w-3 h-3 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </div>
                </div>
            </a>

        </div>
    </x-ui.page>
@endsection