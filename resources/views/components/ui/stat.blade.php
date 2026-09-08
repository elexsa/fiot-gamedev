@props(['value', 'label'])

<div {{ $attributes->merge(['class' => 'text-center px-4 py-6']) }}>
    <div class="text-4xl md:text-5xl font-bold text-white mb-2">{{ $value }}</div>
    <div class="text-sm text-fiot-gray">{{ $label }}</div>
</div>
