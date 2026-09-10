@extends('layouts.app')

@section('title', 'Силабуси | Студентам')

@section('meta_description', 'Каталог дисциплін і силабусів: фільтри за програмою, курсом, семестром, викладачем.')

@section('content')
<x-ui.page>
    <x-ui.page-header title="Силабуси" kicker="Студентам" subtitle="Каталог дисциплін: фільтруй за програмою, курсом, семестром або викладачем." />

    <div class="flex flex-wrap items-center gap-3 mb-8">
        <x-ui.button href="{{ route('syllabuses') }}" variant="primary" size="sm">Силабуси</x-ui.button>
        <x-ui.button href="{{ route('syllabuses.diagram') }}" variant="outline" size="sm">Діаграма дисциплін</x-ui.button>
        <x-ui.button href="{{ route('syllabuses.diagram', ['mode' => 'skill']) }}" variant="outline" size="sm">Дерево навичок</x-ui.button>
    </div>

    <form method="GET" action="{{ route('syllabuses') }}" class="bg-fiot-dark/40 border border-white/10 rounded-2xl p-5 md:p-6 mb-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <label class="flex flex-col gap-2 text-sm">
            <span class="text-fiot-gray uppercase tracking-widest text-[11px] font-bold">Дисципліна / викладач</span>
            <input type="text" name="q" value="{{ $filters['q'] }}" placeholder="Назва або викладач" class="bg-[#0b0c0f] border border-white/10 rounded-xl px-4 py-2.5 text-white placeholder:text-fiot-gray/60 focus:border-fiot-accent/60 outline-none">
        </label>
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
            <span class="text-fiot-gray uppercase tracking-widest text-[11px] font-bold">Курс</span>
            <select name="course" class="bg-[#0b0c0f] border border-white/10 rounded-xl px-4 py-2.5 text-white focus:border-fiot-accent/60 outline-none">
                <option value="">Всі курси</option>
                @foreach ($courses as $course)
                    <option value="{{ $course }}" @selected((string) $filters['course'] === (string) $course)>{{ $course }} курс</option>
                @endforeach
            </select>
        </label>
        <label class="flex flex-col gap-2 text-sm">
            <span class="text-fiot-gray uppercase tracking-widest text-[11px] font-bold">Семестр</span>
            <select name="semester" class="bg-[#0b0c0f] border border-white/10 rounded-xl px-4 py-2.5 text-white focus:border-fiot-accent/60 outline-none">
                <option value="">Всі семестри</option>
                @foreach ($semesters as $semester)
                    <option value="{{ $semester }}" @selected((string) $filters['semester'] === (string) $semester)>{{ $semester }} семестр</option>
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
            <span class="text-fiot-gray uppercase tracking-widest text-[11px] font-bold">Форма навчання</span>
            <select name="study_form" class="bg-[#0b0c0f] border border-white/10 rounded-xl px-4 py-2.5 text-white focus:border-fiot-accent/60 outline-none">
                <option value="">Всі форми</option>
                @foreach ($studyForms as $form)
                    <option value="{{ $form }}" @selected($filters['study_form'] === $form)>{{ $form }}</option>
                @endforeach
            </select>
        </label>
        <label class="flex flex-col gap-2 text-sm">
            <span class="text-fiot-gray uppercase tracking-widest text-[11px] font-bold">Навчальний рік</span>
            <select name="academic_year" class="bg-[#0b0c0f] border border-white/10 rounded-xl px-4 py-2.5 text-white focus:border-fiot-accent/60 outline-none">
                <option value="">Всі роки</option>
                @foreach ($academicYears as $year)
                    <option value="{{ $year }}" @selected($filters['academic_year'] === $year)>{{ $year }}</option>
                @endforeach
            </select>
        </label>
        <div class="flex items-end gap-3">
            <button type="submit" class="btn btn-primary btn-md flex-1">Фільтрувати</button>
            <a href="{{ route('syllabuses') }}" class="btn btn-outline btn-md">Скинути</a>
        </div>
    </form>

    <p class="text-sm text-fiot-gray mb-4">Знайдено: {{ $found }}</p>

    <div class="overflow-x-auto bg-fiot-dark/40 border border-white/10 rounded-2xl mb-20">
        <table class="w-full text-sm min-w-[760px]">
            <thead>
                <tr class="text-left text-fiot-gray uppercase tracking-widest text-[11px]">
                    <th class="px-5 py-4 font-bold">Дисципліна</th>
                    <th class="px-5 py-4 font-bold">Цикл</th>
                    <th class="px-5 py-4 font-bold">Кредити / години</th>
                    <th class="px-5 py-4 font-bold">Викладач</th>
                    <th class="px-5 py-4 font-bold text-right">Силабус</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($disciplines as $disc)
                    <tr class="border-t border-white/10 hover:bg-white/5 transition-colors">
                        <td class="px-5 py-4">
                            <div class="text-white font-bold">{{ $disc->name }}</div>
                            <div class="text-xs text-fiot-gray mt-1 flex flex-wrap gap-2">
                                @if ($disc->program)<span>{{ $disc->program->name }}</span>@endif
                                @if ($disc->course)<span>{{ $disc->course }} курс</span>@endif
                                @if ($disc->semester)<span>{{ $disc->semester }} семестр</span>@endif
                                @if ($disc->is_elective)<span class="text-fiot-accent">вибіркова</span>@endif
                            </div>
                        </td>
                        <td class="px-5 py-4 text-gray-400">{{ $disc->cycle ?? '—' }}</td>
                        <td class="px-5 py-4 text-gray-400 whitespace-nowrap">{{ $disc->credits ? $disc->credits . ' ЄКТС' : '—' }}{{ $disc->hours ? ' · ' . $disc->hours . ' год' : '' }}</td>
                        <td class="px-5 py-4 text-gray-400">{{ $disc->teacher ?? '—' }}</td>
                        <td class="px-5 py-4 text-right whitespace-nowrap">
                            @if ($disc->syllabus_file)
                                <a href="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($disc->syllabus_file) }}" target="_blank" class="inline-flex items-center gap-1 text-fiot-accent hover:text-white transition-colors">Силабус <x-ui.icon name="arrow-right" class="w-3 h-3" /></a>
                            @elseif ($disc->syllabus_url)
                                <a href="{{ $disc->syllabus_url }}" target="_blank" class="inline-flex items-center gap-1 text-fiot-accent hover:text-white transition-colors">Силабус <x-ui.icon name="arrow-right" class="w-3 h-3" /></a>
                            @else
                                <span class="text-fiot-gray/60">—</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr class="border-t border-white/10">
                        <td colspan="5" class="px-5 py-8 text-center text-fiot-gray">Нічого не знайдено. Змініть фільтри або додайте дисципліни в адмін-панелі.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-ui.page>
@endsection
