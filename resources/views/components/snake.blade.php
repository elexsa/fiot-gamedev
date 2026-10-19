<div id="game-container" class="w-full h-full flex flex-col justify-between bg-[#111113] rounded-2xl border border-slate-800 shadow-2xl p-4 text-white overflow-hidden select-none">
    <!-- Upper Panel: Stats -->
    <div class="flex justify-between items-center bg-slate-900/40 px-4 py-2.5 rounded-xl mb-2 backdrop-blur-md border border-slate-850">
        <div class="flex items-center gap-5 text-xs font-bold uppercase tracking-wider text-slate-400">
            <div>Бал: <span id="current-score" class="text-sky-400 font-mono text-lg font-black ml-1 select-all">0</span></div>
            <div class="text-slate-800 font-normal">|</div>
            <div>Рекорд: <span id="high-score" class="text-amber-400 font-mono text-lg font-black ml-1 select-all">0</span></div>
        </div>
        <div id="game-status" class="text-[10px] uppercase bg-amber-500/10 text-amber-400 font-black px-2.5 py-1 rounded-md border border-amber-500/20 tracking-widest animate-pulse">
            Режим ШІ
        </div>
    </div>

    <!-- Gameplay Canvas Area -->
    <div class="relative flex-1 w-full min-h-0 flex items-center justify-center">
        <canvas id="snakeCanvas" class="w-full h-full block bg-[#0b0b0d] rounded-lg touch-none border border-slate-900/60 shadow-inner"></canvas>

        <!-- Game Over / AI Autorestart Screen -->
        <div id="overlay-screen" class="absolute inset-0 bg-[#080809]/95 backdrop-blur-md flex flex-col items-center justify-center text-center p-6 transition-all duration-300 hidden">
            <span id="overlay-icon" class="text-5xl mb-3 drop-shadow-[0_0_15px_rgba(251,191,36,0.3)]">🎓</span>
            <h2 id="overlay-title" class="text-2xl font-black text-rose-500 tracking-wide uppercase">Раунд закінчився!</h2>
            <p id="overlay-desc" class="text-slate-400 text-sm max-w-xs mt-1 mb-6">Наказ про відрахування підписано.</p>
            <p id="overlay-timer" class="text-amber-400 text-xs font-semibold mb-6 animate-pulse">Режим ШІ повернеться через 3...</p>
            <button id="start-btn" class="px-6 py-3 bg-sky-500 hover:bg-sky-400 active:scale-95 text-slate-950 text-sm font-black uppercase tracking-wider rounded-xl shadow-lg shadow-sky-500/20 transition-all">
                Почати знову
            </button>
        </div>
    </div>

    <!-- Lower Panel: Navigation Hint -->
    <div class="mt-2.5 text-center text-[10px] text-slate-500 font-semibold tracking-wider uppercase">
        <span class="lg:hidden">📱 Проведіть пальцем, щоб перехопити керування об'єктом</span>
        <span class="hidden lg:inline">⌨️ Натисніть WASD або стрілочки, щоб керувати об'єктом</span>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const canvas = document.getElementById('snakeCanvas');
        const ctx = canvas.getContext('2d');

        const currentScoreEl = document.getElementById('current-score');
        const highScoreEl = document.getElementById('high-score');
        const statusEl = document.getElementById('game-status');
        const overlay = document.getElementById('overlay-screen');
        const overlayIcon = document.getElementById('overlay-icon');
        const overlayTitle = document.getElementById('overlay-title');
        const overlayDesc = document.getElementById('overlay-desc');
        const overlayTimer = document.getElementById('overlay-timer');
        const startBtn = document.getElementById('start-btn');

        const CELL_SIZE = 20;
        const BORDER_COLOR = '#27272a';

        let cols = 0;
        let rows = 0;

        let snake = [];
        let direction = 'RIGHT';
        let nextDirection = 'RIGHT';
        let target = null;
        let score = 0;
        let highScore = parseInt(localStorage.getItem('student_snake_highscore')) || 0;
        let isAutopilot = true;
        let isGameOver = false;
        let gameLoopInterval = null;
        let aiRestartTimeout = null;
        let aiCountdownInterval = null;
        let speed = 110;

        // Максимально чисті неонові кольори з високим коефіцієнтом контрастності (WCAG AAA)
        const TARGET_TYPES = [{
                label: 'C',
                value: 5,
                color: '#f43f5e',
                shadow: 'rgba(244,63,94,0.6)',
                weight: 45
            },
            {
                label: 'B',
                value: 10,
                color: '#0ea5e9',
                shadow: 'rgba(14,165,233,0.6)',
                weight: 35
            },
            {
                label: 'A',
                value: 15,
                color: '#10b981',
                shadow: 'rgba(16,185,129,0.6)',
                weight: 15
            },
            {
                label: '📜',
                value: 30,
                color: '#f59e0b',
                shadow: 'rgba(245,158,11,0.5)',
                weight: 5
            }
        ];

        highScoreEl.textContent = highScore;

        function resizeCanvas() {
            const rect = canvas.parentElement.getBoundingClientRect();
            if (rect.width === 0 || rect.height === 0) return;

            cols = Math.floor(rect.width / CELL_SIZE);
            rows = Math.floor(rect.height / CELL_SIZE);

            canvas.width = cols * CELL_SIZE;
            canvas.height = rows * CELL_SIZE;

            if (snake.length > 0) {
                snake = snake.filter(p => p.x < cols && p.y < rows);
                if (target && (target.x >= cols || target.y >= rows)) spawnTarget();
            }
            draw();
        }

        function init() {
            const rect = canvas.parentElement.getBoundingClientRect();
            cols = Math.floor(rect.width / CELL_SIZE) || 20;
            rows = Math.floor(rect.height / CELL_SIZE) || 20;
            canvas.width = cols * CELL_SIZE;
            canvas.height = rows * CELL_SIZE;
            resetGame(true);
        }

        setTimeout(() => {
            init();
            window.addEventListener('resize', resizeCanvas);
        }, 50);

        function resetGame(autopilotMode = false) {
            clearTimeout(aiRestartTimeout);
            clearInterval(aiCountdownInterval);

            isAutopilot = autopilotMode;
            isGameOver = false;
            score = 0;
            currentScoreEl.textContent = score;
            direction = 'RIGHT';
            nextDirection = 'RIGHT';

            const midY = Math.floor(rows / 2);
            snake = [{
                    x: 4,
                    y: midY
                },
                {
                    x: 3,
                    y: midY
                },
                {
                    x: 2,
                    y: midY
                }
            ];

            spawnTarget();
            updateStatusUI();
            overlay.classList.add('hidden');

            clearInterval(gameLoopInterval);
            gameLoopInterval = setInterval(tick, speed);
        }

        function updateStatusUI() {
            if (isAutopilot) {
                statusEl.textContent = "Режим ШІ";
                statusEl.className = "text-[10px] uppercase bg-amber-500/10 text-amber-400 font-black px-2.5 py-1 rounded-md border border-amber-500/20 tracking-widest animate-pulse";
            } else {
                statusEl.textContent = "Користувач";
                statusEl.className = "text-[10px] uppercase bg-sky-500/10 text-sky-400 font-black px-2.5 py-1 rounded-md border border-sky-500/20 tracking-widest";
            }
        }

        function spawnTarget() {
            let rand = Math.random() * 100;
            let selectedType = TARGET_TYPES;
            let sum = 0;
            for (let t of TARGET_TYPES) {
                sum += t.weight;
                if (rand <= sum) {
                    selectedType = t;
                    break;
                }
            }

            let validCoords = [];
            for (let x = 1; x < cols - 1; x++) {
                for (let y = 1; y < rows - 1; y++) {
                    if (!snake.some(segment => segment.x === x && segment.y === y)) {
                        validCoords.push({
                            x,
                            y
                        });
                    }
                }
            }

            if (validCoords.length === 0) {
                endGame(true);
                return;
            }

            const coord = validCoords[Math.floor(Math.random() * validCoords.length)];
            target = {
                ...coord,
                ...selectedType
            };
        }

        function checkAndSaveHighScore() {
            if (!isAutopilot && score > highScore) {
                highScore = score;
                highScoreEl.textContent = highScore;
                localStorage.setItem('student_snake_highscore', highScore);
            }
        }

        function tick() {
            if (isGameOver) return;

            if (isAutopilot) {
                calculateAutopilotMove();
            }

            direction = nextDirection;
            let head = {
                ...snake[0]
            };

            switch (direction) {
                case 'UP':
                    head.y--;
                    break;
                case 'DOWN':
                    head.y++;
                    break;
                case 'LEFT':
                    head.x--;
                    break;
                case 'RIGHT':
                    head.x++;
                    break;
            }

            if (head.x <= 0 || head.x >= cols - 1 || head.y <= 0 || head.y >= rows - 1) {
                endGame(false);
                return;
            }

            if (snake.some((segment, index) => index !== 0 && segment.x === head.x && segment.y === head.y)) {
                endGame(false);
                return;
            }

            snake.unshift(head);

            if (head.x === target.x && head.y === target.y) {
                score += target.value;
                currentScoreEl.textContent = score;
                checkAndSaveHighScore();
                spawnTarget();
            } else {
                snake.pop();
            }

            draw();
        }

        function draw() {
            if (canvas.width === 0 || canvas.height === 0) return;

            ctx.fillStyle = '#0b0b0d';
            ctx.fillRect(0, 0, canvas.width, canvas.height);

            // Границі безпечної зони
            ctx.lineWidth = CELL_SIZE;
            ctx.strokeStyle = BORDER_COLOR;
            ctx.strokeRect(CELL_SIZE / 2, CELL_SIZE / 2, canvas.width - CELL_SIZE, canvas.height - CELL_SIZE);

            // Малювання красивої та надчіткої їжі
            if (target) {
                const tX = target.x * CELL_SIZE + CELL_SIZE / 2;
                const tY = target.y * CELL_SIZE + CELL_SIZE / 2;
                const radius = CELL_SIZE / 2 - 2;

                ctx.save();

                // 🌟 1. Рендеринг неонового світіння (Аури) під предметом
                ctx.shadowBlur = 10;
                ctx.shadowColor = target.shadow;
                ctx.fillStyle = target.color;
                ctx.beginPath();
                ctx.arc(tX, tY, radius, 0, Math.PI * 2);
                ctx.fill();

                // Вимикаємо розмиття тіні для ідеальної чіткості тексту всередині кола
                ctx.shadowBlur = 0;
                if (target.label === '📜') {
                    // Золота підкладка під диплом
                    ctx.fillStyle = 'rgba(245,158,11,0.2)';
                    ctx.beginPath();
                    ctx.arc(tX, tY, radius + 1, 0, Math.PI * 2);
                    ctx.fill();
                    ctx.font = `${CELL_SIZE * 0.7}px Arial`;
                    ctx.textAlign = 'center';
                    ctx.textBaseline = 'middle';
                    ctx.fillText(target.label, tX, tY);
                } else {
                    // Контрастний глянцевий блик у центрі
                    ctx.fillStyle = 'rgba(255, 255, 255, 0.15)';
                    ctx.beginPath();
                    ctx.arc(tX - 1.5, tY - 1.5, radius * 0.5, 0, Math.PI * 2);
                    ctx.fill();
                    // 🎯 2. Надчітке накладання тексту оцінки за вектором system-ui
                    ctx.fillStyle = '#ffffff';
                    ctx.font = `black ${CELL_SIZE * 0.55}px system-ui, -apple-system, sans-serif`;
                    ctx.textAlign = 'center';
                    ctx.textBaseline = 'middle';
                    ctx.fillText(target.label, tX, tY);
                }
                ctx.restore();
            }

            // Малювання змійки (Гравця або ШІ)
            snake.forEach((segment, index) => {
                const isHead = index === 0;
                ctx.fillStyle = isHead ?
                    (isAutopilot ? '#fbbf24' : '#38bdf8') :
                    (isAutopilot ? '#d97706' : '#0284c7');
                ctx.beginPath();
                const radius = isHead ? 6 : 4;
                ctx.roundRect(segment.x * CELL_SIZE + 1, segment.y * CELL_SIZE + 1, CELL_SIZE - 2, CELL_SIZE - 2, radius);
                ctx.fill();

                // Очі змійки з динамічним поглядом
                if (isHead) {
                    ctx.fillStyle = '#ffffff';
                    let eyeSize = 2.5;
                    let eyeOffset = 4.5;
                    let e1X = 0,
                        e1Y = 0,
                        e2X = 0,
                        e2Y = 0;
                    const headCenterX = segment.x * CELL_SIZE + CELL_SIZE / 2;
                    const headCenterY = segment.y * CELL_SIZE + CELL_SIZE / 2;

                    if (direction === 'RIGHT') {
                        e1X = headCenterX + eyeOffset;
                        e1Y = headCenterY - eyeOffset;
                        e2X = headCenterX + eyeOffset;
                        e2Y = headCenterY + eyeOffset;
                    } else if (direction === 'LEFT') {
                        e1X = headCenterX - eyeOffset;
                        e1Y = headCenterY - eyeOffset;
                        e2X = headCenterX - eyeOffset;
                        e2Y = headCenterY + eyeOffset;
                    } else if (direction === 'UP') {
                        e1X = headCenterX - eyeOffset;
                        e1Y = headCenterY - eyeOffset;
                        e2X = headCenterX + eyeOffset;
                        e2Y = headCenterY - eyeOffset;
                    } else if (direction === 'DOWN') {
                        e1X = headCenterX - eyeOffset;
                        e1Y = headCenterY + eyeOffset;
                        e2X = headCenterX + eyeOffset;
                        e2Y = headCenterY + eyeOffset;
                    }

                    ctx.beginPath();
                    ctx.arc(e1X, e1Y, eyeSize, 0, Math.PI * 2);
                    ctx.arc(e2X, e2Y, eyeSize, 0, Math.PI * 2);
                    ctx.fill();
                    ctx.fillStyle = '#000000';
                    ctx.beginPath();
                    ctx.arc(e1X, e1Y, eyeSize - 1.2, 0, Math.PI * 2);
                    ctx.arc(e2X, e2Y, eyeSize - 1.2, 0, Math.PI * 2);
                    ctx.fill();
                }
            });
        }

        function calculateAutopilotMove() {
            if (snake.length === 0 || !target) return;

            const head = snake[0];
            const moves = [{
                    dir: 'UP',
                    x: head.x,
                    y: head.y - 1
                },
                {
                    dir: 'DOWN',
                    x: head.x,
                    y: head.y + 1
                },
                {
                    dir: 'LEFT',
                    x: head.x - 1,
                    y: head.y
                },
                {
                    dir: 'RIGHT',
                    x: head.x + 1,
                    y: head.y
                }
            ];

            const safeMoves = moves.filter(m => {
                const hitWall = (m.x <= 0 || m.x >= cols - 1 || m.y <= 0 || m.y >= rows - 1);
                const hitSelf = snake.some((seg, i) => i !== 0 && seg.x === m.x && seg.y === m.y);
                const isOpposite = (direction === 'UP' && m.dir === 'DOWN') ||
                    (direction === 'DOWN' && m.dir === 'UP') ||
                    (direction === 'LEFT' && m.dir === 'RIGHT') ||
                    (direction === 'RIGHT' && m.dir === 'LEFT');
                return !hitWall && !hitSelf && !isOpposite;
            });

            if (safeMoves.length === 0) return;

            safeMoves.sort((a, b) => {
                const distA = Math.abs(a.x - target.x) + Math.abs(a.y - target.y);
                const distB = Math.abs(b.x - target.x) + Math.abs(b.y - target.y);
                return distA - distB;
            });

            nextDirection = safeMoves[0].dir;
        }

        function endGame(isWin = false) {
            isGameOver = true;
            clearInterval(gameLoopInterval);

            if (isAutopilot) {
                resetGame(true);
                return;
            }

            overlayIcon.textContent = isWin ? '👑' : '🎓';
            overlayTitle.textContent = isWin ? 'Вітаю!' : 'Раунд закінчився!';
            overlayTitle.className = isWin ? 'text-2xl font-black text-amber-400 uppercase tracking-wide' : 'text-2xl font-black text-rose-500 uppercase tracking-wide';
            overlayDesc.textContent = `Ваш результат: ${score} балів.`;
            startBtn.textContent = "Почати знову";
            overlay.classList.remove('hidden');
            let timeLeft = 3;
            overlayTimer.textContent = `Режим ШІ повернеться через ${timeLeft}...`;
            aiCountdownInterval = setInterval(() => {
                timeLeft--;

                if (timeLeft > 0) {
                    overlayTimer.textContent = `Режим ШІ повернеться через ${timeLeft}...`;
                } else {
                    clearInterval(aiCountdownInterval);
                }
            }, 1000);

            aiRestartTimeout = setTimeout(() => {
                resetGame(true);
            }, 3000);
        }

        function userTakeControl(newDir) {
            if (isGameOver) return;
            if (newDir === 'UP' && direction === 'DOWN') return;
            if (newDir === 'DOWN' && direction === 'UP') return;
            if (newDir === 'LEFT' && direction === 'RIGHT') return;
            if (newDir === 'RIGHT' && direction === 'LEFT') return;
            if (isAutopilot) {
                isAutopilot = false;
                updateStatusUI();
            }
            nextDirection = newDir;
        }

        window.addEventListener('keydown', (e) => {
            if (['ArrowUp', 'ArrowDown', 'ArrowLeft', 'ArrowRight', 'Space'].includes(e.code)) {
                e.preventDefault();
            }
            switch (e.code) {
                case 'ArrowUp':
                case 'KeyW':
                    userTakeControl('UP');
                    break;
                case 'ArrowDown':
                case 'KeyS':
                    userTakeControl('DOWN');
                    break;
                case 'ArrowLeft':
                case 'KeyA':
                    userTakeControl('LEFT');
                    break;
                case 'ArrowRight':
                case 'KeyD':
                    userTakeControl('RIGHT');
                    break;
            }
        });
        let touchStartX = 0;
        let touchStartY = 0;
        const swipeThreshold = 25;
        canvas.addEventListener('touchstart', (e) => {
            if (!e.changedTouches || !e.changedTouches[0]) return;
            touchStartX = e.changedTouches[0].screenX;
            touchStartY = e.changedTouches[0].screenY;
        }, {
            passive: true
        });
        canvas.addEventListener('touchend', (e) => {
            if (!e.changedTouches || !e.changedTouches[0]) return;
            const touchEndX = e.changedTouches[0].screenX;
            const touchEndY = e.changedTouches[0].screenY;
            const diffX = touchEndX - touchStartX;
            const diffY = touchEndY - touchStartY;
            if (Math.abs(diffX) > Math.abs(diffY)) {
                if (Math.abs(diffX) > swipeThreshold) {
                    if (diffX > 0) userTakeControl('RIGHT');
                    else userTakeControl('LEFT');
                }
            } else {
                if (Math.abs(diffY) > swipeThreshold) {
                    if (diffY > 0) userTakeControl('DOWN');
                    else userTakeControl('UP');
                }
            }
        }, {
            passive: true
        });
        startBtn.addEventListener('click', () => {
            resetGame(false);
        });
    });
</script>