<?php

namespace Database\Seeders;

use App\Models\Discipline;
use App\Models\Faculty;
use App\Models\News;
use App\Models\Partner;
use App\Models\Program;
use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ContentSeeder extends Seeder
{
    /**
     * Наповнює БД плейсхолдер-контентом.
     * Коли деканат дасть реальний контент — редагується через /admin.
     */
    public function run(): void
    {
        // --- Адмін (деканат) ---
        User::updateOrCreate(
            ['email' => env('ADMIN_EMAIL', 'admin@gamedev.kpi.ua')],
            [
                'name' => 'Адміністратор кафедри',
                'password' => Hash::make(env('ADMIN_PASSWORD', 'password')),
                'email_verified_at' => now(),
            ]
        );

        // --- Освітня програма ---
        $program = Program::updateOrCreate(
            ['slug' => 'rozrobka-kompyuternyh-igor'],
            [
                'name' => "Розробка комп'ютерних ігор",
                'specialty_code' => '121 «Інженерія програмного забезпечення»',
                'degree' => 'Бакалавр',
                'description' => "Офіційна освітня програма ФІОТ: глибока математика, комп'ютерна графіка та системне програмування.",
                'sort_order' => 0,
            ]
        );

        $this->seedSiteSettings();
        $this->seedNews();
        $this->seedFaculty();
        $this->seedDisciplines($program);
        $this->seedPartners();
    }

    private function seedSiteSettings(): void
    {
        // --- Контакти ---
        SiteSetting::set('contacts.address', 'м. Київ, просп. Політехнічний 41, КПІ ім. Ігоря Сікорського, корп. 18, кімн. XXX', 'text', 'contacts', 'Адреса');
        SiteSetting::set('contacts.phone', '+380 (44) 204 XX XX', 'text', 'contacts', 'Телефон');
        SiteSetting::set('contacts.email', 'gamedev@kpi.ua', 'email', 'contacts', 'Email');
        SiteSetting::set('contacts.social.telegram', '#', 'url', 'contacts', 'Telegram');
        SiteSetting::set('contacts.social.discord', '#', 'url', 'contacts', 'Discord');
        SiteSetting::set('contacts.social.facebook', '#', 'url', 'contacts', 'Facebook');

        // --- Статистика ---
        SiteSetting::set('stats', [
            ['value' => '120+', 'label' => 'студентів на програмі'],
            ['value' => '25', 'label' => 'профільних дисциплін'],
            ['value' => '6', 'label' => 'індустріальних партнерів'],
            ['value' => '15', 'label' => 'років досвіду викладання'],
        ], 'json', 'stats', 'Статистика');

        // --- Вступ: етапи ---
        SiteSetting::set('admission.steps', [
            ['date' => 'Липень', 'title' => 'Реєстрація кабінету', 'text' => 'Створіть електронний кабінет вступника та завантажте документи.'],
            ['date' => 'Кінець липня', 'title' => 'Подання заяв', 'text' => 'Оберіть КПІ, ФІОТ та освітню програму кафедри. Поставте перший пріоритет.'],
            ['date' => 'Серпень', 'title' => 'Мотиваційний лист', 'text' => 'Додайте мотиваційний лист: чому GameDev і чому наша кафедра.'],
            ['date' => 'Кінець серпня', 'title' => 'Зарахування', 'text' => 'Підтвердіть рекомендацію на бюджет або контракт у кабінеті.'],
        ], 'json', 'admission', 'Етапи вступу');

        // --- Вступ: калькулятор ---
        SiteSetting::set('admission.calculator', [
            'subjects' => [
                ['key' => 'math', 'label' => 'Математика', 'coef' => 0.5, 'default' => 180],
                ['key' => 'ukr', 'label' => 'Українська мова', 'coef' => 0.3, 'default' => 170],
                ['key' => 'hist', 'label' => 'Історія України', 'coef' => 0.2, 'default' => 170],
            ],
            'optional_subjects' => [
                ['label' => 'Іноземна мова', 'coef' => 0.4],
                ['label' => 'Фізика', 'coef' => 0.5],
                ['label' => 'Хімія', 'coef' => 0.3],
                ['label' => 'Біологія', 'coef' => 0.3],
                ['label' => 'Географія', 'coef' => 0.3],
            ],
            'thresholds' => ['min' => 130, 'budget' => 165],
            'note' => 'Сума балів з урахуванням коефіцієнтів, поділена на суму коефіцієнтів.',
        ], 'json', 'admission', 'Калькулятор вступу');
    }

    private function seedNews(): void
    {
        // News is now managed through Filament admin panel
        // Add initial news items here if needed for fresh installations
    }

    private function seedFaculty(): void
    {
        // Faculty is now managed through Filament admin panel
        // Add initial faculty members here if needed for fresh installations
    }

    private function seedPartners(): void
    {
        $partners = [
            ['name' => 'Ubisoft Kyiv', 'url' => 'https://kyiv.ubisoft.com/', 'logo' => 'images/logos/ubisoft.png', 'description' => 'Розробка ААА-проєктів світового рівня. Менторство зі створення ігрових рушіїв та C++ програмування.'],
            ['name' => 'Genesis', 'url' => 'https://gen.tech/', 'logo' => 'images/logos/genesis.png', 'description' => 'Продуктове ІТ та створення мобільних ігор. Можливості стажування через Genesis IT School та профільні хакатони.'],
            ['name' => 'Sigma Software', 'url' => 'https://sigma.software/', 'logo' => 'images/logos/sigma-software.png', 'description' => 'Експертиза у сферах AR/VR та GameDev аутсорсу. Спільні навчальні кемпи для студентів ФІОТ.'],
            ['name' => 'MacPaw', 'url' => 'https://macpaw.com/uk', 'logo' => 'images/logos/macpaw.png', 'description' => 'Продуктова компанія екосистеми Apple. Підтримка студентських ініціатив та програми MacPaw Internship.'],
            ['name' => 'EPAM Systems', 'url' => 'https://careers.epam.ua/', 'logo' => 'images/logos/epam.png', 'description' => 'Один з найбільших гравців IT-ринку України. Доступ до програм EPAM University Programs та лабораторій.'],
            ['name' => 'Frag Lab', 'url' => 'https://fraglab.com/', 'logo' => 'images/logos/fraglab.png', 'description' => 'Київська студія з розробки next-gen шутерів (Shatterline). Спеціалісти з Amazon Lumberyard та ігрової архітектури.'],
        ];

        foreach ($partners as $i => $p) {
            Partner::updateOrCreate(['name' => $p['name']], $p + ['sort_order' => $i]);
        }
    }

    private function seedDisciplines(Program $program): void
    {
        $disciplines = [
            ['level' => 1, 'category' => 'Математика', 'name' => 'Дискретна математика', 'description' => 'Графи, логіка, теорія множин.', 'prerequisites' => []],
            ['level' => 1, 'category' => 'Програмування', 'name' => 'Основи програмування', 'description' => "Синтаксис C++, пам'ять, вказівники.", 'prerequisites' => []],
            ['level' => 2, 'category' => 'Математика', 'name' => 'Лінійна алгебра', 'description' => 'Вектори, матриці, трансформації.', 'prerequisites' => [1]],
            ['level' => 2, 'category' => 'Інженерія', 'name' => "Об'єктно-орієнтоване ПЗ", 'description' => 'Класи, патерни, SOLID.', 'prerequisites' => [2]],
            ['level' => 2, 'category' => 'Логіка', 'name' => 'Алгоритми та СД', 'description' => 'Оптимізація, дерева, пошук шляху.', 'prerequisites' => [1, 2]],
            ['level' => 3, 'category' => 'Рендер', 'name' => 'Програмування графіки', 'description' => 'Шейдери, DirectX, робота з GPU.', 'prerequisites' => [3]],
            ['level' => 3, 'category' => 'Ядро GameDev', 'name' => 'Ігрові рушії', 'description' => 'Базова архітектура рушіїв, фізика.', 'prerequisites' => [4, 5]],
            ['level' => 3, 'category' => 'Інфраструктура', 'name' => 'Архітектура ПЗ / DevOps', 'description' => 'Мікросервіси, CI/CD, сервери.', 'prerequisites' => [4]],
            ['level' => 4, 'category' => 'Unreal Engine 5', 'name' => 'Розробка ігрових систем', 'description' => 'Проєкти ААА-рівня, Blueprints + C++.', 'prerequisites' => [7], 'is_boss' => true],
            ['level' => 4, 'category' => 'Спеціалізація', 'name' => 'Військові симулятори', 'description' => 'Симуляція бойових дій, фізика балістики.', 'prerequisites' => [7, 8]],
            ['level' => 4, 'category' => 'Інтелект', 'name' => 'Штучний інтелект (AI)', 'description' => 'Поведінкові дерева, машинне навчання.', 'prerequisites' => [5]],
        ];

        // Створюємо дисципліни та мапимо порядкові номери → id
        $ids = [];
        foreach ($disciplines as $i => $disc) {
            $d = Discipline::updateOrCreate(
                ['name' => $disc['name'], 'program_id' => $program->id],
                [
                    'description' => $disc['description'],
                    'category' => $disc['category'],
                    'level' => $disc['level'],
                    'is_boss' => $disc['is_boss'] ?? false,
                    'sort_order' => $i,
                ]
            );
            $ids[$i + 1] = $d->id;
        }

        // Зв'язки: порядкові номери → реальні id
        foreach ($disciplines as $i => $disc) {
            if (! empty($disc['prerequisites'])) {
                $realIds = array_map(fn ($n) => $ids[$n], $disc['prerequisites']);
                Discipline::find($ids[$i + 1])->update(['prerequisites' => $realIds]);
            }
        }
    }
}
