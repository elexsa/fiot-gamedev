@php
$staffCollection = $staff ?? collect();
$openStaffId = request()->query('staff_id');
$initialStaff = $openStaffId ? collect($staff->items())->firstWhere('id', $openStaffId) : null;
@endphp

<div
    x-data="{
         isModalOpen: {{ $initialStaff ? 'true' : 'false' }},
         modalData: {{ $initialStaff ? json_encode($initialStaff) : 'null' }},

         init() {
             if (this.isModalOpen) {
                 document.body.classList.add('modal-open');
             }
         },

         openModal(member) {
             this.modalData = member;
             this.isModalOpen = true;
             document.body.classList.add('modal-open');
             
             const url = new URL(window.location);
             url.searchParams.set('staff_id', member.id);
             window.history.replaceState({}, '', url);
         },

         closeModal() {
             this.isModalOpen = false;
             document.body.classList.remove('modal-open');
             
             const url = new URL(window.location);
             url.searchParams.delete('staff_id');
             window.history.replaceState({}, '', url);

             setTimeout(() => {
                 this.modalData = null;
             }, 200);
         },

         goToSubject(disc) {
             const disciplineId = typeof disc === 'object' && disc !== null ? disc.id : disc;
             if (disciplineId) {
                 window.location.href = `/syllabuses?syllabus_id=${encodeURIComponent(disciplineId)}`;
             }
         },

         getColorByName(name, categoryType) {
             if (!name || name === 'Відсутнє' || name === 'Відсутній' || name === 'Відсутня') {
                 return 'bg-slate-800/80 border-slate-700/80 text-slate-400/90 shadow-none';
             }
             
             let hash = 0;
             for (let i = 0; i < name.length; i++) {
                 hash = name.charCodeAt(i) + ((hash << 5) - hash);
             }
             const palettes = {
                 position: [
                     'bg-rose-950/90 border-rose-700/80 text-rose-100',
                     'bg-pink-950/90 border-pink-700/80 text-pink-100',
                     'bg-fuchsia-950/90 border-fuchsia-700/80 text-fuchsia-100',
                     'bg-red-950/90 border-red-700/80 text-red-100',
                     'bg-teal-950/90 border-teal-700/80 text-teal-100'
                 ],
                 degree: [
                     'bg-violet-950/90 border-violet-700/80 text-violet-100',
                     'bg-emerald-950/90 border-emerald-700/80 text-emerald-100',
                     'bg-blue-950/90 border-blue-700/80 text-blue-100',
                     'bg-cyan-950/90 border-cyan-700/80 text-cyan-100'
                 ],
                 rank: [
                     'bg-purple-950/90 border-purple-700/80 text-purple-100',
                     'bg-indigo-950/90 border-indigo-700/80 text-indigo-100',
                     'bg-amber-950/90 border-amber-700/80 text-amber-100',
                     'bg-sky-950/90 border-sky-700/80 text-sky-100'
                 ]
             };
             const pool = palettes[categoryType] || palettes.position;
             return pool[Math.abs(hash) % pool.length];
         },

         getPositionColor(name) { return this.getColorByName(name, 'position'); },
         getDegreeColor(name) { return this.getColorByName(name, 'degree'); },
         getRankColor(name) { return this.getColorByName(name, 'rank'); },

         getSubjectColor(subjectOrDisc) {
             let id = typeof subjectOrDisc === 'object' && subjectOrDisc !== null 
                 ? subjectOrDisc.id 
                 : subjectOrDisc;

             if (!id && typeof subjectOrDisc === 'object' && subjectOrDisc !== null) {
                 id = subjectOrDisc.name;
             }

             if (!id) return 'bg-sky-950/90 border-sky-700/80 text-sky-100';

             let hash = 0;
             if (typeof id === 'number') {
                 hash = id;
             } else {
                 let strId = String(id);
                 for (let i = 0; i < strId.length; i++) {
                     hash = strId.charCodeAt(i) + ((hash << 5) - hash);
                 }
             }

             const colors = [
                 'bg-cyan-950/90 border-cyan-700/80 text-cyan-100',
                 'bg-sky-950/90 border-sky-700/80 text-sky-100',
                 'bg-blue-950/90 border-blue-700/80 text-blue-100',
                 'bg-indigo-950/90 border-indigo-700/80 text-indigo-100',
                 'bg-violet-950/90 border-violet-700/80 text-violet-100',
                 'bg-purple-950/90 border-purple-700/80 text-purple-100',
                 'bg-fuchsia-950/90 border-fuchsia-700/80 text-fuchsia-100',
                 'bg-pink-950/90 border-pink-700/80 text-pink-100',
                 'bg-rose-950/90 border-rose-700/80 text-rose-100',
                 'bg-emerald-950/90 border-emerald-700/80 text-emerald-100',
                 'bg-teal-950/90 border-teal-700/80 text-teal-100',
                 'bg-amber-950/90 border-amber-700/80 text-amber-100'
             ];
             
             return colors[Math.abs(hash) % colors.length];
         }
     }"
    x-init="setTimeout(() => $el.classList.add('loaded'), 50)">

    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full max-w-7xl h-[500px] bg-gradient-to-b from-fiot-primary/20 via-fiot-primary/5 to-transparent blur-[120px] pointer-events-none"></div>

    <div class="relative container mx-auto px-4 py-16 max-w-7xl">

        <!-- ФОРМА ПОШУКУ ТА ШАПКА -->
        <form id="staff-search-form" method="GET" action="{{ route('about') }}"
            x-data="{
          submitForm(e) {
              // Зберігаємо поточну позицію скролу в сесійну пам'ять браузера перед сабмітом
              sessionStorage.setItem('scrollPosition', window.scrollY);
          }
      }"
            @submit="submitForm">
            <header class="flex flex-col lg:flex-row justify-between items-start lg:items-end gap-6 mb-8 pb-8 border-b border-fiot-dark">
                <div>
                    <h1 class="font-large-heading text-4xl md:text-6xl font-extrabold tracking-tight text-fiot-white bg-gradient-to-r from-fiot-white via-slate-200 to-fiot-accent bg-clip-text text-transparent select-text">
                        Викладацький склад
                    </h1>
                    <p class="text-fiot-gray text-sm md:text-base mt-3 max-w-2xl leading-relaxed font-body select-text">
                        На кафедрі працюють досвідчені викладачі.
                    </p>
                </div>

                <!-- Пошуковий рядок -->
                <div class="w-full lg:w-96 flex gap-2">
                    <div class="relative flex-1">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-fiot-gray">🔍</span>
                        <input type="text"
                            id="search"
                            name="q"
                            value="{{ $filters['q'] ?? '' }}"
                            placeholder="Пошук за ПІБ, посадою, ступенем, званням"
                            class="bg-fiot-dark/90 border border-fiot-primary/30 hover:border-fiot-primary/60 rounded-2xl pl-11 pr-4 py-3.5 text-xs text-fiot-white placeholder-fiot-gray focus:outline-none focus:border-fiot-primary focus:ring-4 focus:ring-fiot-primary/20 transition-all w-full backdrop-blur-xl shadow-2xl font-body">
                        @if(!empty($filters['q']))
                        <a href="{{ route('about') }}" class="absolute inset-y-0 right-0 pr-4 flex items-center text-fiot-gray hover:text-fiot-white text-xs font-mono cursor-pointer">
                            ✕
                        </a>
                        @endif
                    </div>
                    <button type="submit" class="btn btn-primary px-5 py-3.5 rounded-2xl text-xs font-bold cursor-pointer">Знайти</button>
                </div>
            </header>
        </form>

        <!-- ІНФОРМАЦІЯ ПРО СТОРІНКИ ТА ВИБІР КІЛЬКОСТІ ЕЛЕМЕНТІВ -->
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
                <select name="per_page" form="staff-search-form"
                    @change="sessionStorage.setItem('scrollPosition', window.scrollY); $el.form.submit();"
                    class="bg-[#0b0c0f] border border-white/10 rounded-lg px-3 py-1.5 text-white focus:border-fiot-accent/60 outline-none transition-colors text-xs">
                    @foreach($perPageOptions as $limit)
                    <option value="{{ $limit }}" @selected($filters['per_page']==$limit)>{{ $limit }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- GRID (СІТКА ВИКЛАДАЧІВ) -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
            @forelse ($staff as $member)
            <div @click="openModal(@js($member))"
                class="group relative rounded-3xl p-6 border cursor-pointer transition-all duration-300 hover:-translate-y-1.5 hover:shadow-2xl hover:shadow-fiot-primary/25 backdrop-blur-2xl flex flex-col justify-between overflow-visible bg-slate-900/90 border-slate-700/80 hover:border-fiot-primary select-text min-h-[280px]">

                <div class="absolute inset-0 rounded-3xl overflow-hidden pointer-events-none">
                    <div class="absolute inset-0 bg-gradient-to-tr from-fiot-primary/0 via-fiot-primary/0 to-fiot-primary/15 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                </div>

                <!-- СТРУКТУРА КАРТКИ -->
                <div class="flex flex-col h-full justify-between relative z-10 gap-4">
                    <div class="space-y-3">
                        <div class="flex items-start gap-4">
                            <!-- Аватар або ініціал -->
                            @if($member->avatar_url ?? $member->avatar)
                            <img src="{{ $member->avatar_url ?? \Illuminate\Support\Facades\Storage::url($member->avatar) }}"
                                class="w-20 h-20 md:w-24 md:h-24 rounded-2xl object-cover border-2 border-slate-700 group-hover:border-fiot-primary transition-colors shadow-lg flex-shrink-0"
                                alt="Аватар викладача">
                            @else
                            <div class="w-20 h-20 md:w-24 md:h-24 rounded-2xl bg-slate-800 border-2 border-slate-700 group-hover:border-fiot-primary transition-colors shadow-lg flex items-center justify-center flex-shrink-0 text-fiot-accent font-large-heading text-2xl md:text-3xl font-bold select-none">
                                {{ mb_substr($member->last_name ?? '?', 0, 1) }}
                            </div>
                            @endif

                            <div class="flex-1 min-w-0 flex flex-col gap-1.5 pt-0.5">
                                <!-- Посада -->
                                <span class="inline-block px-2.5 py-0.5 rounded-lg border text-[11px] shadow-sm font-sans w-fit select-text"
                                    :class="getPositionColor('{{ $member->position?->name }}')">
                                    <strong class="font-normal opacity-80">Посада:</strong>
                                    <span class="font-semibold">{{ $member->position?->name }}</span>
                                </span>

                                <!-- Ступінь та Звання -->
                                <div class="flex flex-wrap gap-1 text-[11px] font-sans">
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-lg border shadow-sm select-text"
                                        :class="getDegreeColor('{{ $member->degree?->name }}')">
                                        <strong class="font-normal opacity-80">Ступінь:</strong>
                                        <span class="font-semibold">{{ $member->degree?->name }}</span>
                                    </span>
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-lg border shadow-sm select-text"
                                        :class="getRankColor('{{ $member->academicRank?->name }}')">
                                        <strong class="font-normal opacity-80">Звання:</strong>
                                        <span class="font-semibold">{{ $member->academicRank?->name }}</span>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- ПІБ -->
                        <h3 class="font-heading text-base md:text-lg font-bold text-fiot-white group-hover:text-fiot-accent transition-colors tracking-tight leading-snug select-text">
                            {{ trim("{$member->last_name} {$member->first_name} {$member->patronymic}") }}
                        </h3>
                    </div>

                    <!-- Дисципліни -->
                    <div class="pt-3 border-t border-slate-700/60 flex flex-wrap gap-1.5 items-center mt-auto">
                        @foreach ($member->disciplines->take(3) as $disc)
                        <span @click.stop="goToSubject(@js($disc))"
                            class="text-[11px] border px-2.5 py-1 rounded-lg font-mono transition-transform duration-200 shadow-sm cursor-pointer hover:scale-105 hover:underline select-text inline-block"
                            :class="getSubjectColor(@js($disc))">
                            {{ $disc->name }}
                        </span>
                        @endforeach
                        @if ($member->disciplines->count() > 3)
                        <span class="text-[10px] text-fiot-gray font-mono select-text">+{{ $member->disciplines->count() - 3 }}</span>
                        @endif
                    </div>
                </div>

            </div>
            @empty
            <div class="col-span-full text-center py-24 bg-slate-900/60 rounded-3xl border border-slate-700 mt-4 backdrop-blur-md">
                <div class="text-3xl mb-3">🔍</div>
                <div class="text-fiot-white font-bold text-sm font-heading select-text">Нічого не знайдено</div>
                <a href="{{ route('about') }}" class="mt-4 inline-block px-4 py-2 bg-fiot-primary hover:bg-fiot-primary-hover text-fiot-white rounded-xl text-xs font-mono transition-colors shadow-lg shadow-fiot-primary/20 cursor-pointer">Скинути пошук</a>
            </div>
            @endforelse
        </div>

        <!-- БЛОК ПАГІНАЦІЇ З НОМЕРАМИ СТОРІНОК (ПО ЦЕНТРУ) -->
        <div class="flex justify-center items-center mt-12 mb-20">
            {{ $staff->links() }}
        </div>

        <!-- МОДАЛЬНИЙ ІНСПЕКТОР (ДОСЬЄ) -->
        <!-- Директива <template x-teleport="body"> змушує Alpine.js під час відкриття модального вікна фізично переміщувати його код у самий кінець тегу <body> на рівні браузера. Завдяки цьому зникають будь-які обмеження контекстів накладання (stacking contexts), а навбар більше ніколи не перекриватиме картку викладача. -->
        <template x-teleport="body">
            <div x-show="isModalOpen"
                x-cloak
                class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-fiot-black/85 backdrop-blur-md overflow-y-auto"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                @keydown.escape.window="closeModal()">

                <div @click.outside="closeModal()"
                    class="bg-slate-900/95 border border-fiot-primary/50 w-full max-w-2xl rounded-3xl p-6 md:p-8 relative shadow-2xl shadow-fiot-primary/20 overflow-hidden backdrop-blur-2xl max-h-[90vh] flex flex-col gpu-accelerated select-text"
                    x-transition:enter="transition ease-out duration-200 transform"
                    x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-200 transform"
                    x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95">

                    <div class="absolute -top-24 -right-24 w-48 h-48 bg-fiot-primary/25 rounded-full blur-3xl pointer-events-none"></div>

                    <button type="button"
                        @click="closeModal()"
                        class="absolute top-5 right-5 z-30 text-fiot-gray hover:text-fiot-white bg-slate-800 hover:bg-fiot-primary/30 border border-slate-700 hover:border-fiot-primary p-2.5 rounded-full transition-all text-xs font-mono cursor-pointer shadow-lg"
                        aria-label="Закрити досьє">
                        ✕
                    </button>

                    <!-- Шапка досьє -->
                    <div class="flex items-start gap-5 mb-6 pb-6 border-b border-slate-700/80 relative z-10 select-text">
                        <template x-if="modalData?.avatar_url || modalData?.avatar">
                            <img :src="modalData.avatar_url || ('/storage/' + modalData.avatar)" class="w-24 h-24 md:w-32 md:h-32 rounded-2xl object-cover border-2 border-fiot-primary shadow-2xl shadow-fiot-primary/30 flex-shrink-0 gpu-accelerated" alt="Фото викладача">
                        </template>
                        <template x-if="!(modalData?.avatar_url || modalData?.avatar)">
                            <div class="w-24 h-24 md:w-32 md:h-32 rounded-2xl bg-slate-800 border-2 border-fiot-primary shadow-2xl shadow-fiot-primary/30 flex items-center justify-center flex-shrink-0 text-fiot-accent font-large-heading text-4xl md:text-5xl font-bold select-none gpu-accelerated"
                                x-text="modalData?.last_name ? modalData.last_name.charAt(0).toUpperCase() : '?'">
                            </div>
                        </template>

                        <div class="space-y-3">
                            <div class="flex flex-wrap gap-2">
                                <span class="inline-block px-3 py-1 rounded-xl border text-xs shadow-sm font-sans select-text"
                                    :class="getPositionColor(modalData?.position?.name)">
                                    <strong class="font-normal opacity-85">Посада:</strong>
                                    <span class="font-semibold" x-text="modalData?.position?.name"></span>
                                </span>
                            </div>
                            <h2 class="font-large-heading text-2xl md:text-3xl font-extrabold text-fiot-white tracking-tight leading-tight select-text" x-text="`${modalData?.last_name ?? ''} ${modalData?.first_name ?? ''} ${modalData?.patronymic ?? ''}`"></h2>

                            <div class="flex flex-wrap gap-2 pt-1 text-xs font-sans">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl border shadow-sm select-text"
                                    :class="getDegreeColor(modalData?.degree?.name)">
                                    <strong class="font-normal opacity-85">Науковий ступінь:</strong>
                                    <span class="font-semibold" x-text="modalData?.degree?.name"></span>
                                </span>
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl border shadow-sm select-text"
                                    :class="getRankColor(modalData?.academic_rank?.name)">
                                    <strong class="font-normal opacity-85">Вчене звання:</strong>
                                    <span class="font-semibold" x-text="modalData?.academic_rank?.name"></span>
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Контент профілю -->
                    <div class="space-y-6 overflow-y-auto pr-2 flex-1 relative z-10 custom-scrollbar gpu-accelerated select-text">

                        <div x-show="modalData?.bio">
                            <h4 class="text-xs font-mono uppercase text-fiot-accent tracking-widest mb-2 flex items-center gap-2 select-text">
                                <span class="w-1.5 h-1.5 rounded-full bg-fiot-accent"></span>
                                Про викладача
                            </h4>
                            <p class="text-slate-200 text-sm md:text-base leading-relaxed bg-slate-950/70 p-4 rounded-2xl border border-slate-800 font-body shadow-inner select-text" x-text="modalData?.bio"></p>
                        </div>

                        <!-- ХРОНОЛОГІЯ ПОДІЙ ТА ДОСЯГНЕНЬ -->
                        <div x-show="modalData && modalData.achievements && modalData.achievements.length > 0" class="space-y-4">
                            <h4 class="text-xs font-mono uppercase text-fiot-accent tracking-widest mb-3 flex items-center gap-2.5 select-text">
                                <span class="w-2 h-2 rounded-full bg-fiot-accent shadow-[0_0_10px_#4f46e5] animate-pulse"></span>
                                Хронологія подій та досягнень
                            </h4>

                            <div class="relative pl-8 pr-2 space-y-4 before:content-[''] before:absolute before:left-3 before:top-3 before:bottom-3 before:w-0.5 before:bg-gradient-to-b before:from-fiot-primary before:via-indigo-500/50 before:to-slate-800 select-text">
                                <template x-for="(ach, index) in (modalData?.achievements || [])" :key="ach.id || index">
                                    <div class="relative group/item">
                                        <div class="absolute -left-8 top-1.5 w-4 h-4 rounded-full bg-slate-950 border-2 border-fiot-primary group-hover/item:border-fiot-accent group-hover/item:scale-125 group-hover/item:shadow-[0_0_12px_rgba(79,70,229,0.8)] transition-all duration-300 flex items-center justify-center z-10">
                                            <div class="w-1.5 h-1.5 rounded-full bg-fiot-accent opacity-0 group-hover/item:opacity-100 transition-opacity"></div>
                                        </div>

                                        <div class="bg-slate-950/90 border border-slate-800/90 hover:border-fiot-primary/60 p-4 rounded-2xl transition-all duration-300 shadow-lg hover:shadow-fiot-primary/10 group-hover/item:-translate-y-0.5">
                                            <div class="flex items-center justify-between gap-2 mb-2">
                                                <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-xl bg-fiot-primary/15 border border-fiot-primary/30 text-fiot-accent font-mono text-xs shadow-sm">
                                                    <svg class="w-3 h-3 opacity-75" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                    </svg>
                                                    <span x-text="ach.year"></span>
                                                </div>
                                            </div>
                                            <p class="text-slate-200 text-xs md:text-sm font-mono leading-relaxed" x-text="ach.achievement_description"></p>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>

                        <!-- Дисципліни -->
                        <div x-show="modalData?.disciplines && modalData.disciplines.length > 0">
                            <h4 class="text-xs font-mono uppercase text-fiot-accent tracking-widest mb-2.5 flex items-center gap-2 select-text">
                                <span class="w-1.5 h-1.5 rounded-full bg-fiot-accent"></span>
                                Викладає дисципліни
                            </h4>
                            <div class="flex flex-wrap gap-2">
                                <template x-for="disc in (modalData?.disciplines || [])" :key="disc.id">
                                    <span @click="goToSubject(disc)"
                                        class="cursor-pointer text-xs border px-3 py-1.5 rounded-xl font-mono transition-transform duration-200 shadow-sm hover:scale-105 select-text inline-block"
                                        :class="getSubjectColor(disc)"
                                        x-text="disc.name"></span>
                                </template>
                            </div>
                        </div>

                        <!-- Наукові профілі -->
                        <div>
                            <h4 class="text-xs font-mono uppercase text-fiot-accent tracking-widest mb-2.5 flex items-center gap-2 select-text">
                                <span class="w-1.5 h-1.5 rounded-full bg-fiot-accent"></span>
                                Наукові та університетські профілі
                            </h4>
                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                                <template x-if="modalData?.scopus_url">
                                    <a :href="modalData.scopus_url" target="_blank" class="flex items-center gap-2.5 p-3 rounded-2xl bg-indigo-950/80 border border-indigo-700/80 hover:border-indigo-400 hover:bg-indigo-900/80 text-xs font-mono text-indigo-100 transition-all shadow-md group select-text">
                                        <span class="text-sm group-hover:scale-110 transition-transform">📊</span> Scopus
                                    </a>
                                </template>
                                <template x-if="modalData?.orcid_url">
                                    <a :href="modalData.orcid_url" target="_blank" class="flex items-center gap-2.5 p-3 rounded-2xl bg-emerald-950/80 border border-emerald-700/80 hover:border-emerald-400 hover:bg-emerald-900/80 text-xs font-mono text-emerald-100 transition-all shadow-md group select-text">
                                        <span class="text-sm group-hover:scale-110 transition-transform">🆔</span> ORCID
                                    </a>
                                </template>
                                <template x-if="modalData?.wos_url">
                                    <a :href="modalData.wos_url" target="_blank" class="flex items-center gap-2.5 p-3 rounded-2xl bg-amber-950/80 border border-amber-700/80 hover:border-amber-400 hover:bg-amber-900/80 text-xs font-mono text-amber-100 transition-all shadow-md group select-text">
                                        <span class="text-sm group-hover:scale-110 transition-transform">🔬</span> Web of Science
                                    </a>
                                </template>
                                <template x-if="modalData?.scholar_url">
                                    <a :href="modalData.scholar_url" target="_blank" class="flex items-center gap-2.5 p-3 rounded-2xl bg-cyan-950/80 border border-cyan-700/80 hover:border-cyan-400 hover:bg-cyan-900/80 text-xs font-mono text-cyan-100 transition-all shadow-md group select-text">
                                        <span class="text-sm group-hover:scale-110 transition-transform">🎓</span> Google Scholar
                                    </a>
                                </template>
                                <template x-if="modalData?.intellect_url">
                                    <a :href="modalData.intellect_url" target="_blank" class="flex items-center gap-2.5 p-3 rounded-2xl bg-purple-950/80 border border-purple-700/80 hover:border-purple-400 hover:bg-purple-900/80 text-xs font-mono text-purple-100 transition-all shadow-md group select-text">
                                        <span class="text-sm group-hover:scale-110 transition-transform">🏛️</span> Intellect
                                    </a>
                                </template>
                            </div>
                        </div>

                    </div>

                    <div class="mt-6 pt-4 border-t border-slate-700/80 flex justify-end flex-shrink-0 relative z-10">
                        <button type="button" @click="closeModal()" class="px-5 py-3.5 bg-fiot-primary hover:bg-fiot-primary-hover text-fiot-white rounded-2xl text-xs font-bold transition-all shadow-lg shadow-fiot-primary/25 hover:scale-105 cursor-pointer">
                            Закрити досьє
                        </button>
                    </div>
                </div>
            </div>
        </template>
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // 1. Відновлюємо позицію скролу, якщо вона була збережена в sessionStorage
        const scrollPosition = sessionStorage.getItem('scrollPosition');
        if (scrollPosition !== null) {
            window.scrollTo({
                top: parseInt(scrollPosition),
                behavior: 'instant'
            });
            sessionStorage.removeItem('scrollPosition');
        }

        // 2. Додаємо збереження скролу при кліку на будь-яке посилання в блоці пагінації
        const paginationContainer = document.querySelector('.pagination-wrapper, nav[role="navigation"]');
        if (paginationContainer) {
            paginationContainer.addEventListener('click', function(e) {
                const link = e.target.closest('a');
                if (link) {
                    sessionStorage.setItem('scrollPosition', window.scrollY);
                }
            });
        }

        // 3. Зберігаємо скрол при кліку на кнопку/посилання "Скинути"
        document.querySelectorAll('a[href*="{{ route("about") }}"], .btn-outline, a[href*="about"]').forEach(el => {
            // Перевіряємо, чи це посилання є кнопкою скидання (не містить додаткових параметрів у href або веде на чистий роут)
            if (el.getAttribute('href') === '{{ route("about") }}' || el.innerText.includes('Скинути')) {
                el.addEventListener('click', function() {
                    sessionStorage.setItem('scrollPosition', window.scrollY);
                });
            }
        });
    });

    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll('nav a, nav span').forEach(el => {
            if (el.innerText.trim() === '« Previous') {
                el.innerText = 'Попередня';
            }
            if (el.innerText.trim() === 'Next »') {
                el.innerText = 'Наступна';
            }
        });
    });
</script>