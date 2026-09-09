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
    </div>
</x-filament-panels::page>
