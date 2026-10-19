@extends('layouts.app')

@section('title', 'Діаграма дисциплін')

@section('meta_description', 'Діаграма дисциплін за курсами, семестрами та циклами підготовки.')

@section('content')
<x-ui.page>
    <x-ui.page-header title="Діаграма дисциплін" subtitle="Навчальний план." />

    <form method="GET" action="{{ route('syllabuses.diagram') }}" class="bg-fiot-dark/40 border border-white/10 rounded-2xl p-5 md:p-6 mb-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
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
            <span class="text-fiot-gray uppercase tracking-widest text-[11px] font-bold">Освітній рівень</span>
            <select name="education_level" class="bg-[#0b0c0f] border border-white/10 rounded-xl px-4 py-2.5 text-white focus:border-fiot-accent/60 outline-none">
                <option value="">Всі рівні</option>
                @foreach ($educationLevels as $level)
                    <option value="{{ $level }}" @selected($filters['education_level'] === $level)>{{ $level }}</option>
                @endforeach
            </select>
        </label>
        <label class="flex flex-col gap-2 text-sm">
            <span class="text-fiot-gray uppercase tracking-widest text-[11px] font-bold">Тип діаграми</span>
            <select name="mode" class="bg-[#0b0c0f] border border-white/10 rounded-xl px-4 py-2.5 text-white focus:border-fiot-accent/60 outline-none">
                <option value="courses" @selected($filters['mode'] === 'courses')>Курси</option>
                <option value="cycles" @selected($filters['mode'] === 'cycles')>Цикли</option>
                <option value="skill" @selected($filters['mode'] === 'skill')>Дерево навичок</option>
            </select>
        </label>
        <div class="flex items-end gap-3 lg:col-span-3">
            <button type="submit" class="btn btn-primary btn-md">Застосувати</button>
            <a href="{{ route('syllabuses.diagram') }}" class="btn btn-outline btn-md">Скинути</a>
        </div>
    </form>

    @if ($filters['mode'] === 'skill')
        @include('disciplines._skill-tree')
    @elseif ($filters['mode'] === 'cycles')
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-20">
            @forelse ($byCycle as $cycle => $group)
                <x-ui.card class="p-6">
                    <h2 class="text-white font-bold text-lg mb-1">{{ $cycle }}</h2>
                    <p class="text-sm text-fiot-gray mb-4">Дисциплін: {{ $group->count() }}</p>
                    <ul class="space-y-3">
                        @foreach ($group as $disc)
                            <li class="flex items-start justify-between gap-3 border-b border-white/5 pb-3 last:border-0 last:pb-0">
                                <div>
                                    <div class="text-white text-sm font-bold">{{ $disc->name }}</div>
                                    <div class="text-xs text-fiot-gray mt-1">{{ $disc->course ? $disc->course . ' курс' : '' }}{{ $disc->semester ? ' · ' . $disc->semester . ' семестр' : '' }}{{ $disc->credits ? ' · ' . $disc->credits . ' ЄКТС' : '' }}</div>
                                </div>
                                @if ($disc->syllabus_file)
                                    <a href="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($disc->syllabus_file) }}" target="_blank" class="text-xs text-fiot-accent hover:text-white shrink-0 transition-colors">Силабус</a>
                                @elseif ($disc->syllabus_url)
                                    <a href="{{ $disc->syllabus_url }}" target="_blank" class="text-xs text-fiot-accent hover:text-white shrink-0 transition-colors">Силабус</a>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </x-ui.card>
            @empty
                <x-ui.card class="p-6 lg:col-span-2"><p class="text-fiot-gray">Немає дисциплін за цими фільтрами.</p></x-ui.card>
            @endforelse
        </div>
    @else
        <div class="space-y-10 mb-20">
            @forelse ($byCourse as $course => $group)
                <section>
                    <h2 class="text-white font-bold text-xl mb-4">{{ $course ? $course . ' курс' : 'Без курсу' }}</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach ($group->groupBy(fn ($d) => $d->semester ?? 0)->sortKeys() as $semester => $semGroup)
                            <x-ui.card class="p-6">
                                <h3 class="text-fiot-accent font-bold text-sm uppercase tracking-widest mb-4">{{ $semester ? $semester . ' семестр' : 'Без семестру' }} · {{ $semGroup->count() }}</h3>
                                <ul class="space-y-3">
                                    @foreach ($semGroup as $disc)
                                        <li class="border-b border-white/5 pb-3 last:border-0 last:pb-0">
                                            <div class="text-white text-sm font-bold">{{ $disc->name }}</div>
                                            <div class="text-xs text-fiot-gray mt-1">{{ $disc->cycle ?? 'Без циклу' }}{{ $disc->credits ? ' · ' . $disc->credits . ' ЄКТС' : '' }}{{ $disc->hours ? ' · ' . $disc->hours . ' год' : '' }}</div>
                                        </li>
                                    @endforeach
                                </ul>
                            </x-ui.card>
                        @endforeach
                    </div>
                </section>
            @empty
                <x-ui.card class="p-6"><p class="text-fiot-gray">Немає дисциплін за цими фільтрами.</p></x-ui.card>
            @endforelse
        </div>
    @endif
</x-ui.page>
@endsection

