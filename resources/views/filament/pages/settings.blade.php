<x-filament-panels::page>
    <div class="space-y-8">
        {{-- Contacts Section --}}
        <x-filament::section heading="Контакти" description="Контактна інформація кафедри (відображається у футері)">
            <x-filament::card>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <x-filament::input.wrapper label="Адреса">
                        <x-filament::input
                            type="text"
                            wire:model="contacts.address"
                            placeholder="м. Київ, просп. Політехнічний 41..."
                        />
                    </x-filament::input.wrapper>

                    <x-filament::input.wrapper label="Телефон">
                        <x-filament::input
                            type="text"
                            wire:model="contacts.phone"
                            placeholder="+380 (44) 204 XX XX"
                        />
                    </x-filament::input.wrapper>

                    <x-filament::input.wrapper label="Email">
                        <x-filament::input
                            type="email"
                            wire:model="contacts.email"
                            placeholder="gamedev@kpi.ua"
                        />
                    </x-filament::input.wrapper>

                    <x-filament::input.wrapper label="Telegram">
                        <x-filament::input
                            type="url"
                            wire:model="contacts.telegram"
                            placeholder="https://t.me/..."
                        />
                    </x-filament::input.wrapper>

                    <x-filament::input.wrapper label="Discord">
                        <x-filament::input
                            type="url"
                            wire:model="contacts.discord"
                            placeholder="https://discord.gg/..."
                        />
                    </x-filament::input.wrapper>

                    <x-filament::input.wrapper label="Facebook">
                        <x-filament::input
                            type="url"
                            wire:model="contacts.facebook"
                            placeholder="https://facebook.com/..."
                        />
                    </x-filament::input.wrapper>
                </div>

                <div class="mt-6">
                    <x-filament::button wire:click="saveContacts" color="primary">
                        Зберегти контакти
                    </x-filament::button>
                </div>
            </x-filament::card>
        </x-filament::section>

        {{-- Stats Section --}}
        <x-filament::section heading="Статистика" description="Статистика на головній сторінці та сторінці 'Про кафедру'">
            <x-filament::card>
                <div class="space-y-4">
                    @foreach ($stats as $index => $stat)
                        <div class="flex items-center gap-4 p-4 bg-gray-50 dark:bg-gray-800 rounded-lg">
                            <div class="flex-1">
                                <x-filament::input.wrapper label="Значення">
                                    <x-filament::input
                                        type="text"
                                        wire:model="stats.{{ $index }}.value"
                                        placeholder="120+"
                                    />
                                </x-filament::input.wrapper>
                            </div>
                            <div class="flex-1">
                                <x-filament::input.wrapper label="Підпис">
                                    <x-filament::input
                                        type="text"
                                        wire:model="stats.{{ $index }}.label"
                                        placeholder="студентів на програмі"
                                    />
                                </x-filament::input.wrapper>
                            </div>
                            <x-filament::button
                                wire:click="removeStat({{ $index }})"
                                color="danger"
                                size="sm"
                                icon="heroicon-o-trash"
                            >
                            </x-filament::button>
                        </div>
                    @endforeach

                    <div class="flex items-center gap-4">
                        <x-filament::button
                            wire:click="addStat"
                            color="gray"
                            icon="heroicon-o-plus"
                        >
                            Додати статистику
                        </x-filament::button>

                        <x-filament::button wire:click="saveStats" color="primary">
                            Зберегти статистику
                        </x-filament::button>
                    </div>
                </div>
            </x-filament::card>
        </x-filament::section>
        {{-- Admission steps --}}
        <x-filament::section heading="Етапи вступу" description="Дорожня карта вступника">
            <x-filament::card>
                <div class="space-y-4">
                    @foreach ($admissionSteps as $index => $step)
                        <div class="grid grid-cols-1 gap-4 p-4 bg-gray-50 dark:bg-gray-800 rounded-lg">
                            <x-filament::input.wrapper label="Дата">
                                <x-filament::input type="text" wire:model="admissionSteps.{{ $index }}.date" placeholder="Липень 2026" />
                            </x-filament::input.wrapper>
                            <x-filament::input.wrapper label="Заголовок">
                                <x-filament::input type="text" wire:model="admissionSteps.{{ $index }}.title" placeholder="Реєстрація кабінету" />
                            </x-filament::input.wrapper>
                            <x-filament::input.wrapper label="Опис">
                                <x-filament::input type="text" wire:model="admissionSteps.{{ $index }}.text" placeholder="Короткий опис кроку" />
                            </x-filament::input.wrapper>
                            <div>
                                <x-filament::button wire:click="removeAdmissionStep({{ $index }})" color="danger" size="sm" icon="heroicon-o-trash"></x-filament::button>
                            </div>
                        </div>
                    @endforeach
                    <div class="flex items-center gap-4">
                        <x-filament::button wire:click="addAdmissionStep" color="gray" icon="heroicon-o-plus">Додати етап</x-filament::button>
                        <x-filament::button wire:click="saveAdmissionSteps" color="primary">Зберегти етапи</x-filament::button>
                    </div>
                </div>
            </x-filament::card>
        </x-filament::section>

        {{-- Admission calculator --}}
        <x-filament::section heading="Калькулятор вступу" description="Предмети, коефіцієнти та пороги">
            <x-filament::card>
                <div class="space-y-4 mb-6">
                    <p class="text-sm font-semibold">Обовʼязкові предмети</p>
                    @foreach (($admissionCalculator['subjects'] ?? []) as $index => $subject)
                        <div class="grid grid-cols-1 gap-4 p-4 bg-gray-50 dark:bg-gray-800 rounded-lg">
                            <x-filament::input.wrapper label="Назва">
                                <x-filament::input type="text" wire:model="admissionCalculator.subjects.{{ $index }}.label" placeholder="Математика" />
                            </x-filament::input.wrapper>
                            <x-filament::input.wrapper label="Коефіцієнт">
                                <x-filament::input type="number" step="0.05" min="0" max="1" wire:model="admissionCalculator.subjects.{{ $index }}.coef" />
                            </x-filament::input.wrapper>
                            <x-filament::button wire:click="removeCalculatorSubject({{ $index }})" color="danger" size="sm" icon="heroicon-o-trash"></x-filament::button>
                        </div>
                    @endforeach
                    <x-filament::button wire:click="addCalculatorSubject" color="gray" size="sm" icon="heroicon-o-plus">Додати предмет</x-filament::button>
                </div>
                <div class="space-y-4 mb-6">
                    <p class="text-sm font-semibold">Четвертий предмет (на вибір)</p>
                    @foreach (($admissionCalculator['optional_subjects'] ?? []) as $index => $opt)
                        <div class="flex items-center gap-4 p-4 bg-gray-50 dark:bg-gray-800 rounded-lg">
                            <div class="flex-1">
                                <x-filament::input.wrapper label="Назва">
                                    <x-filament::input type="text" wire:model="admissionCalculator.optional_subjects.{{ $index }}.label" placeholder="Фізика" />
                                </x-filament::input.wrapper>
                            </div>
                            <div class="flex-1">
                                <x-filament::input.wrapper label="Коефіцієнт">
                                    <x-filament::input type="number" step="0.05" min="0" max="1" wire:model="admissionCalculator.optional_subjects.{{ $index }}.coef" />
                                </x-filament::input.wrapper>
                            </div>
                            <x-filament::button wire:click="removeCalculatorOption({{ $index }})" color="danger" size="sm" icon="heroicon-o-trash"></x-filament::button>
                        </div>
                    @endforeach
                    <x-filament::button wire:click="addCalculatorOption" color="gray" size="sm" icon="heroicon-o-plus">Додати варіант</x-filament::button>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                    <x-filament::input.wrapper label="Мінімальний поріг">
                        <x-filament::input type="number" wire:model="admissionCalculator.thresholds.min" />
                    </x-filament::input.wrapper>
                    <x-filament::input.wrapper label="Поріг бюджету">
                        <x-filament::input type="number" wire:model="admissionCalculator.thresholds.budget" />
                    </x-filament::input.wrapper>
                    <x-filament::input.wrapper label="Примітка">
                        <x-filament::input type="text" wire:model="admissionCalculator.note" />
                    </x-filament::input.wrapper>
                </div>
                <x-filament::button wire:click="saveAdmissionCalculator" color="primary">Зберегти калькулятор</x-filament::button>
            </x-filament::card>
        </x-filament::section>
    </div>
</x-filament-panels::page>
