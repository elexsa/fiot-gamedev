@props([
    'type' => 'image',
    'label' => null,
    'height' => 'h-80',
    'pattern' => true,
    'icon' => null,
    'size' => 'md',
    'shape' => 'rounded',
    'text' => null,
])

@php
    $avatarSizes = ['sm' => 'w-10 h-10', 'md' => 'w-14 h-14', 'lg' => 'w-20 h-20'];
    $logoSizes = ['sm' => 'h-16', 'md' => 'h-24', 'lg' => 'h-32'];
    $avatarClass = $avatarSizes[$size] ?? 'w-14 h-14';
    $logoClass = $logoSizes[$size] ?? 'h-24';
@endphp

@if ($type === 'image')
    <div {{ $attributes->merge(['class' => "{$height} bg-fiot-dark/40 border border-white/10 rounded-2xl relative flex items-center justify-center overflow-hidden"]) }}>
        @if ($pattern)
            <div class="absolute inset-0 opacity-10 bg-[linear-gradient(to_right,#4D11CC_1px,transparent_1px),linear-gradient(to_bottom,#4D11CC_1px,transparent_1px)] bg-[length:30px_30px]"></div>
        @endif

        <div class="relative z-10 flex flex-col items-center gap-3 text-fiot-gray">
            @if ($icon)
                <x-ui.icon name="{{ $icon }}" class="w-6 h-6 opacity-50" />
            @endif
            @if ($label)
                <span class="text-sm">{{ $label }}</span>
            @endif
        </div>

        {{ $slot }}
    </div>

@elseif ($type === 'avatar')
    @php $shapeClass = $shape === 'circle' ? 'rounded-full' : 'rounded-xl'; @endphp
    <div {{ $attributes->merge(['class' => "{$avatarClass} shrink-0 border border-white/10 bg-gradient-to-br from-fiot-primary/20 to-fiot-accent/10 flex items-center justify-center text-white/60 font-bold overflow-hidden {$shapeClass}"]) }}>
        @if ($slot->isNotEmpty())
            {{ $slot }}
        @elseif ($text)
            <span class="text-lg">{{ $text }}</span>
        @elseif ($icon)
            <x-ui.icon name="{{ $icon }}" class="w-6 h-6 opacity-50" />
        @endif
    </div>

@elseif ($type === 'logo')
    <div {{ $attributes->merge(['class' => "{$logoClass} flex items-center justify-center bg-fiot-dark/60 border border-white/10 rounded-xl"]) }}>
        @if ($slot->isNotEmpty())
            {{ $slot }}
        @elseif ($text)
            <span class="text-2xl font-bold tracking-tighter text-white/40">{{ $text }}</span>
        @elseif ($icon)
            <x-ui.icon name="{{ $icon }}" class="w-8 h-8 text-white/30" />
        @endif
    </div>
@endif