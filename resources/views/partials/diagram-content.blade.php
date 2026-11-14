@php
    $selectedProgramId = $filters['program_id'] ?? ($programs->first()?->id ?? null);
@endphp

<div 
    x-data="curriculumDiagram({{ $coursesJson }}, '{{ $selectedProgramId }}')" 
    x-init="initDiagram()"
    class="w-full"
>
    <!-- Панель фільтрів (теж усередині компонента) -->
    <div class="bg-[#0b0c0f]/90 border border-white/10 rounded-2xl p-4 sm:p-5 mb-6 flex flex-col lg:flex-row items-center justify-between gap-4 shadow-2xl backdrop-blur-xl">
        <label class="flex flex-col gap-2 text-sm w-full lg:w-[400px]">
            <span class="text-gray-400 uppercase tracking-widest text-[11px] font-bold tracking-wider">Освітня програма</span>
            <select 
                @change="changeProgram($event.target.value)" 
                class="bg-[#12141c] border border-white/10 rounded-xl px-4 py-3 text-white focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 outline-none cursor-pointer text-sm transition-all w-full shadow-inner"
            >
                @foreach ($programs as $program)
                    <option value="{{ $program->id }}" @selected((string) $selectedProgramId === (string) $program->id)>
                        {{ $program->name }} {{ $program->academic_year ? '('.$program->academic_year.')' : '' }}
                    </option>
                @endforeach
            </select>
        </label>

        <div class="flex items-center gap-3 w-full lg:w-auto justify-end">
            <!-- Прямий виклик методу без глобальних функцій -->
            <button 
                type="button" 
                @click="resetDiagramPositions()"
                class="px-4 py-2.5 bg-red-500/10 hover:bg-red-500/20 text-red-400 border border-red-500/20 rounded-xl text-xs font-semibold transition-all flex items-center gap-2 shadow-sm cursor-pointer"
                title="Повернути картки на початкові місця сітки"
            >
                <span>🔄 Встановити початкове положення діаграми</span>
            </button>

            <div class="text-xs text-gray-400 text-center lg:text-right bg-white/[0.02] border border-white/5 px-4 py-2.5 rounded-xl hidden sm:flex items-center gap-2">
                <span class="text-emerald-400 font-bold">💡 Підказка:</span> 
                <span>Рухайте діаграму та картки з дисциплінами.</span>
            </div>
        </div>
    </div>

    <!-- Інтерактивна діаграма -->
    <div 
        @mousedown="startPan($event)"
        @touchstart="startPan($event)"
        @mouseup.window="stopDragAndPan()"
        @touchend.window="stopDragAndPan()"
        @mousemove.window="onMove($event)"
        @touchmove.window="onMove($event)"
        class="bg-[#040507] border border-white/10 rounded-3xl p-4 mb-20 relative shadow-2xl h-[75vh] min-h-[600px] overflow-hidden select-none cursor-grab active:cursor-grabbing"
        id="diagram-container"
    >
        @if ($disciplines->isEmpty())
            <div class="flex flex-col items-center justify-center h-full text-gray-400 space-y-3">
                <div class="text-white font-bold text-base">Не знайдено дисциплін</div>
                <p class="text-sm text-gray-500">Для обраної освітньої програми поки немає опублікованих дисциплін.</p>
            </div>
        @else
            <div 
                class="absolute top-0 left-0 w-[5000px] h-[5000px] origin-top-left will-change-transform"
                :style="`transform: translate(${panX}px, ${panY}px);`"
                id="canvas-field"
            >
                <!-- Заголовки колонок -->
                <template x-for="header in colHeaders">
                    <div 
                        :style="`transform: translate(${header.x}px, 20px); width: 300px;`" 
                        class="absolute bg-[#12141c]/95 border border-white/10 px-4 py-2.5 rounded-2xl text-center shadow-lg backdrop-blur-md z-15 flex items-center justify-center gap-2"
                    >
                        <span class="text-emerald-400 font-bold text-xs" x-text="header.year"></span>
                        <span class="text-gray-600">•</span>
                        <span class="text-indigo-300 font-semibold text-xs" x-text="header.semester"></span>
                    </div>
                </template>

                <!-- SVG шар для стрілочок -->
                <svg class="absolute top-0 left-0 pointer-events-none z-10 overflow-visible" id="connections-svg" style="width: 5000px; height: 5000px;">
                    <defs>
                        <marker id="arrow-white" viewBox="0 0 10 10" refX="6" refY="5" markerWidth="6" markerHeight="6" orient="auto-start-reverse">
                            <path d="M 0 1.5 L 10 5 L 0 8.5 z" fill="rgba(255, 255, 255, 0.9)"></path>
                        </marker>
                        <marker id="arrow-active" viewBox="0 0 10 10" refX="6" refY="5" markerWidth="7.5" markerHeight="7.5" orient="auto-start-reverse">
                            <path d="M 0 1.5 L 10 5 L 0 8.5 z" fill="#10b981"></path>
                        </marker>
                    </defs>
                    <g id="lines-group"></g>
                </svg>

                <!-- Поле для карток дисциплін -->
                <div class="absolute top-0 left-0 w-[5000px] h-[5000px] z-25">
                    @foreach ($disciplines as $course)
                        @php
                            $searchUrl = route('syllabuses', [
                                'program_id' => $course->program_id,
                                'year_of_study_id' => $course->year_of_study_id,
                                'semester_id' => $course->semester_id,
                                'q' => $course->name,
                            ]);
                        @endphp
                        <div 
                            id="disc-{{ $course->id }}"
                            @mousedown.stop="startCardDrag($event, {{ $course->id }})"
                            @touchstart.stop="startCardDrag($event, {{ $course->id }})"
                            @mouseenter="setHovered({{ $course->id }})"
                            @mouseleave="clearHovered()"
                            @click="openSyllabus('{{ $searchUrl }}', $event)"
                            :style="`transform: translate(${positions[{{ $course->id }}]?.x ?? 80}px, ${positions[{{ $course->id }}]?.y ?? 80}px);`"
                            :class="{
                                'ring-2 ring-emerald-400 bg-emerald-950/90 shadow-emerald-500/30 z-40 scale-[1.02] border-emerald-400': hoveredCourse === {{ $course->id }} || draggingCardId === {{ $course->id }},
                                'ring-1 ring-emerald-500/60 bg-emerald-950/50 z-30 border-emerald-500/50': isConnected({{ $course->id }}),
                                'border-white/25 bg-[#0d0e16] hover:border-white/40 shadow-lg': hoveredCourse !== {{ $course->id }} && !isConnected({{ $course->id }}),
                                'opacity-20 grayscale-[50%] scale-[0.98]': hoveredCourse && !isConnected({{ $course->id }}) && hoveredCourse !== {{ $course->id }}
                            }"
                            class="absolute w-[300px] p-4.5 border rounded-2xl shadow-xl transition-colors duration-150 cursor-pointer flex flex-col justify-between min-h-[135px] group will-change-transform"
                        >
                            <div class="flex items-center justify-between text-[11px] font-medium w-full mb-2">
                                <span class="px-2.5 py-0.5 bg-emerald-500/20 text-emerald-300 rounded-lg border border-emerald-500/40 font-semibold">
                                    {{ $course->yearOfStudy->name ?? 'Курс не вказано' }}
                                </span>
                                <span class="px-2.5 py-0.5 bg-indigo-500/30 text-indigo-200 rounded-lg border border-indigo-500/60 font-semibold shadow-sm">
                                    {{ $course->semester?->name ?? '—' }}
                                </span>
                            </div>

                            <div class="flex-1 flex items-center justify-center my-1">
                                <h4 class="text-white text-sm font-bold leading-snug text-center line-clamp-2 group-hover:text-emerald-300 transition-colors w-full px-1">
                                    {{ $course->name }}
                                </h4>
                            </div>

                            <div class="w-full pt-2 mt-1 border-t border-white/10 flex items-center justify-center text-[11px] font-medium text-gray-400 group-hover:text-emerald-400 transition-colors">
                                Клік для перегляду силабусу →
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    <!-- JavaScript логіка компонента -->
    <script>
        function curriculumDiagram(coursesData, programId) {
            const courses = coursesData;
            const currentProgramId = programId;

            const courseMap = {};
            courses.forEach(c => { courseMap[c.id] = c; });

            return {
                hoveredCourse: null,
                positions: {},
                colHeaders: [],
                cardWidth: 300,
                cardHeight: 135,
                
                draggingCardId: null,
                cardStartX: 0, cardStartY: 0,
                cardInitialX: 0, cardInitialY: 0,
                dragCurrentX: 0, dragCurrentY: 0,
                hasMovedCard: false,

                isPanning: false,
                panStartX: 0, panStartY: 0,
                panX: 40, panY: 40,
                rafId: null,

                initDiagram() {
                    const storageKey = `diagram_pos_${currentProgramId}`;
                    const saved = localStorage.getItem(storageKey);
                    if (saved) {
                        try { this.positions = JSON.parse(saved); } catch (e) {}
                    }
                    
                    let colMap = {};
                    let colIndex = 0;
                    let rowCounters = {};
                    let headersMap = {};

                    courses.forEach(course => {
                        const id = course.id;
                        const key = `${course.year_id || 0}_${course.semester_id || 0}`;
                        
                        if (colMap[key] === undefined) {
                            colMap[key] = colIndex++;
                            headersMap[colMap[key]] = {
                                x: 80 + (colMap[key] * 340),
                                year: course.year,
                                semester: course.semester
                            };
                        }
                        
                        const cIdx = colMap[key];
                        if (rowCounters[cIdx] === undefined) {
                            rowCounters[cIdx] = 0;
                        }
                        const rIdx = rowCounters[cIdx]++;
                        
                        const defaultX = 80 + (cIdx * 340);
                        const defaultY = 90 + (rIdx * 175);

                        if (!this.positions[id]) {
                            this.positions[id] = { x: defaultX, y: defaultY };
                        }
                    });

                    this.colHeaders = Object.values(headersMap);
                    requestAnimationFrame(() => this.updateLines());
                },

                resetDiagramPositions() {
                    const storageKey = `diagram_pos_${currentProgramId}`;
                    localStorage.removeItem(storageKey);
                    this.positions = {};
                    
                    let colMap = {};
                    let colIndex = 0;
                    let rowCounters = {};

                    courses.forEach(course => {
                        const id = course.id;
                        const key = `${course.year_id || 0}_${course.semester_id || 0}`;
                        
                        if (colMap[key] === undefined) {
                            colMap[key] = colIndex++;
                        }
                        
                        const cIdx = colMap[key];
                        if (rowCounters[cIdx] === undefined) {
                            rowCounters[cIdx] = 0;
                        }
                        const rIdx = rowCounters[cIdx]++;
                        
                        const defaultX = 80 + (cIdx * 340);
                        const defaultY = 90 + (rIdx * 175);

                        this.positions[id] = { x: defaultX, y: defaultY };

                        const el = document.getElementById(`disc-${id}`);
                        if (el) {
                            el.style.transform = `translate(${defaultX}px, ${defaultY}px)`;
                        }
                    });

                    this.updateLines();
                },

                async changeProgram(programId) {
                    const url = `{{ route('syllabuses.diagram') }}?program_id=${programId}`;
                    try {
                        const response = await fetch(url, {
                            headers: {
                                'X-Partial-Render': 'true',
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        });
                        if (response.ok) {
                            const html = await response.text();
                            document.getElementById('diagram-wrapper').innerHTML = html;
                            window.history.pushState({}, '', url);
                        } else {
                            window.location.href = url;
                        }
                    } catch (e) {
                        console.error('AJAX error:', e);
                        window.location.href = url;
                    }
                },

                getClientCoords(e) {
                    return e.touches && e.touches.length > 0 
                        ? { x: e.touches[0].clientX, y: e.touches[0].clientY }
                        : { x: e.clientX, y: e.clientY };
                },

                startPan(e) {
                    if (e.target.closest('[id^="disc-"]')) return;
                    this.isPanning = true;
                    const coords = this.getClientCoords(e);
                    this.panStartX = coords.x - this.panX;
                    this.panStartY = coords.y - this.panY;
                },

                startCardDrag(e, courseId) {
                    this.draggingCardId = courseId;
                    this.hasMovedCard = false;
                    const coords = this.getClientCoords(e);
                    this.cardStartX = coords.x;
                    this.cardStartY = coords.y;

                    const pos = this.positions[courseId] || { x: 0, y: 0 };
                    this.cardInitialX = pos.x;
                    this.cardInitialY = pos.y;
                    this.dragCurrentX = pos.x;
                    this.dragCurrentY = pos.y;
                },

                onMove(e) {
                    const coords = this.getClientCoords(e);

                    if (this.draggingCardId !== null) {
                        const dx = coords.x - this.cardStartX;
                        const dy = coords.y - this.cardStartY;

                        if (Math.abs(dx) > 3 || Math.abs(dy) > 3) this.hasMovedCard = true;

                        let newX = Math.max(10, Math.min(this.cardInitialX + dx, 4800));
                        let newY = Math.max(10, Math.min(this.cardInitialY + dy, 4800));

                        this.dragCurrentX = newX;
                        this.dragCurrentY = newY;

                        const el = document.getElementById(`disc-${this.draggingCardId}`);
                        if (el) {
                            el.style.transform = `translate(${newX}px, ${newY}px)`;
                        }

                        if (this.rafId) cancelAnimationFrame(this.rafId);
                        this.rafId = requestAnimationFrame(() => this.updateLines());
                        return;
                    }

                    if (this.isPanning) {
                        this.panX = coords.x - this.panStartX;
                        this.panY = coords.y - this.panStartY;
                    }
                },

                stopDragAndPan() {
                    if (this.draggingCardId !== null) {
                        if (this.hasMovedCard) {
                            this.positions[this.draggingCardId] = { x: this.dragCurrentX, y: this.dragCurrentY };
                            const storageKey = `diagram_pos_${currentProgramId}`;
                            localStorage.setItem(storageKey, JSON.stringify(this.positions));
                        }
                        this.draggingCardId = null;
                        this.updateLines();
                    }
                    this.isPanning = false;
                },

                openSyllabus(url, e) {
                    if (this.hasMovedCard) {
                        e.preventDefault();
                        return;
                    }
                    window.location.href = url;
                },

                setHovered(id) {
                    if (this.draggingCardId !== null) return;
                    this.hoveredCourse = id;
                    this.updateLines();
                },

                clearHovered() {
                    if (this.draggingCardId !== null) return;
                    this.hoveredCourse = null;
                    this.updateLines();
                },

                isConnected(id) {
                    if (!this.hoveredCourse) return false;
                    if (this.hoveredCourse === id) return true;
                    const hObj = courseMap[this.hoveredCourse];
                    if (!hObj) return false;
                    return hObj.prerequisites.includes(id) || hObj.successors.includes(id);
                },

                updateLines() {
                    const group = document.getElementById('lines-group');
                    if (!group) return;

                    let html = '';
                    const active = this.hoveredCourse || this.draggingCardId;

                    courses.forEach(course => {
                        const toPos = (Number(course.id) === Number(this.draggingCardId))
                            ? { x: this.dragCurrentX, y: this.dragCurrentY }
                            : this.positions[course.id];

                        if (!toPos) return;

                        course.prerequisites.forEach(prereqId => {
                            const fromPos = (Number(prereqId) === Number(this.draggingCardId))
                                ? { x: this.dragCurrentX, y: this.dragCurrentY }
                                : this.positions[prereqId];

                            if (!fromPos) return;

                            const c1x = fromPos.x + this.cardWidth / 2;
                            const c1y = fromPos.y + this.cardHeight / 2;
                            const c2x = toPos.x + this.cardWidth / 2;
                            const c2y = toPos.y + this.cardHeight / 2;

                            let x1 = c1x, y1 = c1y, x2 = c2x, y2 = c2y;
                            const dx = c2x - c1x;
                            const dy = c2y - c1y;

                            if (Math.abs(dx) > Math.abs(dy)) {
                                if (dx > 0) {
                                    x1 = fromPos.x + this.cardWidth; y1 = c1y;
                                    x2 = toPos.x; y2 = c2y;
                                } else {
                                    x1 = fromPos.x; y1 = c1y;
                                    x2 = toPos.x + this.cardWidth; y2 = c2y;
                                }
                            } else {
                                if (dy > 0) {
                                    x1 = c1x; y1 = fromPos.y + this.cardHeight;
                                    x2 = c2x; y2 = toPos.y;
                                } else {
                                    x1 = c1x; y1 = fromPos.y;
                                    x2 = c2x; y2 = toPos.y + this.cardHeight;
                                }
                            }

                            const isActive = active && (Number(course.id) === Number(active) || Number(prereqId) === Number(active));
                            
                            const stroke = isActive ? '#10b981' : 'rgba(255, 255, 255, 0.55)';
                            const width = isActive ? '3.5' : '2'; 
                            const marker = isActive ? 'url(#arrow-active)' : 'url(#arrow-white)';
                            const opacity = (active && !isActive) ? '0.1' : '0.95';

                            html += `<line x1="${x1}" y1="${y1}" x2="${x2}" y2="${y2}" stroke="${stroke}" stroke-width="${width}" marker-end="${marker}" style="opacity: ${opacity};" />`;
                        });
                    });

                    group.innerHTML = html;
                }
            };
        }
    </script>
</div>