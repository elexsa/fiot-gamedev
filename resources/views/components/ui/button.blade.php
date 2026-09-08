@props([
    'href' => null,
    'variant' => 'primary', // primary | secondary | outline
    'size' => 'md',         // lg | md | sm
])

@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => "btn btn-{$variant} btn-{$size}"]) }}>{{ $slot }}</a>
@else
    <button {{ $attributes->merge(['class' => "btn btn-{$variant} btn-{$size}"]) }}>{{ $slot }}</button>
@endif
