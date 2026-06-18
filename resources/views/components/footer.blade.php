<footer class="border-t border-fiot-dark py-8 mt-auto relative z-10 bg-fiot-black/80 backdrop-blur-md">
    <div class="container mx-auto px-6 flex flex-col md:flex-row justify-between items-center gap-4">
        
        <div class="text-fiot-gray text-sm">
            &copy; {{ date('Y') }} FICE. All rights reserved.
        </div>

        <div class="flex flex-col items-center gap-2">
            
            <div x-data x-show="$store.game.hp > 0" x-transition.opacity
                 class="w-4 h-4 flex items-center justify-center transition-all duration-300"
                 :class="$store.game.hp === 1 ? 'animate-pulse scale-110' : 'opacity-80'"
                 :title="$store.game.hp + '/2 HP'">
                 
                <svg viewBox="0 0 8 8" class="w-full h-full drop-shadow-[0_0_5px_rgba(239,68,68,0.5)]" style="shape-rendering: crispEdges;">
                    <defs>
                        <linearGradient id="hp-grad" x1="0%" y1="0%" x2="100%" y2="0%">
                            <stop :offset="($store.game.hp / 2 * 100) + '%'" stop-color="#ef4444" class="transition-all duration-300" />
                            <stop :offset="($store.game.hp / 2 * 100) + '%'" stop-color="#333333" class="transition-all duration-300" />
                        </linearGradient>
                    </defs>
                    <path fill="url(#hp-grad)" d="M1,2 L2,2 L2,1 L3,1 L3,2 L5,2 L5,1 L6,1 L6,2 L7,2 L7,4 L6,4 L6,5 L5,5 L5,6 L4,6 L4,7 L3,7 L3,6 L2,6 L2,5 L1,5 L1,4 L0,4 L0,2 L1,2 Z" />
                </svg>
            </div>

            <div x-data="{ isHit: false }" 
                 x-show="$store.game.hp > 0" 
                 x-transition.opacity.duration.400ms
                 class="h-10 flex items-end justify-center pointer-events-none group">
                
                <img src="{{ asset('images/dota_flies.gif') }}" 
                    alt="Idle Boss" 
                    @click="if($store.game.hp > 0) { $store.game.takeDamage(); isHit = true; setTimeout(() => isHit = false, 150); }"
                    :class="isHit ? 'brightness-200 -translate-y-2' : ''"
                    class="h-full w-auto drop-shadow-[0_0_8px_rgba(77,17,204,0.3)] group-hover:drop-shadow-[0_0_15px_rgba(239,68,68,0.8)] transition-all duration-100 cursor-crosshair pointer-events-auto active:scale-95" 
                    style="image-rendering: pixelated;">
            </div>

        </div>
    </div>
</footer>