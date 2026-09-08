@props([
    'kicker' => null,
    'title' => null,
    'subtitle' => null,
    'tone' => 'base', // base | raised
    'centered' => false,
])

<section {{ $attributes->merge(['class' => 'relative z-10 py-20 md:py-28 px-6 border-t border-white/5 ' . ($tone === 'raised' ? 'bg-[#0b0c0f]' : '')]) }}>
    <div class="container mx-auto max-w-screen-xl">
        @if ($title || $kicker || $subtitle)
            <div class="{{ $centered ? 'mb-12 md:mb-16 max-w-prose mx-auto' : 'mb-12 md:mb-16 max-w-prose' }}">
                @if ($kicker)
                    <p class="text-sm font-semibold text-fiot-gray mb-4">{{ $kicker }}</p>
                @endif
                @if ($title)
                    <div class="border-l-2 border-fiot-accent pl-5 {{ $centered ? 'mx-auto' : '' }}">
                        <h2 class="text-3xl md:text-4xl font-bold tracking-tight text-white mb-4 {{ $centered ? 'text-center' : '' }}">{{ $title }}</h2>
                    </div>
                @endif
                @if ($subtitle)
                    <p class="text-fiot-gray mt-4 text-base md:text-lg leading-relaxed {{ $centered ? 'text-center mx-auto' : '' }}">{{ $subtitle }}</p>
                @endif
            </div>
        @endif
        {{ $slot }}
    </div>
</section>
