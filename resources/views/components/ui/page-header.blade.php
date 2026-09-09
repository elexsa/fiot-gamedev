@props([
    'kicker' => null,
    'title' => null,
    'subtitle' => null,
])

<div {{ $attributes->merge(['class' => ' mb-12 md:mb-16']) }}>
    @if ($kicker)
        <p class="text-sm font-semibold text-fiot-gray mb-3">{{ $kicker }}</p>
    @endif
    <div class="border-fiot-accent ">
        <h1 class="text-3xl md:text-5xl font-bold tracking-tight mb-3 text-white">{{ $title }}</h1>
    </div>
    @if ($subtitle)
        <p class="text-fiot-gray mt-4 max-w-prose text-base md:text-lg leading-relaxed">{{ $subtitle }}</p>
    @endif
    {{ $slot }}
</div>
