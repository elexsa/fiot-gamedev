@props(['color' => 'accent'])

@php
    $styles = match ($color) {
        'accent'  => 'text-fiot-accent border-fiot-accent/30 bg-fiot-accent/5',
        'primary' => 'text-white border-fiot-primary/50 bg-fiot-primary/10',
        default   => 'text-fiot-gray border-white/10 bg-white/5',
    };
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center text-[10px] font-mono uppercase tracking-widest px-2.5 py-1 rounded-full border {$styles}"]) }}>
    {{ $slot }}
</span>
