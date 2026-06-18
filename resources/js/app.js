// Default Laravel bootstrap (if you have it, keep it)
import './bootstrap';

document.addEventListener('DOMContentLoaded', () => {
    // ==========================================
    // Mobile Menu Logic
    // ==========================================
    const btn = document.getElementById('mobile-menu-btn');
    const menu = document.getElementById('mobile-menu');
    const menuIcon = document.getElementById('menu-icon');
    const closeIcon = document.getElementById('close-icon');

    if (btn && menu) {
        const closeMenu = () => {
            menu.classList.remove('opacity-100');
            menu.classList.add('opacity-0');
            
            menuIcon.classList.remove('hidden');
            closeIcon.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');

            setTimeout(() => {
                menu.classList.add('hidden');
                menu.classList.remove('flex');
            }, 300);
        };

        btn.addEventListener('click', () => {
            if (menu.classList.contains('hidden')) {
                menu.classList.remove('hidden');
                menu.classList.add('flex');
                
                setTimeout(() => {
                    menu.classList.remove('opacity-0');
                    menu.classList.add('opacity-100');
                }, 10);
                
                menuIcon.classList.add('hidden');
                closeIcon.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            } else {
                closeMenu();
            }
        });

        document.querySelectorAll('#mobile-menu a').forEach(link => {
            link.addEventListener('click', closeMenu);
        });

        menu.addEventListener('click', (e) => {
            if (e.target === menu) {
                closeMenu();
            }
        });
    }

    // ==========================================
    // Easter Egg Logic (Footer Boss)
    // ==========================================
    const boss = document.getElementById('footer-boss');
    const redStop = document.getElementById('hp-stop-red');
    const emptyStop = document.getElementById('hp-stop-empty');
    const heartContainer = document.getElementById('hp-heart-container');
    
    let hp = 2; // 2 halves = 1 full heart

    if (boss && redStop && emptyStop && heartContainer) {
        boss.addEventListener('click', () => {
            if (hp > 0) {
                hp--; 
                
                boss.classList.add('brightness-200', '-translate-y-2');
                setTimeout(() => {
                    boss.classList.remove('brightness-200', '-translate-y-2');
                }, 150);

                heartContainer.classList.add('scale-125');
                setTimeout(() => {
                    heartContainer.classList.remove('scale-125');
                }, 200);

                const percentage = (hp / 2) * 100 + '%';
                redStop.setAttribute('offset', percentage);
                emptyStop.setAttribute('offset', percentage);
                heartContainer.setAttribute('title', `${hp}/2 HP`);

            } else if (hp === 0) {
                boss.classList.add('opacity-0', 'scale-50', 'rotate-12');
                setTimeout(() => {
                    alert("GAME OVER! You have defeated the footer boss.");
                    boss.style.display = 'none';
                }, 400);
                hp--; 
            }
        });
    }
});