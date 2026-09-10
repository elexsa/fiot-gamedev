import './bootstrap';
import './admission-calculator';
import Alpine from 'alpinejs';

window.Alpine = Alpine;

// Global game store for the easter egg logic
Alpine.store('game', {
    hp: 2, // Starting HP (2 halves = 1 full heart)
    
    // Method to handle boss damage
    takeDamage() {
        if (this.hp > 0) {
            this.hp--;
            if (this.hp === 0) {
                setTimeout(() => alert("GAME OVER! Footer Boss Defeated."), 400);
            }
        }
    }
});

// Initialize Alpine
Alpine.start();