@extends('layouts.app')

@section('title', 'Інтерактивна діаграма навчального плану')

@section('content')
<x-ui.page>
    <x-ui.page-header title="Інтерактивна діаграма дисциплін" subtitle="Інтерактивна карта освітнього процесу та зв'язків між дисциплінами." />

    <!-- Контейнер, куди завантажується діаграма -->
    <div id="diagram-wrapper">
        @include('partials.diagram-content', [
            'filters' => $filters,
            'disciplines' => $disciplines,
            'coursesJson' => $coursesJson,
            'programs' => $programs,
        ])
    </div>
</x-ui.page>
@endsection