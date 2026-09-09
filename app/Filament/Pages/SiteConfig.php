<?php

namespace App\Filament\Pages;

use App\Models\SiteSetting;
use BackedEnum;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class SiteConfig extends Page implements HasForms
{
    use InteractsWithForms;

    protected string $view = 'filament.pages.settings';
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static ?string $title = 'Налаштування сайту';
    protected static ?string $slug = 'settings';

    public ?array $contacts = [];
    public ?array $stats = [];

    public function mount(): void
    {
        $this->contacts = [
            'address' => SiteSetting::get('contacts.address', ''),
            'phone' => SiteSetting::get('contacts.phone', ''),
            'email' => SiteSetting::get('contacts.email', ''),
            'telegram' => SiteSetting::get('contacts.social.telegram', ''),
            'discord' => SiteSetting::get('contacts.social.discord', ''),
            'facebook' => SiteSetting::get('contacts.social.facebook', ''),
        ];

        $this->stats = SiteSetting::get('stats', [
            ['value' => '', 'label' => ''],
        ]);
    }

    public function saveContacts(): void
    {
        SiteSetting::set('contacts.address', $this->contacts['address'] ?? '', 'text', 'contacts', 'Адреса');
        SiteSetting::set('contacts.phone', $this->contacts['phone'] ?? '', 'text', 'contacts', 'Телефон');
        SiteSetting::set('contacts.email', $this->contacts['email'] ?? '', 'email', 'contacts', 'Email');
        SiteSetting::set('contacts.social.telegram', $this->contacts['telegram'] ?? '', 'url', 'contacts', 'Telegram');
        SiteSetting::set('contacts.social.discord', $this->contacts['discord'] ?? '', 'url', 'contacts', 'Discord');
        SiteSetting::set('contacts.social.facebook', $this->contacts['facebook'] ?? '', 'url', 'contacts', 'Facebook');

        Notification::make()
            ->title('Контакти збережено')
            ->success()
            ->send();
    }

    public function saveStats(): void
    {
        $filtered = array_filter($this->stats, fn($stat) => !empty($stat['value']) || !empty($stat['label']));
        SiteSetting::set('stats', array_values($filtered), 'json', 'stats', 'Статистика');

        Notification::make()
            ->title('Статистику збережено')
            ->success()
            ->send();
    }

    public function removeStat(int $index): void
    {
        unset($this->stats[$index]);
        $this->stats = array_values($this->stats);
    }

    public function addStat(): void
    {
        $this->stats[] = ['value' => '', 'label' => ''];
    }
}
