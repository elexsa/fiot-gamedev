@extends('layouts.app')

@section('title', 'Освітні програми | Кафедра ігрових систем')

@section('meta_description', 'Освітні програми кафедри ігрових систем ФІОТ КПІ: спеціальності, ступені та опис програм.')

@section('content')
<x-ui.page>
    <x-ui.page-header title="Освітні програми" kicker="Вступникам" subtitle="Програми, за якими готує кафедра. Деталі — у деканаті та на сторінці вступу." />

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-20">

        @forelse ($programs as $program)
            <x-program.card :program="$program" />
        @empty
            <x-ui.card class="p-6 md:col-span-2">
                <p class="text-fiot-gray">Освітні програми поки не додані. Додайте їх через адмін-панель.</p>
            </x-ui.card>
        @endforelse

    </div>
</x-ui.page>
@endsection
