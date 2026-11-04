@extends('layouts.app')

@section('title', 'Освітні програми')

@section('meta_description', 'Освітні програми кафедри ігрових та інтелектуальних систем ФІОТ КПІ: спеціальності, ступені та опис програм.')

@section('content')
<x-ui.page>
    <x-ui.page-header title="Освітні програми" subtitle="Освітні програми, за якими здійснюється підготовка на кафедрі." />

    <div class="mx-auto my-8 border border-gray-200 rounded-xl overflow-hidden shadow-sm">
        <x-programs-collapsible :degrees="$degrees" />
    </div>

</x-ui.page>
@endsection