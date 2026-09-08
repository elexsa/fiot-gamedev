@props([
    'href' => null,
    'interactive' => false,
    'tone' => 'base', // base | raised
])

@php
    $base = ($tone === 'raised' ? 'bg-[#0b0c0f]' : 'bg-fiot-dark/40') . ' border border-white/10 rounded-2xl transition-all duration-300';
    $hover = $interactive ? 'hover:border-fiot-accent/40 hover:-translate-y-1 hover:shadow-[0_12px_40px_rgba(0,0,0,0.45)]' : '';
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => "{$base} {$hover} flex flex-col"]) }}>{{ $slot }}</a>
@else
    <div {{ $attributes->merge(['class' => "{$base} {$hover}"]) }}>{{ $slot }}</div>
@endif
