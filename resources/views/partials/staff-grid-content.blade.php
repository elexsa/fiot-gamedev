<!-- ІНФОРМАЦІЯ ПРО СТОРІНКИ ТА ВИБІР КІЛЬКОСТІ -->
<div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6 px-1">
    <div class="text-sm text-fiot-gray">
        @if ($staff->total() > 0)
        Показано з <span class="text-white font-bold">{{ $staff->firstItem() }}</span>
        по <span class="text-white font-bold">{{ $staff->lastItem() }}</span>
        із <span class="text-white font-bold">{{ $staff->total() }}</span> викладачів
        @else
        Знайдено викладачів: <span class="text-white font-bold">0</span>
        @endif
    </div>

    <div class="flex items-center gap-2 text-sm text-fiot-gray">
        <span>Відображати на сторінці:</span>
        <select name="per_page"
            @change="perPage = $el.value; fetchStaff();"
            class="bg-[#0b0c0f] border border-white/10 rounded-lg px-3 py-1.5 text-white focus:border-fiot-accent/60 outline-none transition-colors text-xs cursor-pointer">
            @foreach($perPageOptions as $limit)
            <option value="{{ $limit }}" @selected($filters['per_page']==$limit)>{{ $limit }}</option>
            @endforeach
        </select>
    </div>
</div>

<!-- GRID (СІТКА ВИКЛАДАЧІВ) -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
    @forelse ($staff as $member)
    <div @click="openModal({ id: {{ $member->id }}, last_name: @js($member->last_name), first_name: @js($member->first_name), patronymic: @js($member->patronymic), avatar_url: @js($member->avatar_url), position_color: @js($member->position_color), degree_color: @js($member->degree_color), rank_color: @js($member->rank_color), position: @js($member->position), degree: @js($member->degree), academic_rank: @js($member->academicRank), disciplines: @js($member->disciplines) })"
        @mouseenter.once="preloadDetails({{ $member->id }})"
        class="group relative rounded-3xl p-6 border cursor-pointer transition-transform duration-150 transform-gpu will-change-transform hover:-translate-y-1 hover:shadow-xl flex flex-col justify-between bg-slate-900 border-slate-800 hover:border-fiot-primary select-text min-h-[280px]">

        <div class="flex flex-col h-full justify-between relative z-10 gap-4">
            <div class="space-y-3">
                <div class="flex items-start gap-4">
                    @if($member->avatar_url)
                    <img src="{{ $member->avatar_url }}"
                        width="96" height="96"
                        loading="lazy"
                        class="w-20 h-20 md:w-24 md:h-24 rounded-2xl object-cover border-2 border-slate-700 group-hover:border-fiot-primary transition-colors shadow-md flex-shrink-0"
                        alt="Аватар">
                    @else
                    <div class="w-20 h-20 md:w-24 md:h-24 rounded-2xl bg-slate-800 border-2 border-slate-700 group-hover:border-fiot-primary transition-colors shadow-md flex items-center justify-center flex-shrink-0 text-fiot-accent font-large-heading text-2xl md:text-3xl font-bold select-none">
                        {{ mb_substr($member->last_name ?? '?', 0, 1) }}
                    </div>
                    @endif

                    <div class="flex-1 min-w-0 flex flex-col gap-1.5 pt-0.5">
                        @if($member->position?->name)
                        <span class="inline-block px-2.5 py-0.5 rounded-lg border text-[11px] font-sans w-fit select-text {{ $member->position_color }}">
                            <strong class="font-normal opacity-80">Посада:</strong>
                            <span class="font-semibold">{{ $member->position->name }}</span>
                        </span>
                        @endif

                        @if($member->degree?->name || $member->academicRank?->name)
                        <div class="flex flex-wrap gap-1 text-[11px] font-sans">
                            @if($member->degree?->name)
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-lg border select-text {{ $member->degree_color }}">
                                <strong class="font-normal opacity-80">Ступінь:</strong>
                                <span class="font-semibold">{{ $member->degree->name }}</span>
                            </span>
                            @endif
                            @if($member->academicRank?->name)
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-lg border select-text {{ $member->rank_color }}">
                                <strong class="font-normal opacity-80">Звання:</strong>
                                <span class="font-semibold">{{ $member->academicRank->name }}</span>
                            </span>
                            @endif
                        </div>
                        @endif
                    </div>
                </div>

                <h3 class="font-heading text-base md:text-lg font-bold text-fiot-white group-hover:text-fiot-accent transition-colors tracking-tight leading-snug select-text">
                    {{ trim("{$member->last_name} {$member->first_name} {$member->patronymic}") }}
                </h3>
            </div>

            <div class="pt-3 border-t border-slate-800 flex flex-wrap gap-1.5 items-center mt-auto">
                @foreach ($member->disciplines->unique('name')->take(3) as $disc)
                <span @click.stop="goToSubject(@js($disc), {{ $member->id }})"
                    class="cursor-pointer text-[11px] border px-2.5 py-1 rounded-lg font-mono transition-transform duration-150 transform-gpu hover:scale-105 hover:underline select-text inline-block"
                    :class="getSubjectColor(@js($disc))">
                    {{ $disc->name }}
                </span>
                @endforeach

                @if ($member->disciplines->unique('name')->count() > 3)
                <span class="text-[10px] text-fiot-gray font-mono select-text">+{{ $member->disciplines->unique('name')->count() - 3 }}</span>
                @endif
            </div>
        </div>

    </div>
    @empty
    <div class="col-span-full text-center py-24 bg-slate-900/60 rounded-3xl border border-slate-800 mt-4">
        <div class="text-3xl mb-3">🔍</div>
        <div class="text-fiot-white font-bold text-sm font-heading select-text">Нічого не знайдено</div>
        <button type="button" @click="searchQuery = ''; fetchStaff();" class="mt-4 inline-block px-4 py-2 bg-fiot-primary hover:bg-fiot-primary-hover text-fiot-white rounded-xl text-xs font-mono transition-colors shadow-lg cursor-pointer">Скинути пошук</button>
    </div>
    @endforelse
</div>

<!-- БЛОК ПАГІНАЦІЇ -->
<div class="flex justify-center items-center mt-12 mb-20">
    @if ($staff->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-center">
        <span class="relative z-0 inline-flex shadow-sm rounded-2xl gap-1.5">
            @foreach ($staff->linkCollection() as $link)
            @php
            $label = $link['label'];
            if (str_contains($label, 'Previous') || str_contains($label, '«')) {
            $label = 'Попередня';
            } elseif (str_contains($label, 'Next') || str_contains($label, '»')) {
            $label = 'Наступна';
            }
            @endphp

            @if ($link['url'] === null)
            <span class="relative inline-flex items-center px-3.5 py-2.5 text-xs font-mono font-medium text-fiot-gray bg-slate-900 border border-slate-800 cursor-default rounded-xl select-none">
                {!! $label !!}
            </span>
            @elseif ($link['active'])
            <span class="relative inline-flex items-center px-3.5 py-2.5 text-xs font-mono font-bold text-fiot-white bg-fiot-primary border border-fiot-primary rounded-xl shadow-lg cursor-default select-none">
                {!! $label !!}
            </span>
            @else
            <button type="button"
                @click="fetchStaff('{{ $link['url'] }}')"
                class="relative inline-flex items-center px-3.5 py-2.5 text-xs font-mono font-medium text-slate-300 bg-slate-900 border border-slate-800 rounded-xl hover:bg-fiot-primary/20 hover:border-fiot-primary hover:text-fiot-white transition-colors cursor-pointer">
                {!! $label !!}
            </button>
            @endif
            @endforeach
        </span>
    </nav>
    @endif
</div>