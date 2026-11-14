<!-- ІНФОРМАЦІЯ ПРО СТОРІНКИ ТА ВИБІР КІЛЬКОСТІ -->
<div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-4 px-1">
    <div class="text-sm text-fiot-gray">
        @if ($disciplines->total() > 0)
        Показано з <span class="text-white font-bold">{{ $disciplines->firstItem() }}</span>
        по <span class="text-white font-bold">{{ $disciplines->lastItem() }}</span>
        із <span class="text-white font-bold">{{ $disciplines->total() }}</span> дисциплін
        @else
        Знайдено дисциплін: <span class="text-white font-bold">0</span>
        @endif
    </div>

    <!-- Вибір кількості елементів на сторінці -->
    <div class="flex items-center gap-2 text-sm text-fiot-gray">
        <span>Відображати на сторінці:</span>
        <select name="per_page" form="filters-form"
            @change="fetchDisciplines()"
            class="bg-[#0b0c0f] border border-white/10 rounded-lg px-3 py-1.5 text-white focus:border-fiot-accent/60 outline-none transition-colors text-xs cursor-pointer">
            @foreach($perPageOptions as $limit)
            <option value="{{ $limit }}" @selected($filters['per_page']==$limit)>{{ $limit }}</option>
            @endforeach
        </select>
    </div>
</div>

<!-- Таблиця -->
<div class="overflow-x-auto bg-fiot-dark/40 border border-white/10 rounded-2xl mb-6 shadow-xl">
    <table class="w-full text-sm min-w-[800px]">
        <thead>
            <tr class="text-left text-fiot-gray uppercase tracking-widest text-[11px] border-b border-white/10 bg-white/[0.02]">
                <th class="px-5 sm:px-6 py-4 font-bold">Дисципліна / Програма</th>
                <th class="px-5 sm:px-6 py-4 font-bold">Параметри навчання</th>
                <th class="px-5 sm:px-6 py-4 font-bold">Тривалість</th>
                <th class="px-5 sm:px-6 py-4 font-bold">Викладач(-і)</th>
                <th class="px-5 sm:px-6 py-4 font-bold text-right">Силабус</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-white/5">
            @forelse ($disciplines as $disc)
            <tr class="hover:bg-white/[0.03] transition-colors group">
                <td class="px-5 sm:px-6 py-5">
                    <div class="flex flex-col gap-1.5 items-start">
                        <div class="text-white font-bold text-base group-hover:text-fiot-accent transition-colors leading-snug">{{ $disc->name }}</div>
                        @if ($disc->program)
                        <div>
                            @php
                            $program = $disc->program;
                            $isPublished = (bool) $program->is_published;
                            $isExternal = (bool) $program->is_external;
                            $externalLink = trim($program->external_link ?? '');

                            // Формуємо назву програми разом із роками (навчальним періодом)
                            $programDisplayName = $program->name . ($program->academic_year ? ' (' . $program->academic_year . ')' : '');
                            @endphp

                            @if ($isPublished && !$isExternal)
                            {{-- Сценарій 1: Опублікована внутрішня програма (внутрішнє посилання) --}}
                            <a href="{{ url('programs?program_id=' . $program->id) }}"
                                class="inline-block bg-white/5 hover:bg-white/10 border border-white/10 hover:border-fiot-accent/40 text-gray-300 hover:text-white px-2.5 py-1 rounded-md text-xs font-medium leading-relaxed max-w-xs sm:max-w-md whitespace-normal transition-colors">
                                {{ $programDisplayName }}
                            </a>
                            @elseif ($externalLink !== '')
                            {{-- Сценарій 2: Зовнішня програма або наявний зовнішній лінк (зовнішнє посилання) --}}
                            <a href="{{ $externalLink }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="inline-block bg-white/5 hover:bg-white/10 border border-white/10 hover:border-fiot-accent/40 text-gray-300 hover:text-white px-2.5 py-1 rounded-md text-xs font-medium leading-relaxed max-w-xs sm:max-w-md whitespace-normal transition-colors">
                                {{ $programDisplayName }}
                            </a>
                            @else
                            {{-- Сценарій 3: Немає жодного доступного посилання або програма не відповідає умовам --}}
                            <div class="inline-block bg-white/5 border border-white/10 text-gray-300 px-2.5 py-1 rounded-md text-xs font-medium leading-relaxed max-w-xs sm:max-w-md whitespace-normal">
                                <div>{{ $programDisplayName }}</div>
                                <span class="text-[10px] text-fiot-gray/70 italic block mt-0.5">Посилання на освітню програму відсутнє</span>
                            </div>
                            @endif
                        </div>
                        @endif

                        @if ($disc->is_elective)
                        <div class="mt-0.5">
                            <span class="bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 px-2.5 py-0.5 rounded-full text-[10px] uppercase font-semibold tracking-wider inline-block">
                                Вибіркова
                            </span>
                        </div>
                        @endif
                        @if ($program->is_external)
                        <div class="mt-0.5">
                            <span class="bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 px-2.5 py-0.5 rounded-full text-[10px] uppercase font-semibold tracking-wider inline-block">
                                Інша освітня програма
                            </span>
                        </div>
                        @endif
                    </div>
                </td>

                <td class="px-5 sm:px-6 py-5">
                    <div class="flex flex-wrap gap-1.5 items-center max-w-xs">
                        @if ($disc->yearOfStudy)
                        <span class="px-2 py-0.5 rounded bg-white/[0.04] border border-white/10 text-xs text-gray-200 font-medium inline-block">{{ $disc->yearOfStudy->name }}</span>
                        @endif
                        @if ($disc->semester)
                        <span class="px-2 py-0.5 rounded bg-white/[0.04] border border-white/10 text-xs text-gray-400 inline-block">{{ $disc->semester->name }}</span>
                        @endif
                        @if ($disc->program?->degree)
                        <span class="px-2 py-0.5 rounded bg-indigo-500/10 border border-indigo-500/20 text-xs text-indigo-300 inline-block">{{ $disc->program->degree->name }}</span>
                        @endif
                        @if ($disc->modeOfStudy)
                        <span class="px-2 py-0.5 rounded bg-sky-500/10 border border-sky-500/20 text-xs text-sky-300 inline-block">{{ $disc->modeOfStudy->name }}</span>
                        @endif
                    </div>
                </td>

                <td class="px-5 sm:px-6 py-5 whitespace-nowrap">
                    <div class="text-white font-medium text-xs">
                        {{ $disc->credits ? $disc->credits . ' ЄКТС' : '—' }}
                        @if ($disc->hours) <span class="text-fiot-gray">({{ $disc->hours }} год)</span> @endif
                    </div>
                    <div class="mt-1.5">
                        <span class="inline-flex items-center px-2 py-0.5 rounded-md bg-white/[0.03] border border-white/10 font-mono text-[11px] text-gray-300 tracking-widest shadow-inner">
                            {{ $disc->academic_period ?? '—' }}
                        </span>
                    </div>
                </td>

                <td class="px-5 sm:px-6 py-5 text-gray-300 text-xs">
                    @if ($disc->staff->isNotEmpty())
                    <div class="flex flex-col gap-2">
                        @foreach ($disc->staff as $teacher)
                        <a href="{{ url('about?staff_id=' . $teacher->id) }}" class="flex items-center gap-2.5 group/teacher w-fit">
                            @if ($teacher->avatar)
                            <img src="{{ Storage::url($teacher->avatar) }}" alt="{{ trim("{$teacher->last_name} {$teacher->first_name} {$teacher->patronymic}") }}" class="w-7 h-7 rounded-full object-cover border border-white/10 flex-shrink-0 group-hover/teacher:border-fiot-accent transition-colors">
                            @else
                            <div class="w-7 h-7 rounded-full bg-white/5 border border-white/10 flex items-center justify-center text-fiot-gray flex-shrink-0 group-hover/teacher:border-fiot-accent group-hover/teacher:text-white transition-colors">
                                <svg class="w-3.5 h-3.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                </svg>
                            </div>
                            @endif
                            <span class="font-medium text-gray-200 group-hover/teacher:text-fiot-accent transition-colors leading-tight whitespace-normal">
                                {{ trim("{$teacher->last_name} {$teacher->first_name} {$teacher->patronymic}") }}
                            </span>
                        </a>
                        @endforeach
                    </div>
                    @else
                    <span class="text-fiot-gray/40">—</span>
                    @endif
                </td>

                <td class="px-5 sm:px-6 py-5 text-right whitespace-nowrap">
                    <div class="inline-flex items-center gap-2">
                        <!-- Сучасна кнопка копіювання з локальним станом copied -->
                        <div x-data="{ copied: false }" class="inline-flex items-center">
                            <button type="button"
                                @click="
                                    navigator.clipboard.writeText('{{ route('syllabuses', ['syllabus_id' => $disc->id]) }}');
                                    copied = true;
                                    setTimeout(() => copied = false, 2000);
                                    $dispatch('toast', { message: 'Посилання на дисципліну (силабус) успішно скопійовано!' });
                                "
                                class="inline-flex items-center justify-center p-2.5 rounded-xl bg-white/5 hover:bg-white/10 text-gray-400 hover:text-white border border-white/10 hover:border-fiot-accent/40 transition-all duration-200 shadow-sm cursor-pointer group relative"
                                :class="{ 'bg-emerald-500/10 border-emerald-500/40 text-emerald-400': copied }"
                                title="Скопіювати посилання на дисципліну (силабус)">
                                <!-- Іконка скрепки -->
                                <svg x-show="!copied" class="w-4 h-4 transition-transform group-hover:scale-110" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M18.375 12.739l-7.693 7.693a4.5 4.5 0 01-6.364-6.364l10.94-10.94A3 3 0 1119.5 7.372L8.552 18.32" />
                                </svg>
                                <!-- Іконка успіху (зелена галочка) -->
                                <svg x-show="copied" x-cloak class="w-4 h-4 text-emerald-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                </svg>
                            </button>
                        </div>

                        @if ($disc->syllabus_url)
                        <a href="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($disc->syllabus_url) }}" target="_blank" class="inline-flex items-center gap-1.5 bg-indigo-500/10 hover:bg-indigo-600 hover:text-white text-indigo-400 px-3.5 py-2 rounded-xl transition-all duration-200 font-medium text-xs shadow-sm">
                            <span>Силабус</span>
                            <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                            </svg>
                        </a>
                        @else
                        <span class="text-fiot-gray/40">—</span>
                        @endif
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-6 py-16 text-center">
                    <div class="max-w-md mx-auto space-y-3">
                        <div class="w-12 h-12 rounded-2xl bg-white/5 border border-white/10 flex items-center justify-center mx-auto text-fiot-gray">
                            <svg class="w-6 h-6 text-fiot-gray" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                            </svg>
                        </div>
                        <h3 class="text-white font-bold text-lg">Нічого не знайдено</h3>
                        <p class="text-sm text-fiot-gray">Спробуйте змінити параметри пошуку або скинути фільтри.</p>
                        <div class="pt-2">
                            <button type="button" @click="resetFilters()" class="btn btn-outline btn-sm cursor-pointer">Скинути фільтри</button>
                        </div>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- БЛОК ПАГІНАЦІЇ НА ОСНОВІ linkCollection() -->
<div class="flex justify-center items-center mb-20">
    @if ($disciplines->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-center">
        <span class="relative z-0 inline-flex shadow-sm rounded-2xl gap-1.5">
            @foreach ($disciplines->linkCollection() as $link)
            @php
            $label = $link['label'];
            if (str_contains($label, 'Previous') || str_contains($label, '«')) {
            $label = 'Попередня';
            } elseif (str_contains($label, 'Next') || str_contains($label, '»')) {
            $label = 'Наступна';
            }
            @endphp

            @if ($link['url'] === null)
            <span class="relative inline-flex items-center px-3.5 py-2.5 text-xs font-mono font-medium text-fiot-gray bg-slate-900 border border-slate-800 cursor-default rounded-xl select-none">
                {!! $label !!}
            </span>
            @elseif ($link['active'])
            <span class="relative inline-flex items-center px-3.5 py-2.5 text-xs font-mono font-bold text-fiot-white bg-fiot-primary border border-fiot-primary rounded-xl shadow-lg cursor-default select-none">
                {!! $label !!}
            </span>
            @else
            <button type="button"
                @click="fetchDisciplines('{{ $link['url'] }}')"
                class="relative inline-flex items-center px-3.5 py-2.5 text-xs font-mono font-medium text-slate-300 bg-slate-900 border border-slate-800 rounded-xl hover:bg-fiot-primary/20 hover:border-fiot-primary hover:text-fiot-white transition-colors cursor-pointer">
                {!! $label !!}
            </button>
            @endif
            @endforeach
        </span>
    </nav>
    @endif
</div>