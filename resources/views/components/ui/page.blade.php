<div {{ $attributes->merge(['class' => 'relative z-10 pt-16 md:pt-24 pb-20 min-h-screen']) }}>
    <div class="container mx-auto max-w-screen-xl px-4 md:px-8">
        {{ $slot }}
    </div>
</div>
