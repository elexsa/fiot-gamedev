@props(['program'])

<x-ui.card interactive class="group overflow-hidden" :href="route('programs')">
    @if ($program->image)
        <div class="h-44 overflow-hidden border-b border-white/10">
            <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($program->image) }}" alt="{{ $program->name }}" loading="lazy" decoding="async" class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105">
        </div>
    @endif
    <div class="p-6 flex flex-1 flex-col">
        <h3 class="text-white font-bold text-xl mb-2">{{ $program->name }}</h3>
        @if ($program->description)
            <p class="text-fiot-gray text-sm leading-relaxed flex-1">{{ $program->description }}</p>
        @endif
    </div>
</x-ui.card>
