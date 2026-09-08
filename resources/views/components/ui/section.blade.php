@props([
    'kicker' => null,
    'title' => null,
    'subtitle' => null,
    'tone' => 'base', // base | raised
    'centered' => false,
])

<section {{ $attributes->merge(['class' => 'relative z-10 py-20 md:py-28 px-6 border-t border-fiot-dark ' . ($tone === 'raised' ? 'bg-[#0b0c0f]' : '')]) }}>
    <div class="container mx-auto max-w-screen-xl">
        @if ($title || $kicker || $subtitle)
            <div class="{{ $centered ? 'mb-12 md:mb-16 max-w-3xl mx-auto' : 'mb-12 md:mb-16 max-w-3xl' }}">
                @if ($kicker)
                    <p class="text-[11px] font-mono uppercase tracking-[0.25em] text-fiot-accent mb-4">{{ $kicker }}</p>
                @endif
                @if ($title)
                    <h2 class="text-3xl md:text-5xl font-bold tracking-tighter text-white uppercase mb-4">{{ $title }}</h2>
                @endif
                @if ($subtitle)
                    <p class="text-fiot-gray text-base md:text-lg leading-relaxed max-w-2xl {{ $centered ? 'mx-auto text-center' : '' }}">{{ $subtitle }}</p>
                @endif
            </div>
        @endif
        {{ $slot }}
    </div>
</section>
