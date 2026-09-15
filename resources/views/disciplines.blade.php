@extends('layouts.app')

@section('title', '???')

@section('meta_description', 'Сховані рівні кафедри: навчальний план у вигляді ігрового дерева навичок.')

@section('content')

<section class="relative z-10 pt-16 md:pt-24 min-h-screen flex flex-col">
    <div class="container mx-auto max-w-screen-2xl px-4 md:px-8 relative z-10 flex-shrink-0">
        <x-ui.page-header title="Дерево Навичок" kicker="Схований рівень" subtitle="Ти знайшов пасхалку. Тепер навчальний план очима геймера: наведи на вузол, щоб підсвітити зв'язки. Shift + Scroll для прокрутки." />
    </div>

    @include('disciplines._skill-tree')
@endsection

