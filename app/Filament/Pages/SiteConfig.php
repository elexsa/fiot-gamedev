<?php

namespace App\Filament\Pages;

use App\Models\SiteSetting;
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

    public ?array $admissionSteps = [];

    public ?array $admissionCalculator = [];

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

        $this->admissionSteps = SiteSetting::get('admission.steps', [
            ['date' => '', 'title' => '', 'text' => ''],
        ]);

        $this->admissionCalculator = SiteSetting::get('admission.calculator', [
            'subjects' => [
                ['key' => 'math', 'label' => 'Математика', 'coef' => 0.5, 'default' => 180],
                ['key' => 'ukr', 'label' => 'Українська мова', 'coef' => 0.3, 'default' => 170],
                ['key' => 'hist', 'label' => 'Історія України', 'coef' => 0.2, 'default' => 170],
            ],
            'optional_subjects' => [
                ['label' => 'Іноземна мова', 'coef' => 0.4],
                ['label' => 'Фізика', 'coef' => 0.5],
                ['label' => 'Хімія', 'coef' => 0.3],
            ],
            'thresholds' => ['min' => 130, 'budget' => 165],
            'note' => 'Сума балів з урахуванням коефіцієнтів, поділена на суму коефіцієнтів.',
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
        $filtered = array_filter($this->stats, fn ($stat) => ! empty($stat['value']) || ! empty($stat['label']));
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

    public function addAdmissionStep(): void
    {
        $this->admissionSteps[] = ['date' => '', 'title' => '', 'text' => ''];
    }

    public function removeAdmissionStep(int $index): void
    {
        unset($this->admissionSteps[$index]);
        $this->admissionSteps = array_values($this->admissionSteps);
    }

    public function saveAdmissionSteps(): void
    {
        $filtered = array_values(array_filter(
            $this->admissionSteps,
            fn ($step) => ! empty($step['title']) || ! empty($step['text']) || ! empty($step['date'])
        ));
        SiteSetting::set('admission.steps', $filtered, 'json', 'admission', 'Етапи вступу');

        Notification::make()->title('Етапи вступу збережено')->success()->send();
    }

    public function addCalculatorSubject(): void
    {
        $this->admissionCalculator['subjects'][] = ['key' => '', 'label' => '', 'coef' => 0.3, 'default' => 150];
    }

    public function removeCalculatorSubject(int $index): void
    {
        unset($this->admissionCalculator['subjects'][$index]);
        $this->admissionCalculator['subjects'] = array_values($this->admissionCalculator['subjects']);
    }

    public function addCalculatorOption(): void
    {
        $this->admissionCalculator['optional_subjects'][] = ['label' => '', 'coef' => 0.3];
    }

    public function removeCalculatorOption(int $index): void
    {
        unset($this->admissionCalculator['optional_subjects'][$index]);
        $this->admissionCalculator['optional_subjects'] = array_values($this->admissionCalculator['optional_subjects']);
    }

    public function saveAdmissionCalculator(): void
    {
        $calc = $this->admissionCalculator;
        $calc['subjects'] = array_values(array_filter(
            $calc['subjects'] ?? [],
            fn ($s) => ! empty($s['label'])
        ));
        $calc['optional_subjects'] = array_values(array_filter(
            $calc['optional_subjects'] ?? [],
            fn ($s) => ! empty($s['label'])
        ));
        SiteSetting::set('admission.calculator', $calc, 'json', 'admission', 'Калькулятор вступу');

        Notification::make()->title('Калькулятор збережено')->success()->send();
    }
}
