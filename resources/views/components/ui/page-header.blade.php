@props([
    'kicker' => null,
    'title' => null,
    'subtitle' => null,
])

<div {{ $attributes->merge(['class' => 'mb-12 md:mb-16 border-l-4 border-fiot-primary pl-5 md:pl-6']) }}>
    @if ($kicker)
        <p class="text-[10px] md:text-xs font-mono uppercase tracking-[0.25em] text-fiot-accent mb-3">{{ $kicker }}</p>
    @endif
    <h1 class="text-3xl md:text-5xl lg:text-6xl font-bold tracking-tighter mb-3 text-white uppercase">{{ $title }}</h1>
    @if ($subtitle)
        <p class="text-gray-400 max-w-2xl text-xs md:text-sm font-mono">{{ $subtitle }}</p>
    @endif
    {{ $slot }}
</div>
