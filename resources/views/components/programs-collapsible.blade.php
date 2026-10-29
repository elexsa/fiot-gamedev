@props([
'degrees' => []
])

<!-- Головний контейнер (Main background: #080809) -->
<div
    x-data="{ activeDegree: null }"
    class="w-full h-full flex flex-col bg-[#080809] text-slate-100 antialiased selection:bg-blue-500/30">

    <!-- Основна область з кастомним скролбаром (#14161C) -->
    <div class="flex flex-col w-full flex-1 p-5 sm:p-7 md:p-9 bg-[#14161C] rounded-xl border border-slate-800/50 shadow-2xl overflow-y-auto custom-scrollbar space-y-6">

        <!-- Головна шапка курсу -->
        <div class="flex items-center justify-between border-b border-slate-800/60 pb-5 shrink-0">
            <h2 class="text-2xl sm:text-3xl font-extrabold tracking-wide flex items-center gap-3">
                <span class="text-fiot-accent drop-shadow-[0_0_10px_rgba(18,230,49,0.4)] text-3xl">🎓</span>
                <span class="bg-gradient-to-r from-slate-50 to-slate-200 bg-clip-text text-transparent">Перелік освітніх програм</span>
            </h2>
        </div>

        <!-- РІВЕНЬ 1: СТУПЕНІ ОСВІТИ -->
        @foreach($degrees as $degreeId => $degreeData)
        <div
            class="border rounded-xl overflow-hidden bg-slate-900/20 border-blue-900/30 transition-all duration-300"
            :class="activeDegree === {{ $degreeId }} ? 'ring-2 ring-blue-500/60 border-blue-500 shadow-[0_0_30px_rgba(37,99,235,0.25)] bg-slate-900/40' : 'hover:border-blue-500/50 hover:shadow-[0_0_20px_rgba(37,99,235,0.15)]'">

            <!-- Кнопка Ступеня -->
            <button
                @click="activeDegree = (activeDegree === {{ $degreeId }} ? null : {{ $degreeId }})"
                class="w-full flex items-center justify-between p-5 sm:p-6 bg-[#080809]/60 text-left focus:outline-none transition-all duration-200"
                type="button">
                <div class="flex items-center gap-4 pr-4">
                    <span class="text-xs font-black uppercase px-2.5 py-1 rounded border tracking-widest shrink-0 transition-colors duration-200"
                        :class="activeDegree === {{ $degreeId }} ? 'bg-blue-500/20 text-blue-400 border-blue-500/40' : 'bg-blue-500/10 text-blue-400/80 border-blue-500/20'">
                        Рівень {{ $degreeData['degree_level'] }}
                    </span>
                    <span class="text-lg sm:text-xl font-bold tracking-wide transition-colors duration-200"
                        :class="activeDegree === {{ $degreeId }} ? 'text-blue-400' : 'text-slate-100'">
                        {{ $degreeData['degree_name'] }}
                    </span>
                </div>

                <!-- Індикатор ступеня -->
                <div class="w-8 h-8 rounded-lg flex items-center justify-center border transition-all duration-300 shrink-0"
                    :class="activeDegree === {{ $degreeId }} ? 'border-blue-500 text-blue-400 rotate-45 bg-blue-500/10' : 'border-slate-800 bg-[#14161C] text-slate-400'">
                    <span class="text-lg font-medium">＋</span>
                </div>
            </button>

            <!-- Контент Ступеня -->
            <div
                x-show="activeDegree === {{ $degreeId }}"
                x-collapse
                x-cloak>

                <!-- РІВЕНЬ 2: НАВЧАЛЬНІ РОКИ -->
                <div x-data="{ activeYear: null }" class="p-4 sm:p-5 bg-slate-950/40 border-t border-slate-800/60 space-y-4">

                    @foreach($degreeData['academic_years'] as $academicYear => $programs)
                    @php
                    $yearLoopId = 'year_' . $degreeId . '_' . $loop->iteration;
                    @endphp

                    <div
                        class="border rounded-lg overflow-hidden bg-[#080809]/40 transition-all duration-300"
                        :class="activeYear === '{{ $yearLoopId }}' ? 'border-fiot-accent shadow-[0_0_18px_rgba(18,230,49,0.15)] bg-[#080809]/80' : 'border-slate-800/80 hover:border-fiot-accent/50 hover:shadow-[0_0_12px_rgba(18,230,49,0.06)]'">

                        <!-- Кнопка Навчального Року -->
                        <button
                            @click="activeYear = (activeYear === '{{ $yearLoopId }}' ? null : '{{ $yearLoopId }}')"
                            class="w-full flex items-start sm:items-center justify-between p-4.5 bg-[#080809]/20 hover:bg-slate-900/30 transition-all text-left focus:outline-none"
                            type="button">
                            <!-- UI/UX: Підсвітка всього рядка при виборі -->
                            <span class="text-base sm:text-lg transition-colors duration-200 flex items-center gap-2"
                                :class="activeYear === '{{ $yearLoopId }}' ? 'text-fiot-accent font-bold' : 'text-slate-200'">
                                <span class="text-xs uppercase tracking-wide font-normal transition-colors" :class="activeYear === '{{ $yearLoopId }}' ? 'text-fiot-accent/80' : 'text-slate-400'">📅 Навчальний період:</span>
                                <span>{{ $academicYear }}</span>
                            </span>

                            <!-- Стрілка року -->
                            <div class="w-7 h-7 rounded-md flex items-center justify-center shrink-0 border transition-all duration-300"
                                :class="activeYear === '{{ $yearLoopId }}' ? 'border-fiot-accent bg-fiot-accent/10 text-fiot-accent' : 'border-slate-800 bg-slate-900 text-slate-400'">
                                <svg class="w-4 h-4 transition-transform duration-300" :class="{ 'rotate-180': activeYear === '{{ $yearLoopId }}' }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </button>

                        <!-- Контент Навчального Року (Випадаючий список Програм) -->
                        <div
                            x-show="activeYear === '{{ $yearLoopId }}'"
                            x-collapse
                            x-cloak
                            class="border-t border-slate-800/60">

                            <!-- РІВЕНЬ 3: ПРОГРАМИ НАВЧАННЯ -->
                            <div x-data="{ activeProgram: null }" class="p-4.5 bg-slate-950/20 space-y-3">
                                <span class="text-xs font-bold uppercase tracking-wider text-slate-200 block mb-1">
                                    Доступні освітні програми та напрями:
                                </span>

                                @foreach($programs as $program)
                                <div
                                    class="border rounded-lg overflow-hidden bg-[#14161C]/50 transition-all duration-300"
                                    :class="activeProgram === {{ $program['id'] }} ? 'border-fiot-accent shadow-[0_0_15px_rgba(18,230,49,0.12)] bg-[#14161C]' : 'border-slate-800/60 hover:border-fiot-accent/40 hover:shadow-[0_0_10px_rgba(18,230,49,0.04)]'">

                                    <!-- Кнопка Програми -->
                                    <button
                                        @click="activeProgram = (activeProgram === {{ $program['id'] }} ? null : {{ $program['id'] }})"
                                        class="w-full flex items-center justify-between p-4 text-left focus:outline-none transition-colors duration-150 hover:bg-[#080809]/40"
                                        type="button">
                                        <span class="text-sm sm:text-base font-semibold flex items-center gap-2.5 transition-colors duration-200"
                                            :class="activeProgram === {{ $program['id'] }} ? 'text-fiot-accent' : 'text-slate-200'">
                                            <span class="text-fiot-accent text-sm transition-opacity shrink-0" :class="activeProgram === {{ $program['id'] }} ? 'opacity-100' : 'opacity-60'">📖</span>
                                            {{ $program['name'] }}
                                        </span>

                                        <!-- Маленька стрілочка програми -->
                                        <svg class="w-4 h-4 transition-transform duration-200 shrink-0 ml-2"
                                            :class="activeProgram === {{ $program['id'] }} ? 'rotate-180 text-fiot-accent' : 'text-slate-400'"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </button>

                                    <!-- Тіло Програми -->
                                    <div x-show="activeProgram === {{ $program['id'] }}" x-collapse x-cloak>
                                        <template x-if="activeProgram === {{ $program['id'] }}">
                                            <div class="p-5 text-sm sm:text-base bg-[#080809]/40 border-t border-slate-800/40 space-y-4 leading-relaxed">

                                                @if(!empty($program['description']))
                                                <p class="text-slate-100 font-normal text-[15px] leading-relaxed">{{ $program['description'] }}</p>
                                                @endif

                                                <!-- Сітка параметрів програми (Високий контраст) -->
                                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm bg-slate-900/40 p-4 rounded-lg border border-slate-800/60 mt-2">
                                                    <div class="flex items-center gap-2">
                                                        <span class="text-lg">📅</span>
                                                        <span class="text-slate-200 font-semibold">Дата початку:</span>
                                                        <span class="text-white font-bold">{{ $program['start_date'] ?? 'Не вказано' }}</span>
                                                    </div>
                                                    <div class="flex items-center gap-2">
                                                        <span class="text-lg">🏁</span>
                                                        <span class="text-slate-200 font-semibold">Дата завершення:</span>
                                                        <span class="text-white font-bold">{{ $program['end_date'] ?? 'Не вказано' }}</span>
                                                    </div>

                                                    @if(!empty($program['specialty_name']))
                                                    <div class="sm:col-span-2 flex items-center flex-wrap gap-2 pt-2 border-t border-slate-800/40 mt-1">
                                                        <span class="flex items-center gap-2 text-slate-200 font-semibold">
                                                            <span class="text-lg">🔬</span>
                                                            <span>Спеціальність:</span>
                                                        </span>

                                                        @if(!empty($program['specialty_code']))
                                                        <span class="px-2 py-0.5 text-xs font-mono font-bold bg-fiot-accent/20 text-fiot-accent border border-fiot-accent/40 rounded shadow-[0_0_6px_rgba(18,230,49,0.15)]">
                                                            {{ $program['specialty_code'] }}
                                                        </span>
                                                        @endif

                                                        <span class="text-white font-bold">{{ $program['specialty_name'] }}</span>
                                                    </div>
                                                    @endif
                                                </div>

                                                <div class="mt-4 flex justify-end">
                                                    @if(!empty($program['external_link']))
                                                    {{-- Кнопка активна: відкриває зовнішнє посилання у новій вкладці без скачування --}}
                                                    <a
                                                        href="{{ $program['external_link'] }}"
                                                        target="_blank"
                                                        rel="noopener noreferrer"
                                                        class="btn btn-primary btn-lg">
                                                        <span>👁️ Переглянути освітню програму</span>
                                                    </a>
                                                    @else
                                                    {{-- UI/UX: Кнопка повністю вимкнена, якщо посилання порожнє --}}
                                                    <button
                                                        type="button"
                                                        disabled
                                                        class="px-5 py-2.5 bg-slate-800 text-slate-500 font-bold rounded-lg text-sm tracking-wide border border-slate-700/50 cursor-not-allowed flex items-center gap-2 select-none">
                                                        <span>🚫 Інформація відсутня</span>
                                                    </button>
                                                    @endif
                                                </div>

                                            </div>
                                        </template>
                                    </div>

                                </div>
                                @endforeach

                            </div>
                        </div>
                    </div>
                    @endforeach

                </div>
            </div>
        </div>
        @endforeach

    </div>
</div>