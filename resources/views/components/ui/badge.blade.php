@props(['color' => 'neutral'])

@php
    $styles = match ($color) {
        'accent'   => 'border-fiot-accent/40 text-fiot-accent',
        'primary'  => 'border-fiot-primary/40 text-fiot-primary',
        default     => 'border-white/15 text-fiot-gray',
    };
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center text-xs px-2.5 py-1 rounded-full border {$styles}"]) }}>
    {{ $slot }}
</span>
