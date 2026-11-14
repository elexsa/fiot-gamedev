@extends('layouts.app')

@section('title', 'Силабуси')

@section('meta_description', 'Каталог дисциплін і силабусів: фільтри за програмою, курсом, семестром, викладачем.')

@section('content')
<x-ui.page>
    <x-ui.page-header title="Силабуси" subtitle="Каталог освітніх дисциплін та силабусів." />

    <!-- Стильне спливаюче сповіщення (Toast) -->
    <div
        x-data="{ show: false, message: '' }"
        @toast.window="message = $event.detail.message; show = true; setTimeout(() => show = false, 3000)"
        x-show="show"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4 scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
        x-transition:leave-end="opacity-0 translate-y-4 scale-95"
        class="fixed bottom-6 right-6 z-50 bg-[#0b0c0f]/95 border border-emerald-500/30 text-white px-4 py-3.5 rounded-2xl shadow-2xl flex items-center gap-3 backdrop-blur-xl"
        style="display: none;">
        <div class="w-7 h-7 rounded-xl bg-emerald-500/20 border border-emerald-500/40 flex items-center justify-center text-emerald-400 flex-shrink-0 shadow-inner">
            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
            </svg>
        </div>
        <span class="text-xs font-semibold text-gray-200 tracking-wide" x-text="message"></span>
    </div>

    <div x-data="{
            isLoadingList: false,
            searchController: null,

            init() {
                window.addEventListener('popstate', () => {
                    this.syncFormWithUrl(window.location.search);
                    this.fetchDisciplines(window.location.href, false);
                });
            },

            syncFormWithUrl(searchQuery) {
                const params = new URLSearchParams(searchQuery);
                const form = document.getElementById('filters-form');
                if (!form) return;

                form.querySelectorAll('input[type=&quot;text&quot;], input[type=&quot;hidden&quot;], select').forEach(el => {
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
                    
                    for (const [key, value] of params.entries()) {
                        if (!value || !value.trim()) {
                            params.delete(key);
                        }
                    }

                    const queryString = params.toString();
                    url = `{{ route('syllabuses') }}${queryString ? '?' + queryString : ''}`;
                } else {
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
                form.querySelectorAll('input[type=&quot;text&quot;], input[type=&quot;hidden&quot;], select').forEach(el => el.value = '');
                this.fetchDisciplines('{{ route('syllabuses') }}', true);
            }
        }"
        class="space-y-6">

        <form id="filters-form" method="GET" action="{{ route('syllabuses') }}"
            @submit.prevent="fetchDisciplines()"
            class="bg-fiot-dark/40 border border-white/10 rounded-2xl p-4 sm:p-5 md:p-6 shadow-xl backdrop-blur-md">

            <input type="hidden" name="syllabus_id" value="{{ $filters['syllabus_id'] ?? request('syllabus_id') }}">

            <div class="mb-4">
                <label class="flex flex-col gap-2 text-sm">
                    <span class="text-fiot-gray uppercase tracking-widest text-[11px] font-bold">Пошук дисципліни або викладача</span>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-fiot-gray">
                            <svg class="w-4 h-4 text-fiot-gray" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607z" />
                            </svg>
                        </span>
                        <input type="text" name="q" value="{{ $filters['q'] ?? '' }}"
                            placeholder="Введіть назву дисципліни чи ПІБ викладача..."
                            class="w-full bg-[#0b0c0f] border border-white/10 rounded-xl pl-11 pr-4 py-3 text-white placeholder:text-fiot-gray/40 focus:border-fiot-accent/60 outline-none transition-colors text-sm">
                    </div>
                </label>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-5">
                <label class="flex flex-col gap-2 text-sm">
                    <span class="text-fiot-gray uppercase tracking-widest text-[11px] font-bold">Освітня програма</span>
                    <select name="program_id" class="bg-[#0b0c0f] border border-white/10 rounded-xl px-4 py-2.5 text-white focus:border-fiot-accent/60 outline-none transition-colors text-sm cursor-pointer">
                        <option value="">Всі програми</option>
                        @foreach ($programs as $program)
                        @php
                        $progId = is_object($program) ? ($program->id ?? '') : $program;
                        $progName = is_object($program) ? ($program->name ?? '') : $program;
                        $progYear = is_object($program) ? ($program->academic_year ?? '') : '';
                        @endphp
                        <option value="{{ $progId }}" @selected((string) ($filters['program_id'] ?? '' )===(string) $progId)>
                            {{ $progName }} {{ $progYear ? '('.$progYear.')' : '' }}
                        </option>
                        @endforeach
                    </select>
                </label>

                <label class="flex flex-col gap-2 text-sm">
                    <span class="text-fiot-gray uppercase tracking-widest text-[11px] font-bold">Курс</span>
                    <select name="year_of_study_id" class="bg-[#0b0c0f] border border-white/10 rounded-xl px-4 py-2.5 text-white focus:border-fiot-accent/60 outline-none transition-colors text-sm cursor-pointer">
                        <option value="">Всі курси</option>
                        @foreach ($yearsOfStudy as $year)
                        @php
                        $yId = is_object($year) ? ($year->id ?? '') : $year;
                        $yName = is_object($year) ? ($year->name ?? '') : $year;
                        @endphp
                        <option value="{{ $yId }}" @selected((string) ($filters['year_of_study_id'] ?? '' )===(string) $yId)>{{ $yName }}</option>
                        @endforeach
                    </select>
                </label>

                <label class="flex flex-col gap-2 text-sm">
                    <span class="text-fiot-gray uppercase tracking-widest text-[11px] font-bold">Семестр</span>
                    <select name="semester_id" class="bg-[#0b0c0f] border border-white/10 rounded-xl px-4 py-2.5 text-white focus:border-fiot-accent/60 outline-none transition-colors text-sm cursor-pointer">
                        <option value="">Всі семестри</option>
                        @foreach ($semesters as $semester)
                        @php
                        $sId = is_object($semester) ? ($semester->id ?? '') : $semester;
                        $sName = is_object($semester) ? ($semester->name ?? '') : $semester;
                        @endphp
                        <option value="{{ $sId }}" @selected((string) ($filters['semester_id'] ?? '' )===(string) $sId)>{{ $sName }}</option>
                        @endforeach
                    </select>
                </label>

                <label class="flex flex-col gap-2 text-sm">
                    <span class="text-fiot-gray uppercase tracking-widest text-[11px] font-bold">Освітній рівень</span>
                    <select name="degree_id" class="bg-[#0b0c0f] border border-white/10 rounded-xl px-4 py-2.5 text-white focus:border-fiot-accent/60 outline-none transition-colors text-sm cursor-pointer">
                        <option value="">Всі рівні</option>
                        @foreach ($degrees as $degree)
                        @php
                        $dId = is_object($degree) ? ($degree->id ?? '') : $degree;
                        $dName = is_object($degree) ? ($degree->name ?? '') : $degree;
                        @endphp
                        <option value="{{ $dId }}" @selected((string) ($filters['degree_id'] ?? '' )===(string) $dId)>{{ $dName }}</option>
                        @endforeach
                    </select>
                </label>

                <label class="flex flex-col gap-2 text-sm">
                    <span class="text-fiot-gray uppercase tracking-widest text-[11px] font-bold">Форма навчання</span>
                    <select name="mode_of_study_id" class="bg-[#0b0c0f] border border-white/10 rounded-xl px-4 py-2.5 text-white focus:border-fiot-accent/60 outline-none transition-colors text-sm cursor-pointer">
                        <option value="">Всі форми</option>
                        @foreach ($studyForms as $form)
                        @php
                        $fId = is_object($form) ? ($form->id ?? '') : $form;
                        $fName = is_object($form) ? ($form->name ?? '') : $form;
                        @endphp
                        <option value="{{ $fId }}" @selected((string) ($filters['mode_of_study_id'] ?? '' )===(string) $fId)>{{ $fName }}</option>
                        @endforeach
                    </select>
                </label>

                <label class="flex flex-col gap-2 text-sm">
                    <span class="text-fiot-gray uppercase tracking-widest text-[11px] font-bold">Навчальний період</span>
                    <select name="academic_year" class="bg-[#0b0c0f] border border-white/10 rounded-xl px-4 py-2.5 text-white focus:border-fiot-accent/60 outline-none transition-colors text-sm cursor-pointer">
                        <option value="">Всі періоди</option>
                        @foreach ($academicYears as $year)
                        <option value="{{ $year }}" @selected(($filters['academic_year'] ?? '' )===$year)>{{ $year }}</option>
                        @endforeach
                    </select>
                </label>
            </div>

            <div class="flex flex-col sm:flex-row items-center justify-end gap-3 pt-4 border-t border-white/5">
                <button type="button" @click="resetFilters()" :disabled="isLoadingList" class="btn btn-outline btn-md w-full sm:w-auto text-center cursor-pointer disabled:opacity-50">Скинути</button>
                <button type="submit" :disabled="isLoadingList" class="btn btn-primary btn-md w-full sm:w-auto text-center cursor-pointer relative disabled:opacity-75">
                    <span :class="{ 'opacity-0': isLoadingList }">Застосувати</span>
                    <span x-show="isLoadingList" class="absolute inset-0 flex items-center justify-center">
                        <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </span>
                </button>
            </div>
        </form>

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