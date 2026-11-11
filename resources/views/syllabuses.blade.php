@extends('layouts.app')

@section('title', 'Силабуси')

@section('meta_description', 'Каталог дисциплін і силабусів: фільтри за програмою, курсом, семестром, викладачем.')

@section('content')
<x-ui.page>
    <x-ui.page-header title="Силабуси" subtitle="Каталог освітніх дисциплін та силабусів." />

    <!-- Загальний контейнер Alpine.js для форми та результатів -->
    <div x-data="{
            isLoadingList: false,
            searchController: null,

            init() {
                // Повна синхронізація при навігації стрілками Назад / Вперед у браузері
                window.addEventListener('popstate', () => {
                    this.syncFormWithUrl(window.location.search);
                    this.fetchDisciplines(window.location.href, false);
                });
            },

            // Синхронізація значень форми з поточним URL
            syncFormWithUrl(searchQuery) {
                const params = new URLSearchParams(searchQuery);
                const form = document.getElementById('filters-form');
                if (!form) return;

                form.querySelectorAll('input[type=&quot;text&quot;], select').forEach(el => {
                    const name = el.name;
                    if (name) {
                        el.value = params.get(name) || '';
                    }
                });
            },

            async fetchDisciplines(customUrl = null, pushState = true) {
                if (this.searchController) {
                    this.searchController.abort();
                }
                this.searchController = new AbortController();

                this.isLoadingList = true;

                let url = customUrl;
                if (!url) {
                    const form = document.getElementById('filters-form');
                    const formData = new FormData(form);
                    const params = new URLSearchParams(formData);
                    
                    // Видаляємо пусті параметри для чистоти URL
                    for (const [key, value] of params.entries()) {
                        if (!value.trim()) {
                            params.delete(key);
                        }
                    }

                    const queryString = params.toString();
                    url = `{{ route('syllabuses') }}${queryString ? '?' + queryString : ''}`;
                } else {
                    // Якщо запит йде з пагінації, синхронізуємо форму з параметрами цього URL
                    const urlObj = new URL(customUrl, window.location.origin);
                    this.syncFormWithUrl(urlObj.search);
                }

                try {
                    const response = await fetch(url, {
                        signal: this.searchController.signal,
                        headers: { 
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-Partial-Render': 'true'
                        }
                    });
                    if (response.ok) {
                        const html = await response.text();
                        document.getElementById('syllabuses-results-container').innerHTML = html;
                        if (pushState) {
                            window.history.pushState({ path: url }, '', url);
                        }
                    }
                } catch (error) {
                    if (error.name !== 'AbortError') {
                        console.error('Помилка оновлення списку дисциплін:', error);
                    }
                } finally {
                    this.isLoadingList = false;
                }
            },

            resetFilters() {
                const form = document.getElementById('filters-form');
                form.reset();
                form.querySelectorAll('input[type=&quot;text&quot;], select').forEach(el => el.value = '');
                this.fetchDisciplines('{{ route('syllabuses') }}', true);
            }
        }" 
        class="space-y-6">

        <!-- Форма фільтрів -->
        <form id="filters-form" method="GET" action="{{ route('syllabuses') }}" 
              @submit.prevent="fetchDisciplines()"
              class="bg-fiot-dark/40 border border-white/10 rounded-2xl p-4 sm:p-5 md:p-6 shadow-xl backdrop-blur-md">

            @if(request()->has('syllabus_id'))
            <input type="hidden" name="syllabus_id" value="{{ request('syllabus_id') }}">
            @endif

            <!-- Пошуковий рядок із debounce -->
            <div class="mb-4">
                <label class="flex flex-col gap-2 text-sm">
                    <span class="text-fiot-gray uppercase tracking-widest text-[11px] font-bold">Пошук дисципліни або викладача</span>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-fiot-gray">
                            <svg class="w-4 h-4 text-fiot-gray" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607z" />
                            </svg>
                        </span>
                        <input type="text" name="q" value="{{ $filters['q'] }}" 
                               @input.debounce.300ms="fetchDisciplines()"
                               placeholder="Введіть назву дисципліни чи ПІБ викладача..." 
                               class="w-full bg-[#0b0c0f] border border-white/10 rounded-xl pl-11 pr-4 py-3 text-white placeholder:text-fiot-gray/40 focus:border-fiot-accent/60 outline-none transition-colors text-sm">
                    </div>
                </label>
            </div>

            <!-- Сітка параметрів фільтрації -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-5">
                <label class="flex flex-col gap-2 text-sm">
                    <span class="text-fiot-gray uppercase tracking-widest text-[11px] font-bold">Освітня програма</span>
                    <select name="program_id" @change="fetchDisciplines()" class="bg-[#0b0c0f] border border-white/10 rounded-xl px-4 py-2.5 text-white focus:border-fiot-accent/60 outline-none transition-colors text-sm cursor-pointer">
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
                    <select name="year_of_study_id" @change="fetchDisciplines()" class="bg-[#0b0c0f] border border-white/10 rounded-xl px-4 py-2.5 text-white focus:border-fiot-accent/60 outline-none transition-colors text-sm cursor-pointer">
                        <option value="">Всі курси</option>
                        @foreach ($yearsOfStudy as $year)
                        <option value="{{ $year->id }}" @selected((string) $filters['year_of_study_id']===(string) $year->id)>{{ $year->name }}</option>
                        @endforeach
                    </select>
                </label>

                <label class="flex flex-col gap-2 text-sm">
                    <span class="text-fiot-gray uppercase tracking-widest text-[11px] font-bold">Семестр</span>
                    <select name="semester_id" @change="fetchDisciplines()" class="bg-[#0b0c0f] border border-white/10 rounded-xl px-4 py-2.5 text-white focus:border-fiot-accent/60 outline-none transition-colors text-sm cursor-pointer">
                        <option value="">Всі семестри</option>
                        @foreach ($semesters as $semester)
                        <option value="{{ $semester->id }}" @selected((string) $filters['semester_id']===(string) $semester->id)>{{ $semester->name }}</option>
                        @endforeach
                    </select>
                </label>

                <label class="flex flex-col gap-2 text-sm">
                    <span class="text-fiot-gray uppercase tracking-widest text-[11px] font-bold">Освітній рівень</span>
                    <select name="degree_id" @change="fetchDisciplines()" class="bg-[#0b0c0f] border border-white/10 rounded-xl px-4 py-2.5 text-white focus:border-fiot-accent/60 outline-none transition-colors text-sm cursor-pointer">
                        <option value="">Всі рівні</option>
                        @foreach ($degrees as $degree)
                        <option value="{{ $degree->id }}" @selected((string) $filters['degree_id']===(string) $degree->id)>{{ $degree->name }}</option>
                        @endforeach
                    </select>
                </label>

                <label class="flex flex-col gap-2 text-sm">
                    <span class="text-fiot-gray uppercase tracking-widest text-[11px] font-bold">Форма навчання</span>
                    <select name="mode_of_study_id" @change="fetchDisciplines()" class="bg-[#0b0c0f] border border-white/10 rounded-xl px-4 py-2.5 text-white focus:border-fiot-accent/60 outline-none transition-colors text-sm cursor-pointer">
                        <option value="">Всі форми</option>
                        @foreach ($studyForms as $form)
                        <option value="{{ $form->id }}" @selected((string) $filters['mode_of_study_id']===(string) $form->id)>{{ $form->name }}</option>
                        @endforeach
                    </select>
                </label>

                <label class="flex flex-col gap-2 text-sm">
                    <span class="text-fiot-gray uppercase tracking-widest text-[11px] font-bold">Навчальний період</span>
                    <select name="academic_year" @change="fetchDisciplines()" class="bg-[#0b0c0f] border border-white/10 rounded-xl px-4 py-2.5 text-white focus:border-fiot-accent/60 outline-none transition-colors text-sm cursor-pointer">
                        <option value="">Всі періоди</option>
                        @foreach ($academicYears as $year)
                        <option value="{{ $year }}" @selected($filters['academic_year']===$year)>{{ $year }}</option>
                        @endforeach
                    </select>
                </label>
            </div>

            <!-- Дії форми -->
            <div class="flex flex-col sm:flex-row items-center justify-end gap-3 pt-4 border-t border-white/5">
                <button type="button" @click="resetFilters()" class="btn btn-outline btn-md w-full sm:w-auto text-center cursor-pointer">Скинути</button>
                <button type="submit" class="btn btn-primary btn-md w-full sm:w-auto text-center cursor-pointer">Застосувати</button>
            </div>
        </form>

        <!-- Динамічний контейнер результатів таблиці та пагінації -->
        <div id="syllabuses-results-container" class="relative transition-opacity duration-200" :class="{ 'opacity-50 pointer-events-none': isLoadingList }">
            @include('partials.syllabuses-table-content', [
                'filters' => $filters,
                'disciplines' => $disciplines,
                'perPageOptions' => $perPageOptions
            ])
        </div>
    </div>
</x-ui.page>
@endsection