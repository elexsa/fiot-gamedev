@extends('layouts.app')

@section('title', 'Квест Вступника | Кафедра ігрових систем')

@section('meta_description', 'Етапи вступу на освітню програму «Розробка комп’ютерних ігор» ФІОТ КПІ: дорожня карта, калькулятор НМТ та контакти менторів.')

@section('content')
<section class="relative z-10 pt-16 md:pt-24 min-h-screen flex flex-col pb-20">
    <div class="container mx-auto max-w-screen-xl px-4 md:px-8 relative z-10">

        <x-ui.page-header title="Етапи вступу" kicker="Вступникам" subtitle="Отримай статус студента. Розрахуй бали та дотримуйся дорожньої карти." />

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 mb-20">
            
            <div class="lg:col-span-7">
                <h2 class="text-2xl font-bold text-white tracking-tight mb-8">
                    Дорожня карта
                </h2>

                <div class="relative ml-4 md:ml-6 border-l border-[#333] space-y-8 pb-4">
                    
                    <div class="relative pl-8 md:pl-10">
                        <div class="absolute -left-[17px] top-1 w-8 h-8 rounded-full border border-[#555] bg-[#0b0c0f] text-gray-400 flex items-center justify-center font-bold text-xs font-mono z-10">1</div>
                        <div class="bg-[#111115] border border-[#2a2a35] p-5 md:p-6 rounded-lg w-full">
                            <div class="text-sm text-fiot-gray mb-2">Липень 2026</div>
                            <h3 class="font-bold text-white text-lg md:text-xl mb-2">Реєстрація кабінету</h3>
                            <p class="text-sm text-gray-400 leading-relaxed">Створення електронного кабінету вступника на сайті ЄДЕБО. Завантаження фотографії та необхідних документів.</p>
                        </div>
                    </div>

                    <div class="relative pl-8 md:pl-10">
                        <div class="absolute -left-[17px] top-1 w-8 h-8 rounded-full border border-[#555] bg-[#0b0c0f] text-gray-400 flex items-center justify-center font-bold text-xs font-mono z-10">2</div>
                        <div class="bg-[#111115] border border-[#2a2a35] p-5 md:p-6 rounded-lg w-full">
                            <div class="text-sm text-fiot-gray mb-2">Кінець Липня</div>
                            <h3 class="font-bold text-white text-lg md:text-xl mb-2">Подання заявки</h3>
                            <p class="text-sm text-gray-400 leading-relaxed">
                                Обирай КПІ ім. Ігоря Сікорського, ФІОТ, спеціальність F2 ІПЗ (ОПП: Програмування комп'ютерних ігор). Обов'язково став 
                                <span class="text-white font-bold tracking-wider">Пріоритет №1</span>.
                            </p>
                        </div>
                    </div>

                    <div class="relative pl-8 md:pl-10">
                        <div class="absolute -left-[17px] top-1 w-8 h-8 rounded-full border border-[#555] bg-[#0b0c0f] text-gray-400 flex items-center justify-center font-bold text-xs font-mono z-10">3</div>
                        <div class="bg-[#111115] border border-[#2a2a35] p-5 md:p-6 rounded-lg w-full">
                            <div class="text-sm text-fiot-gray mb-2">Серпень 2026</div>
                            <h3 class="font-bold text-white text-lg md:text-xl mb-2">Мотиваційний лист</h3>
                            <p class="text-sm text-gray-400 leading-relaxed">Написання та додавання мотиваційного листа. Розкажи, чому ти хочеш пов'язати життя з GameDev та чому обрав саме наш факультет.</p>
                        </div>
                    </div>

                    <div class="relative pl-8 md:pl-10">
                        <div class="absolute -left-[17px] top-1 w-8 h-8 rounded-full border border-fiot-accent bg-[#0b0c0f] text-fiot-accent flex items-center justify-center font-bold text-xs font-mono z-10 shadow-[0_0_10px_rgba(18,230,49,0.2)]">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        <div class="bg-[#111115] border border-[#2a2a35] p-5 md:p-6 rounded-lg w-full">
                            <div class="text-[10px] text-fiot-accent font-mono mb-2 uppercase tracking-widest">Кінець Серпня</div>
                            <h3 class="font-bold text-white text-lg md:text-xl mb-2">Зарахування</h3>
                            <p class="text-sm text-gray-400 leading-relaxed">Отримання рекомендації на Бюджет або Контракт. Підтвердження вибору в кабінеті. Вітаємо в команді!</p>
                        </div>
                    </div>

                </div>
            </div>

            <div class="lg:col-span-5 w-full mt-8 lg:mt-0">
                <h2 class="text-2xl font-bold text-white tracking-tight mb-8">
                    Калькулятор НМТ
                </h2>

                <div class="bg-[#0d0d0f] border border-[#2a2a35] rounded-lg shadow-2xl flex flex-col font-mono overflow-hidden">
                    <div class="h-9 bg-[#16161a] border-b border-[#2a2a35] flex items-center px-4 justify-between shrink-0">
                        <div class="flex gap-1.5 md:gap-2">
                            <div class="w-2 md:w-2.5 h-2 md:h-2.5 rounded-full bg-red-500/30"></div>
                            <div class="w-2 md:w-2.5 h-2 md:h-2.5 rounded-full bg-yellow-500/30"></div>
                            <div class="w-2 md:w-2.5 h-2 md:h-2.5 rounded-full bg-green-500/30"></div>
                        </div>
                        <span class="text-[9px] text-gray-500 uppercase tracking-widest">score_calc.exe</span>
                    </div>

                    <div class="p-6">
                        <p class="text-[10px] text-gray-500 uppercase tracking-widest mb-6">> ВВЕДІТЬ БАЛИ ПО ПРЕДМЕТАМ (100 - 200):</p>
                        
                        <div class="space-y-0 border border-[#2a2a35] rounded overflow-hidden bg-[#111115]">
                            
                            <div class="flex justify-between items-center p-3 md:p-4 border-b border-[#2a2a35]">
                                <div class="flex flex-col">
                                    <span class="text-sm text-gray-200">Математика</span>
                                    <span class="text-[9px] text-gray-500 uppercase">Коеф: 0.5</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <input type="number" id="nmt-math" class="bg-[#1a1a24] text-white text-center outline-none w-14 py-1 rounded font-bold text-sm border border-[#333] focus:border-white transition-colors" value="180" min="100" max="200">
                                    <span class="text-gray-600 text-[10px]">pts</span>
                                </div>
                            </div>
                            
                            <div class="flex justify-between items-center p-3 md:p-4 border-b border-[#2a2a35]">
                                <div class="flex flex-col">
                                    <span class="text-sm text-gray-200">Укр. мова</span>
                                    <span class="text-[9px] text-gray-500 uppercase">Коеф: 0.3</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <input type="number" id="nmt-ukr" class="bg-[#1a1a24] text-white text-center outline-none w-14 py-1 rounded font-bold text-sm border border-[#333] focus:border-white transition-colors" value="170" min="100" max="200">
                                    <span class="text-gray-600 text-[10px]">pts</span>
                                </div>
                            </div>

                            <div class="flex justify-between items-center p-3 md:p-4 border-b border-[#2a2a35]">
                                <div class="flex flex-col">
                                    <span class="text-sm text-gray-200">Історія України</span>
                                    <span class="text-[9px] text-gray-500 uppercase">Коеф: 0.2</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <input type="number" id="nmt-hist" class="bg-[#1a1a24] text-white text-center outline-none w-14 py-1 rounded font-bold text-sm border border-[#333] focus:border-white transition-colors" value="160" min="100" max="200">
                                    <span class="text-gray-600 text-[10px]">pts</span>
                                </div>
                            </div>

                            <div class="relative flex justify-between items-center p-3 md:p-4 hover:bg-[#16161a] transition-colors cursor-pointer group">
                                <select id="nmt-opt-subject" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                                    <option value="0.4" data-name="Іноземна мова">Іноземна мова</option>
                                    <option value="0.4" data-name="Фізика">Фізика</option>
                                    <option value="0.2" data-name="Біологія">Біологія</option>
                                    <option value="0.2" data-name="Хімія">Хімія</option>
                                    <option value="0.2" data-name="Географія">Географія</option>
                                    <option value="0.2" data-name="Укр. література">Укр. література</option>
                                </select>
                                
                                <div class="flex flex-col w-[50%] pointer-events-none">
                                    <div class="flex items-center gap-2">
                                        <span class="text-sm text-gray-200" id="opt-display-text">Іноземна мова</span>
                                        <svg class="w-3 h-3 text-gray-500 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    </div>
                                    <span class="text-[9px] text-gray-500 uppercase" id="opt-coef-label">Коеф: 0.4</span>
                                </div>
                                <div class="flex items-center gap-2 relative z-20"> <input type="number" id="nmt-opt-score" class="bg-[#1a1a24] text-white text-center outline-none w-14 py-1 rounded font-bold text-sm border border-[#333] focus:border-white transition-colors" value="175" min="100" max="200">
                                    <span class="text-gray-600 text-[10px]">pts</span>
                                </div>
                            </div>
                        </div>

                        <div class="mt-8 pt-5 border-t border-[#2a2a35]">
                            <div class="flex justify-between items-end mb-2">
                                <span class="text-[10px] text-gray-500 uppercase tracking-widest">> ЗАГАЛЬНИЙ БАЛ:</span>
                                <span id="calc-result" class="text-4xl font-bold text-fiot-accent drop-shadow-[0_0_10px_rgba(18,230,49,0.3)]">0.00</span>
                            </div>
                            <div class="w-full bg-[#111115] h-1.5 rounded-full overflow-hidden mb-3">
                                <div id="calc-bar" class="h-full bg-fiot-accent transition-all duration-500 w-0"></div>
                            </div>
                            <p id="calc-verdict" class="text-[10px] uppercase tracking-widest font-bold h-4 text-center text-fiot-accent">[SUCCESS] ВИСОКИЙ ШАНС НА БЮДЖЕТ!</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-10 mb-10 border-t border-[#2a2a35] pt-16">
            <div class="text-center mb-10">
                <h2 class="text-2xl md:text-3xl font-bold text-white uppercase tracking-widest mb-3">Потрібна допомога?</h2>
                <p class="text-gray-400 text-sm font-mono max-w-xl mx-auto">Зв'яжіться з нашими менторами. Ми допоможемо розібратися з пріоритетами, документами та відповімо на будь-які питання.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-4xl mx-auto">
                
                <a href="#" class="group flex items-center gap-5 bg-transparent border border-[#2AABEE]/30 p-5 md:p-6 rounded-lg hover:border-[#2AABEE] shadow-[0_0_15px_rgba(42,171,238,0.05)] hover:shadow-[0_0_25px_rgba(42,171,238,0.3)] transition-all duration-300">
                    <div class="w-12 h-12 shrink-0 flex items-center justify-center">
                        <svg class="w-10 h-10 text-[#2AABEE] group-hover:scale-110 transition-transform" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0C5.373 0 0 5.373 0 12s5.373 12 12 12 12-5.373 12-12S18.627 0 12 0zm5.894 8.221l-1.97 9.28c-.145.658-.537.818-1.084.508l-3-2.21-1.446 1.394c-.14.18-.357.295-.548.295l.189-2.663 4.86-4.386c.21-.186-.046-.289-.328-.102l-6.009 3.777-2.584-.813c-.562-.176-.575-.562.116-.833l10.09-3.892c.467-.176.883.106.714.845z"/></svg>
                    </div>
                    <div>
                        <h3 class="text-white font-bold text-lg uppercase tracking-wider mb-1 group-hover:text-[#2AABEE] transition-colors">Telegram Чат</h3>
                        <p class="text-gray-400 text-xs font-mono">Офіційна підтримка. Швидкі відповіді від адміністрації.</p>
                    </div>
                </a>

                <a href="#" class="group flex items-center gap-5 bg-transparent border border-[#5865F2]/30 p-5 md:p-6 rounded-lg hover:border-[#5865F2] shadow-[0_0_15px_rgba(88,101,242,0.05)] hover:shadow-[0_0_25px_rgba(88,101,242,0.3)] transition-all duration-300">
                    <div class="w-12 h-12 shrink-0 flex items-center justify-center">
                        <svg class="w-10 h-10 text-[#5865F2] group-hover:scale-110 transition-transform" fill="currentColor" viewBox="0 0 127.14 96.36"><path d="M107.7,8.07A105.15,105.15,0,0,0,81.47,0a72.06,72.06,0,0,0-3.36,6.83A97.68,97.68,0,0,0,49,6.83,72.37,72.37,0,0,0,45.64,0,105.89,105.89,0,0,0,19.39,8.09C2.79,32.65-1.71,56.6.54,80.21h0A105.73,105.73,0,0,0,32.71,96.36,77.7,77.7,0,0,0,39.6,85.25a68.42,68.42,0,0,1-10.85-5.18c.91-.66,1.8-1.34,2.66-2a75.57,75.57,0,0,0,64.32,0c.87.71,1.76,1.39,2.66,2a68.68,68.68,0,0,1-10.87,5.19,77,77,0,0,0,6.89,11.1A105.25,105.25,0,0,0,126.6,80.22h0C129.24,52.84,122.09,29.11,107.7,8.07ZM42.45,65.69C36.18,65.69,31,60,31,53s5-12.74,11.43-12.74S54,46,53.89,53,48.84,65.69,42.45,65.69Zm42.24,0C78.41,65.69,73.31,60,73.31,53s5-12.74,11.43-12.74S96.2,46,96.12,53,91.08,65.69,84.69,65.69Z"/></svg>
                    </div>
                    <div>
                        <h3 class="text-white font-bold text-lg uppercase tracking-wider mb-1 group-hover:text-[#5865F2] transition-colors">Discord Сервер</h3>
                        <p class="text-gray-400 text-xs font-mono">Спільнота студентів. Задавай питання та знаходь тіммейтів.</p>
                    </div>
                </a>

            </div>
        </div>

    </div>
</section>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const mathEl = document.getElementById('nmt-math');
        const ukrEl = document.getElementById('nmt-ukr');
        const histEl = document.getElementById('nmt-hist');
        const optScoreEl = document.getElementById('nmt-opt-score');
        
        const optSubjectSelect = document.getElementById('nmt-opt-subject');
        const optDisplayText = document.getElementById('opt-display-text');
        const optCoefLabel = document.getElementById('opt-coef-label');

        const resultEl = document.getElementById('calc-result');
        const barEl = document.getElementById('calc-bar');
        const verdictEl = document.getElementById('calc-verdict');

        // Оновлення тексту при виборі зі списку
        optSubjectSelect.addEventListener('change', (e) => {
            const selectedOption = e.target.options[e.target.selectedIndex];
            optDisplayText.innerText = selectedOption.getAttribute('data-name');
            optCoefLabel.innerText = `Коеф: ${e.target.value}`;
            calculateScore();
        });

        function calculateScore() {
            let vMath = parseFloat(mathEl.value) || 0;
            let vUkr = parseFloat(ukrEl.value) || 0;
            let vHist = parseFloat(histEl.value) || 0;
            let vOpt = parseFloat(optScoreEl.value) || 0;

            const kMath = 0.5;
            const kUkr = 0.3;
            const kHist = 0.2;
            const kOpt = parseFloat(optSubjectSelect.value); 

            const sumK = kMath + kUkr + kHist + kOpt;

            let finalScore = (vMath * kMath + vUkr * kUkr + vHist * kHist + vOpt * kOpt) / sumK;
            if (finalScore > 200) finalScore = 200;
            
            resultEl.innerText = finalScore > 0 ? finalScore.toFixed(2) : "0.00";

            let colorClass = "bg-gray-500";
            let textColorClass = "text-gray-500";
            let verdictText = "";

            if (finalScore === 0) {
                barEl.style.width = "0%";
                verdictText = "ОЧІКУВАННЯ ВВОДУ ДАНИХ...";
            } else if (finalScore < 130) {
                barEl.style.width = (finalScore / 200 * 100) + "%";
                colorClass = "bg-red-500";
                textColorClass = "text-red-500";
                resultEl.className = "text-4xl font-bold text-red-500 drop-shadow-[0_0_15px_rgba(239,68,68,0.6)]";
                verdictText = "[FAIL] МІНІМАЛЬНИЙ ПОРІГ НЕ ПРОЙДЕНО";
            } else if (finalScore >= 130 && finalScore < 165) {
                barEl.style.width = (finalScore / 200 * 100) + "%";
                colorClass = "bg-yellow-500";
                textColorClass = "text-yellow-500";
                resultEl.className = "text-4xl font-bold text-yellow-500 drop-shadow-[0_0_15px_rgba(234,179,8,0.6)]";
                verdictText = "[OK] ДОСТАТНЬО ДЛЯ ВСТУПУ НА КОНТРАКТ";
            } else {
                barEl.style.width = (finalScore / 200 * 100) + "%";
                colorClass = "bg-fiot-accent";
                textColorClass = "text-fiot-accent";
                resultEl.className = "text-4xl font-bold text-fiot-accent drop-shadow-[0_0_15px_rgba(18,230,49,0.6)]";
                verdictText = "[SUCCESS] ВИСОКИЙ ШАНС НА БЮДЖЕТ!";
            }

            barEl.className = `h-full transition-all duration-500 ${colorClass}`;
            verdictEl.innerText = verdictText;
            verdictEl.className = `text-[10px] uppercase tracking-widest font-bold h-4 text-center transition-colors ${textColorClass}`;
        }

        [mathEl, ukrEl, histEl, optScoreEl].forEach(el => {
            el.addEventListener('input', calculateScore);
        });

        calculateScore();
    });
</script>
@endsection