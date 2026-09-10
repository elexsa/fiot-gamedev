@props(['config' => []])

@php
    use Illuminate\Support\Str;
    $subjects = $config['subjects'] ?? [
        ['key' => 'math', 'label' => 'Математика', 'coef' => 0.5, 'default' => 180],
        ['key' => 'ukr', 'label' => 'Українська мова', 'coef' => 0.3, 'default' => 170],
        ['key' => 'hist', 'label' => 'Історія України', 'coef' => 0.2, 'default' => 170],
    ];
    $options = $config['optional_subjects'] ?? [
        ['label' => 'Іноземна мова', 'coef' => 0.4],
        ['label' => 'Фізика', 'coef' => 0.5],
        ['label' => 'Хімія', 'coef' => 0.3],
    ];
    $thresholds = $config['thresholds'] ?? ['min' => 130, 'budget' => 165];
    $note = $config['note'] ?? 'Сума балів з урахуванням коефіцієнтів, поділена на суму коефіцієнтів.';
    $configId = 'calc-' . Str::random(8);
    $payload = json_encode(
        ['subjects' => $subjects, 'options' => $options, 'thresholds' => $thresholds],
        JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT | JSON_UNESCAPED_UNICODE
    );
@endphp

<script type="application/json" id="{{ $configId }}">{!! $payload !!}</script>

<x-ui.card class="p-6 md:p-8" x-data="admissionCalc" x-init="initCalc($el, document.getElementById('{{ $configId }}'))">
    <h3 class="text-white font-bold text-xl mb-2">Калькулятор конкурсного бала</h3>
    <p class="text-sm text-fiot-gray leading-relaxed mb-6 max-w-prose">Введіть бали НМТ від 100 до 200. {{ $note }}</p>

    <div class="border border-white/10 rounded-2xl overflow-hidden mb-6">
        <template x-for="(subject, index) in subjects" :key="subject.key">
            <div class="flex items-center justify-between gap-4 p-4 border-b border-white/10 last:border-b-0">
                <div>
                    <label :for="'nmt-' + subject.key" class="block text-sm text-white font-semibold" x-text="subject.label"></label>
                    <p class="text-xs text-fiot-gray mt-1">Коефіцієнт <span x-text="Number(subject.coef).toFixed(2)"></span></p>
                </div>
                <input :id="'nmt-' + subject.key" type="number" min="100" max="200" step="1" x-model.number="subject.score" x-on:input="clamp(index)" class="w-20 rounded-md border border-white/10 bg-fiot-black px-3 py-2 text-center text-sm font-semibold text-white outline-none focus:border-fiot-accent">
            </div>
        </template>
        <div class="flex items-center justify-between gap-4 p-4">
            <div class="flex-1">
                <label for="nmt-opt" class="block text-sm text-white font-semibold">Четвертий предмет</label>
                <select id="nmt-opt" x-model.number="optCoef" class="mt-2 rounded-md border border-white/10 bg-fiot-black px-3 py-2 text-sm text-white outline-none focus:border-fiot-accent">
                    <template x-for="opt in options" :key="opt.label">
                        <option :value="opt.coef" x-text="opt.label + ' - ' + Number(opt.coef).toFixed(2)"></option>
                    </template>
                </select>
            </div>
            <input id="nmt-opt-score" type="number" min="100" max="200" step="1" x-model.number="optScore" x-on:input="clampOpt()" class="w-20 shrink-0 rounded-md border border-white/10 bg-fiot-black px-3 py-2 text-center text-sm font-semibold text-white outline-none focus:border-fiot-accent">
        </div>
    </div>

    <div class="rounded-2xl border border-white/10 bg-fiot-black p-5">
        <div class="flex items-end justify-between gap-4 mb-3">
            <p class="text-sm text-fiot-gray">Конкурсний бал</p>
            <p class="text-4xl font-bold text-white" x-text="result.toFixed(2)"></p>
        </div>
        <div class="h-2 overflow-hidden rounded-full bg-white/10">
            <div class="h-full rounded-full bg-fiot-primary transition-all duration-300" :class="barClass" :style="'width: ' + Math.min(100, result / 2) + '%'"></div>
        </div>
        <p class="mt-3 text-sm leading-relaxed" :class="verdictClass" x-text="verdict"></p>
    </div>
</x-ui.card>
