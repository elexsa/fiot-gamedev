@php
$openStaffId = request()->query('staff_id');
$initialStaff = null;

if ($openStaffId) {
$initialStaff = collect($staff->items())->firstWhere('id', $openStaffId);
if (!$initialStaff) {
$initialStaff = \App\Models\Staff::with([
'achievements' => fn ($q) => $q->orderBy('year', 'desc'),
'degree',
'academicRank',
'position',
'disciplines'
])
->published()
->find($openStaffId);
}
}
@endphp

<div
    x-data="{
         searchQuery: '{{ $filters['q'] ?? '' }}',
         perPage: '{{ $filters['per_page'] ?? 9 }}',
         isModalOpen: {{ $initialStaff ? 'true' : 'false' }},
         modalData: {{ $initialStaff ? json_encode($initialStaff) : 'null' }},
         isLoadingModal: false,
         isLoadingList: false,
         searchController: null,
         colorCache: {},
         preloadedCache: {},

         init() {
            if (this.isModalOpen) {
                document.body.classList.add('modal-open');
            }

            // Повна синхронізація історії браузера (стрілки Назад / Вперед)
            window.addEventListener('popstate', (event) => {
                const urlParams = new URLSearchParams(window.location.search);
                
                if (!urlParams.has('staff_id') && this.isModalOpen) {
                    this.closeModal(false);
                }

                if (!urlParams.has('staff_id')) {
                    this.searchQuery = urlParams.get('q') || '';
                    this.perPage = urlParams.get('per_page') || 9;
                    this.fetchStaff(window.location.href, false);
                }
            });
        },

        // Живий пошук із захистом від гонки запитів (AbortController)
        async fetchStaff(customUrl = null, pushState = true) {
            if (this.searchController) {
                this.searchController.abort();
            }
            this.searchController = new AbortController();

            this.isLoadingList = true;
            const url = customUrl || `{{ route('about') }}?q=${encodeURIComponent(this.searchQuery)}&per_page=${this.perPage}`;

            try {
                const response = await fetch(url, {
                    signal: this.searchController.signal,
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });
                if (response.ok) {
                    const html = await response.text();
                    document.getElementById('staff-results-container').innerHTML = html;
                    if (pushState) {
                        window.history.pushState({ path: url }, '', url);
                    }
                }
            } catch (error) {
                if (error.name !== 'AbortError') {
                    console.error('Помилка оновлення списку:', error);
                }
            } finally {
                this.isLoadingList = false;
            }
        },

        async preloadDetails(id) {
            if (this.preloadedCache[id]) return;
            try {
                const response = await fetch(`/staff/${id}/details`);
                if (response.ok) {
                    this.preloadedCache[id] = await response.json();
                }
            } catch (error) {}
        },

        async openModal(memberOrId) {
            const id = typeof memberOrId === 'object' && memberOrId !== null ? memberOrId.id : memberOrId;
            
            if (typeof memberOrId === 'object' && memberOrId !== null) {
                this.modalData = memberOrId;
            }

            this.isModalOpen = true;
            document.body.classList.add('modal-open');

            const url = new URL(window.location);
            url.searchParams.set('staff_id', id);
            window.history.pushState({ staffModal: id }, '', url);

            if (this.preloadedCache[id]) {
                this.modalData = this.preloadedCache[id];
                return;
            }

            this.isLoadingModal = true;
            try {
                const response = await fetch(`/staff/${id}/details`);
                if (response.ok) {
                    const data = await response.json();
                    this.modalData = data;
                    this.preloadedCache[id] = data;
                }
            } catch (error) {
                console.error('Помилка завантаження деталей:', error);
            } finally {
                this.isLoadingModal = false;
            }
        },

        closeModal(updateHistory = true) {
            if (!this.isModalOpen) return;
            this.isModalOpen = false;
            document.body.classList.remove('modal-open');
            
            if (updateHistory) {
                const url = new URL(window.location);
                if (url.searchParams.has('staff_id')) {
                    url.searchParams.delete('staff_id');
                    window.history.replaceState({}, '', url);
                }
            }

            requestAnimationFrame(() => {
                setTimeout(() => {
                    this.modalData = null;
                }, 150);
            });
        },

         goToSubject(disc, memberId) {
            const discName = typeof disc === 'object' && disc !== null ? disc.name : disc;
            
            if (discName && memberId) {
                window.location.href = `/syllabuses?discipline_name=${encodeURIComponent(discName)}&staff_id=${encodeURIComponent(memberId)}`;
            } else if (typeof disc === 'object' && disc !== null && disc.id) {
                // Fallback, якщо передано лише ID
                window.location.href = `/syllabuses?syllabus_id=${encodeURIComponent(disc.id)}`;
            }
        },

         getSubjectColor(subjectOrDisc) {
             let id = typeof subjectOrDisc === 'object' && subjectOrDisc !== null ? (subjectOrDisc.id || subjectOrDisc.name) : subjectOrDisc;
             if (!id) return 'bg-sky-950 border-sky-800 text-sky-100';

             if (this.colorCache[id]) {
                 return this.colorCache[id];
             }

             let hash = 0;
             let strId = String(id);
             for (let i = 0; i < strId.length; i++) {
                 hash = strId.charCodeAt(i) + ((hash << 5) - hash);
             }

             const colors = [
                 'bg-cyan-950 border-cyan-800 text-cyan-100',
                 'bg-sky-950 border-sky-800 text-sky-100',
                 'bg-blue-950 border-blue-800 text-blue-100',
                 'bg-indigo-950 border-indigo-800 text-indigo-100',
                 'bg-violet-950 border-violet-800 text-violet-100',
                 'bg-purple-950 border-purple-800 text-purple-100',
                 'bg-fuchsia-950 border-fuchsia-800 text-fuchsia-100',
                 'bg-pink-950 border-pink-800 text-pink-100',
                 'bg-rose-950 border-rose-800 text-rose-100',
                 'bg-emerald-950 border-emerald-800 text-emerald-100',
                 'bg-teal-950 border-teal-800 text-teal-100',
                 'bg-amber-950 border-amber-800 text-amber-100'
             ];

             const resolvedColor = colors[Math.abs(hash) % colors.length];
             this.colorCache[id] = resolvedColor;
             return resolvedColor;
         }
     }">

    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full max-w-7xl h-[350px] bg-gradient-to-b from-fiot-primary/10 via-transparent to-transparent blur-[60px] pointer-events-none"></div>

    <div class="relative container mx-auto px-4 py-16 max-w-7xl">

        <!-- ШАПКА ТА ПОШУК -->
        <header class="flex flex-col lg:flex-row justify-between items-start lg:items-end gap-6 mb-8 pb-8 border-b border-fiot-dark">
            <div>
                <h1 class="font-large-heading text-4xl md:text-6xl font-extrabold tracking-tight text-fiot-white bg-gradient-to-r from-fiot-white via-slate-200 to-fiot-accent bg-clip-text text-transparent select-text">
                    Викладацький склад
                </h1>
                <p class="text-fiot-gray text-sm md:text-base mt-3 max-w-2xl leading-relaxed font-body select-text">
                    На кафедрі працюють досвідчені викладачі.
                </p>
            </div>

            <!-- Живий пошуковий рядок -->
            <div class="w-full lg:w-96 flex gap-2">
                <div class="relative flex-1">
                    <span class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-fiot-gray">🔍</span>
                    <input type="text"
                        id="search"
                        x-model="searchQuery"
                        @input.debounce.300ms="fetchStaff()"
                        placeholder="Пошук за ПІБ, посадою..."
                        class="bg-fiot-dark/90 border border-fiot-primary/30 hover:border-fiot-primary/60 rounded-2xl pl-11 pr-4 py-3.5 text-xs text-fiot-white placeholder-fiot-gray focus:outline-none focus:border-fiot-primary focus:ring-4 focus:ring-fiot-primary/20 transition-all w-full shadow-lg font-body">
                    <template x-if="searchQuery">
                        <button type="button" @click="searchQuery = ''; fetchStaff();" class="absolute inset-y-0 right-0 pr-4 flex items-center text-fiot-gray hover:text-fiot-white text-xs font-mono cursor-pointer">
                            ✕
                        </button>
                    </template>
                </div>
            </div>
        </header>

        <!-- КОНТЕЙНЕР ДЛЯ ДИНАМІЧНОГО ОНОВЛЕННЯ -->
        <div id="staff-results-container" class="relative transition-opacity duration-200" :class="{ 'opacity-50 pointer-events-none': isLoadingList }">
            @include('partials.staff-grid-content', ['staff' => $staff, 'filters' => $filters, 'perPageOptions' => $perPageOptions])
        </div>

        <!-- МОДАЛЬНИЙ ІНСПЕКТОР (ДОСЬЄ) -->
        <template x-teleport="body">
            <div x-show="isModalOpen"
                x-cloak
                class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/80 overflow-y-auto overscroll-contain"
                x-transition:enter="transition ease-out duration-150 transform-gpu"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-100 transform-gpu"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                @keydown.escape.window="closeModal()">

                <div @click.outside="closeModal()"
                    class="bg-slate-900 border border-fiot-primary/50 w-full max-w-2xl rounded-3xl p-6 md:p-8 relative shadow-2xl max-h-[90vh] flex flex-col select-text will-change-transform transform-gpu"
                    x-transition:enter="transition ease-out duration-150 transform-gpu"
                    x-transition:enter-start="opacity-0 scale-95 translate-y-1"
                    x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-100 transform-gpu"
                    x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                    x-transition:leave-end="opacity-0 scale-95 translate-y-1">

                    <div x-show="isLoadingModal" class="absolute inset-0 bg-slate-900/60 backdrop-blur-[2px] rounded-3xl z-40 flex items-center justify-center">
                        <div class="w-8 h-8 border-4 border-fiot-primary border-t-transparent rounded-full animate-spin"></div>
                    </div>

                    <button type="button"
                        @click="closeModal()"
                        class="absolute top-5 right-5 z-30 text-fiot-gray hover:text-fiot-white bg-slate-800 hover:bg-fiot-primary/30 border border-slate-700 p-2.5 rounded-full transition-all text-xs font-mono cursor-pointer shadow-md"
                        aria-label="Закрити досьє">
                        ✕
                    </button>

                    <!-- Шапка досьє -->
                    <div class="flex items-start gap-5 mb-6 pb-6 border-b border-slate-800 relative z-10 select-text">
                        <template x-if="modalData?.avatar_url">
                            <img :src="modalData.avatar_url" width="128" height="128" class="w-24 h-24 md:w-32 md:h-32 rounded-2xl object-cover border-2 border-fiot-primary shadow-lg flex-shrink-0" alt="Фото викладача">
                        </template>
                        <template x-if="!modalData?.avatar_url">
                            <div class="w-24 h-24 md:w-32 md:h-32 rounded-2xl bg-slate-800 border-2 border-fiot-primary shadow-lg flex items-center justify-center flex-shrink-0 text-fiot-accent font-large-heading text-4xl md:text-5xl font-bold select-none"
                                x-text="modalData?.last_name ? modalData.last_name.charAt(0).toUpperCase() : '?'">
                            </div>
                        </template>

                        <div class="space-y-3">
                            <template x-if="modalData?.position?.name">
                                <div class="flex flex-wrap gap-2">
                                    <span class="inline-block px-3 py-1 rounded-xl border text-xs font-sans select-text"
                                        :class="modalData?.position_color">
                                        <strong class="font-normal opacity-85">Посада:</strong>
                                        <span class="font-semibold" x-text="modalData?.position?.name"></span>
                                    </span>
                                </div>
                            </template>

                            <h2 class="font-large-heading text-2xl md:text-3xl font-extrabold text-fiot-white tracking-tight leading-tight select-text" x-text="`${modalData?.last_name ?? ''} ${modalData?.first_name ?? ''} ${modalData?.patronymic ?? ''}`"></h2>

                            <template x-if="modalData?.degree?.name || modalData?.academic_rank?.name">
                                <div class="flex flex-wrap gap-2 pt-1 text-xs font-sans">
                                    <template x-if="modalData?.degree?.name">
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl border select-text"
                                            :class="modalData?.degree_color">
                                            <strong class="font-normal opacity-85">Науковий ступінь:</strong>
                                            <span class="font-semibold" x-text="modalData?.degree?.name"></span>
                                        </span>
                                    </template>
                                    <template x-if="modalData?.academic_rank?.name">
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl border select-text"
                                            :class="modalData?.rank_color">
                                            <strong class="font-normal opacity-85">Вчене звання:</strong>
                                            <span class="font-semibold" x-text="modalData?.academic_rank?.name"></span>
                                        </span>
                                    </template>
                                </div>
                            </template>
                        </div>
                    </div>

                    <!-- Контент профілю -->
                    <div class="space-y-6 overflow-y-auto pr-2 flex-1 relative z-10 custom-scrollbar select-text overscroll-contain">
                        <div x-show="modalData?.bio">
                            <h4 class="text-xs font-mono uppercase text-fiot-accent tracking-widest mb-2 flex items-center gap-2 select-text">
                                <span class="w-1.5 h-1.5 rounded-full bg-fiot-accent"></span>
                                Про викладача
                            </h4>
                            <p class="text-slate-200 text-sm md:text-base leading-relaxed bg-slate-950 p-4 rounded-2xl border border-slate-800 font-body select-text" x-text="modalData?.bio"></p>
                        </div>

                        <!-- ХРОНОЛОГІЯ ПОДІЙ ТА ДОСЯГНЕНЬ -->
                        <div x-show="modalData && modalData.achievements && modalData.achievements.length > 0" class="space-y-4">
                            <h4 class="text-xs font-mono uppercase text-fiot-accent tracking-widest mb-3 flex items-center gap-2.5 select-text">
                                <span class="w-2 h-2 rounded-full bg-fiot-accent"></span>
                                Хронологія подій та досягнень
                            </h4>
                            <div class="relative pl-8 pr-2 space-y-4 before:content-[''] before:absolute before:left-3 before:top-3 before:bottom-3 before:w-0.5 before:bg-slate-800 select-text">
                                <template x-for="(ach, index) in (modalData?.achievements || [])" :key="ach.id || index">
                                    <div class="relative group/item">
                                        <div class="absolute -left-8 top-1.5 w-4 h-4 rounded-full bg-slate-950 border-2 border-fiot-primary flex items-center justify-center z-10"></div>
                                        <div class="bg-slate-950 border border-slate-800 p-4 rounded-2xl shadow-sm">
                                            <div class="flex items-center justify-between gap-2 mb-2">
                                                <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-xl bg-fiot-primary/15 border border-fiot-primary/30 text-fiot-accent font-mono text-xs">
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
                                <template x-for="disc in (modalData?.disciplines ? Array.from(new Map(modalData.disciplines.map(d => [d.name, d])).values()) : [])" :key="disc.name">
                                    <span @click="goToSubject(disc, modalData.id)"
                                        class="cursor-pointer text-xs border px-3 py-1.5 rounded-xl font-mono transition-transform duration-150 transform-gpu hover:scale-105 select-text inline-block"
                                        :class="getSubjectColor(disc)"
                                        x-text="disc.name"></span>
                                </template>
                            </div>
                        </div>

                        <!-- Профілі -->
                        <div>
                            <h4 class="text-xs font-mono uppercase text-fiot-accent tracking-widest mb-2.5 flex items-center gap-2 select-text">
                                <span class="w-1.5 h-1.5 rounded-full bg-fiot-accent"></span>
                                Наукові та університетські профілі
                            </h4>
                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                                <template x-if="modalData?.scopus_url">
                                    <a :href="modalData.scopus_url" target="_blank" class="flex items-center gap-2.5 p-3 rounded-2xl bg-indigo-950 border border-indigo-800 hover:bg-indigo-900 text-xs font-mono text-indigo-100 transition-colors">📊 Scopus</a>
                                </template>
                                <template x-if="modalData?.orcid_url">
                                    <a :href="modalData.orcid_url" target="_blank" class="flex items-center gap-2.5 p-3 rounded-2xl bg-emerald-950 border border-emerald-800 hover:bg-emerald-900 text-xs font-mono text-emerald-100 transition-colors">🆔 ORCID</a>
                                </template>
                                <template x-if="modalData?.wos_url">
                                    <a :href="modalData.wos_url" target="_blank" class="flex items-center gap-2.5 p-3 rounded-2xl bg-amber-950 border border-amber-800 hover:bg-amber-900 text-xs font-mono text-amber-100 transition-colors">🔬 Web of Science</a>
                                </template>
                                <template x-if="modalData?.scholar_url">
                                    <a :href="modalData.scholar_url" target="_blank" class="flex items-center gap-2.5 p-3 rounded-2xl bg-cyan-950 border border-cyan-800 hover:bg-cyan-900 text-xs font-mono text-cyan-100 transition-colors">🎓 Google Scholar</a>
                                </template>
                                <template x-if="modalData?.intellect_url">
                                    <a :href="modalData.intellect_url" target="_blank" class="flex items-center gap-2.5 p-3 rounded-2xl bg-purple-950 border border-purple-800 hover:bg-purple-900 text-xs font-mono text-purple-100 transition-colors">🏛️ Intellect</a>
                                </template>
                            </div>
                        </div>

                    </div>

                    <div class="mt-6 pt-4 border-t border-slate-800 flex justify-end flex-shrink-0 relative z-10">
                        <button type="button" @click="closeModal()" class="px-5 py-3.5 bg-fiot-primary hover:bg-fiot-primary-hover text-fiot-white rounded-2xl text-xs font-bold transition-all shadow-lg cursor-pointer">
                            Закрити досьє
                        </button>
                    </div>
                </div>
            </div>
        </template>
    </div>
</div>