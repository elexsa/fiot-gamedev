@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-between">
        <!-- Мобільна версія -->
        <div class="flex justify-between flex-1 sm:hidden">
            @if ($paginator->onFirstPage())
                <span class="relative inline-flex items-center px-4 py-2.5 text-xs font-mono font-medium text-fiot-gray bg-slate-900 border border-slate-800 cursor-default rounded-xl select-none">
                    Попередня
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2.5 text-xs font-mono font-medium text-fiot-white bg-slate-900 border border-slate-800 rounded-xl hover:bg-fiot-primary/20 hover:border-fiot-primary transition-colors">
                    Попередня
                </a>
            @endif

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="relative inline-flex items-center px-4 py-2.5 ml-3 text-xs font-mono font-medium text-fiot-white bg-slate-900 border border-slate-800 rounded-xl hover:bg-fiot-primary/20 hover:border-fiot-primary transition-colors">
                    Наступна
                </a>
            @else
                <span class="relative inline-flex items-center px-4 py-2.5 ml-3 text-xs font-mono font-medium text-fiot-gray bg-slate-900 border border-slate-800 cursor-default rounded-xl select-none">
                    Наступна
                </span>
            @endif
        </div>

        <!-- Десктопна версія -->
        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-center">
            <div>
                <span class="relative z-0 inline-flex shadow-sm rounded-2xl gap-1.5">
                    {{-- Кнопка «Попередня» --}}
                    @if ($paginator->onFirstPage())
                        <span aria-disabled="true" aria-label="Попередня" class="relative inline-flex items-center px-3.5 py-2.5 text-xs font-mono font-medium text-fiot-gray bg-slate-900 border border-slate-800 cursor-default rounded-xl select-none">
                            Попередня
                        </span>
                    @else
                        <a href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="Попередня" class="relative inline-flex items-center px-3.5 py-2.5 text-xs font-mono font-medium text-fiot-white bg-slate-900 border border-slate-800 rounded-xl hover:bg-fiot-primary/20 hover:border-fiot-primary transition-colors">
                            Попередня
                        </a>
                    @endif

                    {{-- Елементи пагінації (сторінки) --}}
                    @foreach ($elements as $element)
                        {{-- Три крапки --}}
                        @if (is_string($element))
                            <span aria-disabled="true" class="relative inline-flex items-center px-3.5 py-2.5 text-xs font-mono font-medium text-fiot-gray bg-slate-900/50 border border-slate-800 rounded-xl cursor-default select-none">
                                {{ $element }}
                            </span>
                        @endif

                        {{-- Масив посилань --}}
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <span aria-current="page" class="relative inline-flex items-center px-3.5 py-2.5 text-xs font-mono font-bold text-fiot-white bg-fiot-primary border border-fiot-primary rounded-xl shadow-lg cursor-default select-none">
                                        {{ $page }}
                                    </span>
                                @else
                                    <a href="{{ $url }}" class="relative inline-flex items-center px-3.5 py-2.5 text-xs font-mono font-medium text-slate-300 bg-slate-900 border border-slate-800 rounded-xl hover:bg-fiot-primary/20 hover:border-fiot-primary hover:text-fiot-white transition-colors">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Кнопка «Наступна» --}}
                    @if ($paginator->hasMorePages())
                        <a href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="Наступна" class="relative inline-flex items-center px-3.5 py-2.5 text-xs font-mono font-medium text-fiot-white bg-slate-900 border border-slate-800 rounded-xl hover:bg-fiot-primary/20 hover:border-fiot-primary transition-colors">
                            Наступна
                        </a>
                    @else
                        <span aria-disabled="true" aria-label="Наступна" class="relative inline-flex items-center px-3.5 py-2.5 text-xs font-mono font-medium text-fiot-gray bg-slate-900 border border-slate-800 cursor-default rounded-xl select-none">
                            Наступна
                        </span>
                    @endif
                </span>
            </div>
        </div>
    </nav>
@endif