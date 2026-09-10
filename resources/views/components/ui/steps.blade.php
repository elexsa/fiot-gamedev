@props([
    'steps' => [],
])

@if (!empty($steps))
    <ol {{ $attributes->merge(['class' => 'relative ml-2 md:ml-3 border-l border-white/10 space-y-6']) }}>
        @foreach ($steps as $index => $step)
            <li class="relative pl-8 md:pl-10">
                <span aria-hidden="true" class="absolute -left-4 top-0 flex h-8 w-8 items-center justify-center rounded-full border border-white/15 bg-fiot-black text-sm font-semibold text-fiot-gray">
                    {{ $index + 1 }}
                </span>
                <x-ui.card class="p-5 md:p-6">
                    @if (!empty($step['date'] ?? null))
                        <p class="text-sm text-fiot-gray mb-2">{{ $step['date'] }}</p>
                    @endif
                    @if (!empty($step['title'] ?? null))
                        <h3 class="text-white font-bold text-lg md:text-xl mb-2">{{ $step['title'] }}</h3>
                    @endif
                    @if (!empty($step['text'] ?? null))
                        <p class="text-sm text-fiot-gray leading-relaxed max-w-prose">{{ $step['text'] }}</p>
                    @endif
                </x-ui.card>
            </li>
        @endforeach
    </ol>
@endif
