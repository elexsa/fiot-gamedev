@extends('layouts.app')

@section('title', 'Силабуси')

@section('meta_description', 'Каталог дисциплін і силабусів: фільтри за програмою, курсом, семестром, викладачем.')

@section('content')
<x-ui.page>
    <x-ui.page-header title="Силабуси" subtitle="Каталог освітніх дисциплін та силабусів." />

    <!-- Фільтри -->
    <form method="GET" action="{{ route('syllabuses') }}" class="bg-fiot-dark/40 border border-white/10 rounded-2xl p-4 sm:p-5 md:p-6 mb-6 shadow-xl backdrop-blur-md">

        <!-- Зберігаємо syllabus_id, якщо він переданий в URL -->
        @if(request()->has('syllabus_id'))
        <input type="hidden" name="syllabus_id" value="{{ request('syllabus_id') }}">
        @endif

        <!-- Пошуковий рядок на повну ширину -->
        <div class="mb-4">
            <label class="flex flex-col gap-2 text-sm">
                <span class="text-fiot-gray uppercase tracking-widest text-[11px] font-bold">Пошук дисципліни або викладача</span>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-fiot-gray">
                        <svg class="w-4 h-4 text-fiot-gray" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607z" />
                        </svg>
                    </span>
                    <input type="text" name="q" value="{{ $filters['q'] }}" placeholder="Введіть назву дисципліни чи прізвище викладача..." class="w-full bg-[#0b0c0f] border border-white/10 rounded-xl pl-11 pr-4 py-3 text-white placeholder:text-fiot-gray/40 focus:border-fiot-accent/60 outline-none transition-colors text-sm">
                </div>
            </label>
        </div>

        <!-- Сітка параметрів фільтрації -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-5">
            <label class="flex flex-col gap-2 text-sm">
                <span class="text-fiot-gray uppercase tracking-widest text-[11px] font-bold">Освітня програма</span>
                <select name="program_id" class="bg-[#0b0c0f] border border-white/10 rounded-xl px-4 py-2.5 text-white focus:border-fiot-accent/60 outline-none transition-colors text-sm">
                    <option value="">Всі програми</option>
                    @foreach ($programs as $program)
                    <option value="{{ $program->id }}" @selected((string) $filters['program_id']===(string) $program->id)>
                        {{ $program->name }} {{ $program->academic_year ? '('.$program->academic_year.')' : '' }}
                    </option>
                    @endforeach
                </select>
            </label>

            <label class="flex flex-col gap-2 text-sm">
                <span class="text-fiot-gray uppercase tracking-widest text-[11px] font-bold">Курс</span>
                <select name="year_of_study_id" class="bg-[#0b0c0f] border border-white/10 rounded-xl px-4 py-2.5 text-white focus:border-fiot-accent/60 outline-none transition-colors text-sm">
                    <option value="">Всі курси</option>
                    @foreach ($yearsOfStudy as $year)
                    <option value="{{ $year->id }}" @selected((string) $filters['year_of_study_id']===(string) $year->id)>{{ $year->name }}</option>
                    @endforeach
                </select>
            </label>

            <label class="flex flex-col gap-2 text-sm">
                <span class="text-fiot-gray uppercase tracking-widest text-[11px] font-bold">Семестр</span>
                <select name="semester_id" class="bg-[#0b0c0f] border border-white/10 rounded-xl px-4 py-2.5 text-white focus:border-fiot-accent/60 outline-none transition-colors text-sm">
                    <option value="">Всі семестри</option>
                    @foreach ($semesters as $semester)
                    <option value="{{ $semester->id }}" @selected((string) $filters['semester_id']===(string) $semester->id)>{{ $semester->name }}</option>
                    @endforeach
                </select>
            </label>

            <label class="flex flex-col gap-2 text-sm">
                <span class="text-fiot-gray uppercase tracking-widest text-[11px] font-bold">Освітній рівень</span>
                <select name="degree_id" class="bg-[#0b0c0f] border border-white/10 rounded-xl px-4 py-2.5 text-white focus:border-fiot-accent/60 outline-none transition-colors text-sm">
                    <option value="">Всі рівні</option>
                    @foreach ($degrees as $degree)
                    <option value="{{ $degree->id }}" @selected((string) $filters['degree_id']===(string) $degree->id)>{{ $degree->name }}</option>
                    @endforeach
                </select>
            </label>

            <label class="flex flex-col gap-2 text-sm">
                <span class="text-fiot-gray uppercase tracking-widest text-[11px] font-bold">Форма навчання</span>
                <select name="mode_of_study_id" class="bg-[#0b0c0f] border border-white/10 rounded-xl px-4 py-2.5 text-white focus:border-fiot-accent/60 outline-none transition-colors text-sm">
                    <option value="">Всі форми</option>
                    @foreach ($studyForms as $form)
                    <option value="{{ $form->id }}" @selected((string) $filters['mode_of_study_id']===(string) $form->id)>{{ $form->name }}</option>
                    @endforeach
                </select>
            </label>

            <label class="flex flex-col gap-2 text-sm">
                <span class="text-fiot-gray uppercase tracking-widest text-[11px] font-bold">Навчальний період</span>
                <select name="academic_year" class="bg-[#0b0c0f] border border-white/10 rounded-xl px-4 py-2.5 text-white focus:border-fiot-accent/60 outline-none transition-colors text-sm">
                    <option value="">Всі періоди</option>
                    @foreach ($academicYears as $year)
                    <option value="{{ $year }}" @selected($filters['academic_year']===$year)>{{ $year }}</option>
                    @endforeach
                </select>
            </label>
        </div>

        <!-- Дії форми -->
        <div class="flex flex-col sm:flex-row items-center justify-end gap-3 pt-4 border-t border-white/5">
            <a href="{{ route('syllabuses') }}" class="btn btn-outline btn-md w-full sm:w-auto text-center">Скинути</a>
            <button type="submit" class="btn btn-primary btn-md w-full sm:w-auto text-center">Застосувати</button>
        </div>
    </form>

    <!-- Лічильник результатів -->
    <div class="flex items-center justify-between mb-4 px-1">
        <p class="text-sm text-fiot-gray">Знайдено дисциплін: <span class="text-white font-bold">{{ $found }}</span></p>
    </div>

    <!-- Таблиця -->
    <div class="overflow-x-auto bg-fiot-dark/40 border border-white/10 rounded-2xl mb-20 shadow-xl">
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
                    <!-- Дисципліна (Назва -> Програма -> Бейдж "Вибіркова" знизу) -->
                    <td class="px-5 sm:px-6 py-5">
                        <div class="flex flex-col gap-1.5 items-start">
                            <div class="text-white font-bold text-base group-hover:text-fiot-accent transition-colors leading-snug">{{ $disc->name }}</div>

                            @if ($disc->program)
                            <div>
                                <!-- Замінили span на анімаційний посилальний тег a -->
                                <a href="{{ url('programs?program_id=' . $disc->program->id) }}" class="inline-block bg-white/5 hover:bg-white/10 border border-white/10 hover:border-fiot-accent/40 text-gray-300 hover:text-white px-2.5 py-1 rounded-md text-xs font-medium leading-relaxed max-w-xs sm:max-w-md whitespace-normal transition-colors">
                                    {{ $disc->program->name }}
                                </a>
                            </div>
                            @endif

                            @if ($disc->is_elective)
                            <div class="mt-0.5">
                                <span class="bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 px-2.5 py-0.5 rounded-full text-[10px] uppercase font-semibold tracking-wider inline-block">
                                    Вибіркова
                                </span>
                            </div>
                            @endif
                        </div>
                    </td>

                    <!-- Параметри навчання (теги з можливістю перенесення) -->
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

                    <!-- Об'єм + Стилізовані дати періоду -->
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

                    <!-- Викладач -->
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

                    <!-- Кнопка силабусу -->
                    <td class="px-5 sm:px-6 py-5 text-right whitespace-nowrap">
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
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-16 text-center">
                        <div class="max-w-md mx-auto space-y-3">
                            <div class="w-12 h-12 rounded-2xl bg-white/5 border border-white/10 flex items-center justify-center mx-auto text-fiot-gray">
                                <svg class="w-6 h-6 text-fiot-gray" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607z" />
                                </svg>
                            </div>
                            <h3 class="text-white font-bold text-lg">Нічого не знайдено</h3>
                            <p class="text-sm text-fiot-gray">Спробуйте змінити параметри пошуку або скинути фільтри.</p>
                            <div class="pt-2">
                                <a href="{{ route('syllabuses') }}" class="btn btn-outline btn-sm">Скинути фільтри</a>
                            </div>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-ui.page>
@endsection