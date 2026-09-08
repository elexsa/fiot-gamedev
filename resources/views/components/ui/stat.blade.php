@props(['value', 'label'])

<div {{ $attributes->merge(['class' => 'text-center px-4 py-6']) }}>
    <div class="text-4xl md:text-5xl font-bold text-white tracking-tighter mb-2">{{ $value }}</div>
    <div class="text-[10px] md:text-xs text-fiot-gray font-mono uppercase tracking-widest">{{ $label }}</div>
</div>
