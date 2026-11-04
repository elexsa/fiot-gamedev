@extends('layouts.app')

@section('title', 'Сторінка в розробці')

@section('meta_description', 'Цей розділ наразі перебуває в стадії розробки. Скоро тут з\'явиться новий функціонал.')

@section('content')
<x-ui.page>
    <div class="flex flex-col items-center justify-center min-h-[60vh] text-center px-4 py-16">
        
        <!-- Декоративна іконка з анімацією пульсу -->
        <div class="w-20 h-20 rounded-3xl bg-fiot-dark/60 border border-white/10 flex items-center justify-center text-fiot-accent mb-6 shadow-2xl backdrop-blur-md animate-pulse">
            <svg class="w-10 h-10" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17L17.25 21A2.65 2.65 0 0121 17.25l-5.83-5.83M12 6.75a5.25 5.25 0 11-10.5 0 5.25 5.25 0 0110.5 0z" />
            </svg>
        </div>

        <!-- Заголовок -->
        <h1 class="text-2xl sm:text-4xl font-extrabold text-white tracking-tight mb-3">
            Розділ у розробці 🚧
        </h1>

        <!-- Опис -->
        <p class="text-fiot-gray text-sm sm:text-base max-w-md mb-8 leading-relaxed">
            Ми активно працюємо над створенням цієї сторінки. Зовсім скоро тут з'явиться новий функціонал та оновлена інформація.
        </p>

        <!-- Кнопки навігації / дій -->
        <div class="flex flex-col sm:flex-row items-center gap-3 w-full sm:w-auto">
            <a href="{{ url()->previous() }}" class="btn btn-outline btn-md w-full sm:w-auto px-6 text-center">
                Повернутися назад
            </a>
            <a href="{{ route('syllabuses') }}" class="btn btn-primary btn-md w-full sm:w-auto px-6 text-center">
                Перейти до силабусів
            </a>
        </div>

    </div>
</x-ui.page>
@endsection