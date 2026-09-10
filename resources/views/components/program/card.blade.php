@props(['program'])

<x-ui.card interactive class="group overflow-hidden">
    @if ($program->image)
        <div class="h-44 overflow-hidden border-b border-white/10">
            <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($program->image) }}" alt="{{ $program->name }}" class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105">
        </div>
    @endif
    <div class="p-6 flex flex-1 flex-col">
        <div class="flex flex-wrap items-center gap-2 mb-3">
            @if ($program->specialty_code)
                <x-ui.badge>{{ $program->specialty_code }}</x-ui.badge>
            @endif
            @if ($program->degree)
                <x-ui.badge>{{ $program->degree }}</x-ui.badge>
            @endif
        </div>
        <h3 class="text-white font-bold text-xl mb-2">{{ $program->name }}</h3>
        @if ($program->description)
            <p class="text-fiot-gray text-sm leading-relaxed mb-6 flex-1">{{ $program->description }}</p>
        @endif
        <a href="{{ route('programs') }}" class="mt-auto inline-flex items-center gap-2 text-sm text-fiot-gray transition-colors group-hover:text-white">
            Детальніше про програму
            <x-ui.icon name="arrow-right" class="w-3 h-3" />
        </a>
    </div>
</x-ui.card>
