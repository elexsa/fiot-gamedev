document.addEventListener('alpine:init', () => {
    window.Alpine.data('admissionCalc', () => ({
        subjects: [],
        options: [],
        thresholds: { min: 130, budget: 165 },
        optCoef: 0.3,
        optScore: 170,
        initCalc(el, configEl) {
            try {
                const cfg = JSON.parse(configEl?.textContent || '{}');
                this.subjects = (cfg.subjects || []).map((s) => ({ ...s, score: Number(s.default ?? 150) }));
                this.options = cfg.options || [];
                this.thresholds = {
                    min: Number(cfg.thresholds?.min ?? 130),
                    budget: Number(cfg.thresholds?.budget ?? 165),
                };
                this.optCoef = Number(this.options[0]?.coef ?? 0.3);
            } catch (e) {
                console.error('Calculator config parse error', e);
            }
        },
        clamp(index) {
            const s = this.subjects[index];
            if (!s || Number.isNaN(s.score)) return;
            s.score = Math.min(200, Math.max(0, Math.round(s.score)));
        },
        clampOpt() {
            if (Number.isNaN(this.optScore)) return;
            this.optScore = Math.min(200, Math.max(0, Math.round(this.optScore)));
        },
        get result() {
            let sum = 0;
            let coefs = 0;
            for (const s of this.subjects) {
                sum += (Number(s.score) || 0) * (Number(s.coef) || 0);
                coefs += Number(s.coef) || 0;
            }
            sum += (Number(this.optScore) || 0) * Number(this.optCoef);
            coefs += Number(this.optCoef);
            if (!coefs) return 0;
            return Math.min(200, sum / coefs);
        },
        get verdict() {
            if (this.result <= 0) return 'Введіть бали, щоб побачити результат.';
            if (this.result < this.thresholds.min) return 'Ех, нижче мінімального порогу. Перегляньте умови вступу';
            if (this.result < this.thresholds.budget) return 'Достатньо для заяви на контракт. Для бюджету варто мати вищий бал.';
            return 'Добрий шанс на бюджет. Подавайте заяву з першим пріоритетом.';
        },
        get verdictClass() {
            if (this.result <= 0) return 'text-fiot-gray';
            if (this.result < this.thresholds.min) return 'text-red-400';
            if (this.result < this.thresholds.budget) return 'text-yellow-300';
            return 'text-fiot-accent';
        },
        get barClass() {
            return this.result >= this.thresholds.budget ? '!bg-fiot-accent' : '';
        },
    }));
});
