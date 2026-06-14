<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Розробка ігор | ФІОТ КПІ')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#0b0c0f] text-white antialiased font-body overflow-x-hidden selection:bg-fiot-accent selection:text-black flex flex-col min-h-screen">

    <div class="fixed inset-0 pointer-events-none z-0">
        <!-- <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_center,_var(--tw-gradient-stops))] from-fiot-dark/40 via-transparent to-transparent"></div> -->
        <div class="absolute top-[-10%] left-[-10%] w-[80%] h-[80%] bg-fiot-primary/15 rounded-full blur-[180px]"></div>
        <div class="absolute bottom-[-20%] right-[-10%] w-[60%] h-[60%] bg-fiot-accent/10 rounded-full blur-[150px]"></div>
        <!-- <div class="absolute inset-0 bg-[linear-gradient(to_right,#14161C_1px,transparent_1px),linear-gradient(to_bottom,#14161C_1px,transparent_1px)] bg-[size:40px_40px] md:bg-[size:80px_80px] opacity-30"></div> -->
    </div>

    @include('components.navbar')

    <main class="flex-grow">
        @yield('content')
    </main>

    @include('components.footer')

    <script>
        // Логіка Мобільного Меню
        const btn = document.getElementById('mobile-menu-btn');
        const menu = document.getElementById('mobile-menu');
        const menuIcon = document.getElementById('menu-icon');
        const closeIcon = document.getElementById('close-icon');

        if(btn && menu) {
            // Функція для плавного закриття меню
            const closeMenu = () => {
                // Крок 1: Запускаємо анімацію зникнення (opacity)
                menu.classList.remove('opacity-100');
                menu.classList.add('opacity-0');
                
                // Одразу повертаємо іконку гамбургера та розблоковуємо скрол
                menuIcon.classList.remove('hidden');
                closeIcon.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');

                // Крок 2: Чекаємо 300мс (тривалість анімації), а потім ховаємо блок остаточно
                setTimeout(() => {
                    menu.classList.add('hidden');
                    menu.classList.remove('flex');
                }, 300);
            };

            // Клік по гамбургеру (відкрити/закрити)
            btn.addEventListener('click', () => {
                if (menu.classList.contains('hidden')) {
                    // Відкриваємо: спочатку показуємо блок, потім плавно робимо видимим
                    menu.classList.remove('hidden');
                    menu.classList.add('flex');
                    
                    // Невелика затримка, щоб браузер встиг відрендерити flex перед анімацією
                    setTimeout(() => {
                        menu.classList.remove('opacity-0');
                        menu.classList.add('opacity-100');
                    }, 10);
                    
                    menuIcon.classList.add('hidden');
                    closeIcon.classList.remove('hidden');
                    document.body.classList.add('overflow-hidden');
                } else {
                    // Закриваємо
                    closeMenu();
                }
            });

            // Закриття при кліку на посилання
            document.querySelectorAll('#mobile-menu a').forEach(link => {
                link.addEventListener('click', closeMenu);
            });

            // Закриття при кліку на пусту область (фон)
            menu.addEventListener('click', (e) => {
                if (e.target === menu) {
                    closeMenu();
                }
            });
        }
    </script>
    
    @yield('scripts')
</body>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const boss = document.getElementById('footer-boss');
            const redStop = document.getElementById('hp-stop-red');
            const emptyStop = document.getElementById('hp-stop-empty');
            const heartContainer = document.getElementById('hp-heart-container');
            
            let hp = 2; // 2 половинки = 1 ціле серце

            if (boss && redStop && emptyStop) {
                boss.addEventListener('click', () => {
                    if (hp > 0) {
                        hp--; // Забираємо половину серця
                        
                        // Ефект отримання шкоди босом (блимає білим і підстрибує)
                        boss.classList.add('brightness-200', '-translate-y-2');
                        setTimeout(() => {
                            boss.classList.remove('brightness-200', '-translate-y-2');
                        }, 150);

                        // Ефект удару по сердечку (збільшується на мить)
                        heartContainer.classList.add('scale-125');
                        setTimeout(() => {
                            heartContainer.classList.remove('scale-125');
                        }, 200);

                        // Оновлюємо градієнт сердечка (100% -> 50% -> 0%)
                        const percentage = (hp / 2) * 100 + '%';
                        redStop.setAttribute('offset', percentage);
                        emptyStop.setAttribute('offset', percentage);
                        heartContainer.setAttribute('title', `${hp}/2 HP`);

                    } else if (hp === 0) {
                        // Якщо HP закінчились - бос "вмирає"
                        boss.classList.add('opacity-0', 'scale-50', 'rotate-12');
                        setTimeout(() => {
                            alert("GAME OVER! Ви знищили боса футера.");
                            boss.style.display = 'none'; // Ховаємо його
                        }, 400);
                        hp--; // Щоб клік більше не працював
                    }
                });
            }
        });
    </script>
</html>