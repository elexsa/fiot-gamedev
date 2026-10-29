<?php

namespace Database\Seeders;

use App\Models\Degree;
use App\Models\Discipline;
use App\Models\Faculty;
use App\Models\FieldOfStudy;
use App\Models\News;
use App\Models\Partner;
use App\Models\Program;
use App\Models\Semester;
use App\Models\SiteSetting;
use App\Models\Specialty;
use App\Models\User;
use App\Models\YearOfStudy;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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

        $this->seedEducationInfo();

        // --- Освітня програма ---
        $program = $this->createProgram(
            name: "Програмування комп'ютерних ігор",
            description: 'Освітньо-професійна програма першого (бакалаврського) рівня вищої освіти.',
            startDate: '2026-09-01',
            endDate: '2030-06-30',
            specialtyId: 42,
            degreeId: 1,
            external_link: 'https://osvita.kpi.ua/sites/default/files/oop/f2_oppb_pki_2026.pdf',
        );

        $this->createProgram(
            name: "Програмування комп'ютерних ігор",
            description: 'Освітньо-професійна програма першого (бакалаврського) рівня вищої освіти.',
            startDate: '2025-09-01',
            endDate: '2029-06-30',
            specialtyId: 42,
            degreeId: 1,
            external_link: 'https://osvita.kpi.ua/sites/default/files/oop/f2_oppb_pki_2025.pdf',
        );

        $this->createProgram(
            name: 'Інженерія програмного забезпечення',
            description: 'Освітньо-наукова програма третього (освітньо-наукового) рівня вищої освіти.',
            startDate: '2025-09-01',
            endDate: '2029-06-30',
            specialtyId: 42,
            degreeId: 3,
            external_link: 'https://osvita.kpi.ua/sites/default/files/oop/f2_onpd_ipz_2025.pdf',
        );

        $this->createProgram(
            name: 'Інженерія програмного забезпечення',
            description: 'Освітньо-наукова програма третього (освітньо-наукового) рівня вищої освіти.',
            startDate: '2026-09-01',
            endDate: '2030-06-30',
            specialtyId: 42,
            degreeId: 3,
            external_link: 'https://osvita.kpi.ua/sites/default/files/oop/f2_onpd_ipz_2026.pdf',
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

    private function seedEducationInfo(): void
    {
        // Галузі знань
        $fields = [
            'A' => 'Освіта',
            'B' => 'Культура, мистецтво та гуманітарні науки',
            'C' => 'Соціальні науки, журналістика, інформація та міжнародні відносини',
            'D' => 'Бізнес, адміністрування та право',
            'E' => 'Природничі науки, математика та статистика',
            'F' => 'Інформаційні технології',
            'G' => 'Інженерія, виробництво та будівництво',
            'H' => 'Сільське, лісове, рибне господарство та ветеринарія',
            'I' => 'Охорона здоров\'я та соціальне забезпечення',
            'J' => 'Транспорт та послуги',
            'K' => 'Безпека та оборона',
        ];

        // Масив для збереження ID згенерованих галузей
        $insertedFields = [];

        foreach ($fields as $code => $name) {
            $field = FieldOfStudy::updateOrCreate(
                ['fieldOfStudy_code' => $code],
                ['fieldOfStudy_name' => $name]
            );
            $insertedFields[$code] = $field->id;
        }

        // Коди спеціальностей
        $specialties = [

            ['code' => 'A1', 'name' => 'Освітні науки', 'field_code' => 'A'],
            ['code' => 'A2', 'name' => 'Дошкільна освіта', 'field_code' => 'A'],
            ['code' => 'A3', 'name' => 'Початкова освіта', 'field_code' => 'A'],
            ['code' => 'A4', 'name' => 'Середня освіта (за предметними напрямами)', 'field_code' => 'A'],
            ['code' => 'A5', 'name' => 'Професійна освіта (за спеціалізаціями)', 'field_code' => 'A'],
            ['code' => 'A6', 'name' => 'Спеціальна освіта', 'field_code' => 'A'],
            ['code' => 'A7', 'name' => 'Фізична культура і спорт', 'field_code' => 'A'],

            ['code' => 'B1', 'name' => 'Культура, мистецтво та гуманітарні науки', 'field_code' => 'B'],
            ['code' => 'B2', 'name' => 'Дизайн', 'field_code' => 'B'],
            ['code' => 'B3', 'name' => 'Образотворче мистецтво, декоративне мистецтво, реставрація', 'field_code' => 'B'],
            ['code' => 'B4', 'name' => 'Сценічне мистецтво', 'field_code' => 'B'],
            ['code' => 'B5', 'name' => 'Музичне мистецтво', 'field_code' => 'B'],
            ['code' => 'B6', 'name' => 'Менеджмент соціокультурної діяльності', 'field_code' => 'B'],
            ['code' => 'B7', 'name' => 'Музеєзнавство, пам\'яткознавство', 'field_code' => 'B'],
            ['code' => 'B8', 'name' => 'Бібліотечна, інформаційна та архівна справа', 'field_code' => 'B'],
            ['code' => 'B9', 'name' => 'Історія та археологія', 'field_code' => 'B'],
            ['code' => 'B10', 'name' => 'Філософія та релігієзнавство', 'field_code' => 'B'],
            ['code' => 'B11', 'name' => 'Філологія', 'field_code' => 'B'],
            ['code' => 'B12', 'name' => 'Культурологія', 'field_code' => 'B'],

            ['code' => 'C1', 'name' => 'Економіка та міжнародні економічні відносини', 'field_code' => 'C'],
            ['code' => 'C2', 'name' => 'Політологія та міжнародні відносини', 'field_code' => 'C'],
            ['code' => 'C3', 'name' => 'Соціологія', 'field_code' => 'C'],
            ['code' => 'C4', 'name' => 'Психологія', 'field_code' => 'C'],
            ['code' => 'C5', 'name' => 'Журналістика', 'field_code' => 'C'],

            ['code' => 'D1', 'name' => 'Облік і оподаткування', 'field_code' => 'D'],
            ['code' => 'D2', 'name' => 'Фінанси, банківська справа, страхування та фондовий ринок', 'field_code' => 'D'],
            ['code' => 'D3', 'name' => 'Менеджмент', 'field_code' => 'D'],
            ['code' => 'D4', 'name' => 'Публічне управління та адміністрування', 'field_code' => 'D'],
            ['code' => 'D5', 'name' => 'Маркетинг', 'field_code' => 'D'],
            ['code' => 'D6', 'name' => 'Підприємництво та торгівля', 'field_code' => 'D'],
            ['code' => 'D7', 'name' => 'Логістика', 'field_code' => 'D'],
            ['code' => 'D8', 'name' => 'Право', 'field_code' => 'D'],
            ['code' => 'D9', 'name' => 'Міжнародне право', 'field_code' => 'D'],

            ['code' => 'E1', 'name' => 'Математика та статистика', 'field_code' => 'E'],
            ['code' => 'E2', 'name' => 'Екологія', 'field_code' => 'E'],
            ['code' => 'E3', 'name' => 'Хімія', 'field_code' => 'E'],
            ['code' => 'E4', 'name' => 'Науки про Землю (включаючи Географію)', 'field_code' => 'E'],
            ['code' => 'E5', 'name' => 'Фізика та астрономія', 'field_code' => 'E'],
            ['code' => 'E6', 'name' => 'Прикладна фізика та наноматеріали', 'field_code' => 'E'],
            ['code' => 'E7', 'name' => 'Біологія, біохімія та біотехнології', 'field_code' => 'E'],

            ['code' => 'F1', 'name' => 'Прикладна математика', 'field_code' => 'F'],
            ['code' => 'F2', 'name' => 'Інженерія програмного забезпечення', 'field_code' => 'F'],
            ['code' => 'F3', 'name' => 'Комп\'ютерні науки', 'field_code' => 'F'],
            ['code' => 'F4', 'name' => 'Системний аналіз та наука про дані', 'field_code' => 'F'],
            ['code' => 'F5', 'name' => 'Кібербезпека та захист інформації', 'field_code' => 'F'],
            ['code' => 'F6', 'name' => 'Інформаційні системи та технології', 'field_code' => 'F'],
            ['code' => 'F7', 'name' => 'Комп\'ютерна інженерія', 'field_code' => 'F'],

            ['code' => 'G1', 'name' => 'Хімічні технології та інженерія', 'field_code' => 'G'],
            ['code' => 'G2', 'name' => 'Біотехнології та біоінженерія', 'field_code' => 'G'],
            ['code' => 'G3', 'name' => 'Електрична інженерія та електротехніка', 'field_code' => 'G'],
            ['code' => 'G4', 'name' => 'Теплоенергетика та відновлювальні джерела енергії', 'field_code' => 'G'],
            ['code' => 'G5', 'name' => 'Електроніка та електронні комунікації', 'field_code' => 'G'],
            ['code' => 'G6', 'name' => 'Автоматизація, комп\'ютерно-інтегровані технології та робототехніка', 'field_code' => 'G'],
            ['code' => 'G7', 'name' => 'Метрологія, інформаційно-вимірювальна техніка та біомедична інженерія', 'field_code' => 'G'],
            ['code' => 'G8', 'name' => 'Мікро- та наносистемна техніка', 'field_code' => 'G'],
            ['code' => 'G9', 'name' => 'Екологічні технології та цивільна безпека', 'field_code' => 'G'],
            ['code' => 'G10', 'name' => 'Прикладна механіка', 'field_code' => 'G'],
            ['code' => 'G11', 'name' => 'Машинобудування та матеріалообробка', 'field_code' => 'G'],
            ['code' => 'G12', 'name' => 'Металургія та матеріалознавство', 'field_code' => 'G'],
            ['code' => 'G13', 'name' => 'Харчові технології', 'field_code' => 'G'],
            ['code' => 'G14', 'name' => 'Технології легкої промисловості', 'field_code' => 'G'],
            ['code' => 'G15', 'name' => 'Технології захисту навколишнього середовища', 'field_code' => 'G'],
            ['code' => 'G16', 'name' => 'Нафтогазова інженерія та технології', 'field_code' => 'G'],
            ['code' => 'G17', 'name' => 'Гірництво та надрокористування', 'field_code' => 'G'],
            ['code' => 'G18', 'name' => 'Геодезія та землеустрій', 'field_code' => 'G'],
            ['code' => 'G19', 'name' => 'Будівництво та цивільна інженерія', 'field_code' => 'G'],
            ['code' => 'G20', 'name' => 'Архітектура та містобудування', 'field_code' => 'G'],

            ['code' => 'H1', 'name' => 'Агрономія', 'field_code' => 'H'],
            ['code' => 'H2', 'name' => 'Захист і карантин рослин', 'field_code' => 'H'],
            ['code' => 'H3', 'name' => 'Садово-паркове господарство', 'field_code' => 'H'],
            ['code' => 'H4', 'name' => 'Лісове господарство', 'field_code' => 'H'],
            ['code' => 'H5', 'name' => 'Водні біоресурси та аквакультура', 'field_code' => 'H'],
            ['code' => 'H6', 'name' => 'Ветеринарна медицина', 'field_code' => 'H'],
            ['code' => 'H7', 'name' => 'Агроінженерія', 'field_code' => 'H'],

            ['code' => 'I1', 'name' => 'Стоматологія', 'field_code' => 'I'],
            ['code' => 'I2', 'name' => 'Медицина', 'field_code' => 'I'],
            ['code' => 'I3', 'name' => 'Педіатрія', 'field_code' => 'I'],
            ['code' => 'I4', 'name' => 'Фармація, промислова фармація', 'field_code' => 'I'],
            ['code' => 'I5', 'name' => 'Медсестринство', 'field_code' => 'I'],
            ['code' => 'I6', 'name' => 'Технології медичної діагностики та лікування', 'field_code' => 'I'],
            ['code' => 'I7', 'name' => 'Терапія та реабілітація', 'field_code' => 'I'],
            ['code' => 'I8', 'name' => 'Громадське здоров\'я', 'field_code' => 'I'],
            ['code' => 'I9', 'name' => 'Соціальна робота', 'field_code' => 'I'],
            ['code' => 'I10', 'name' => 'Соціальне забезпечення та консультування', 'field_code' => 'I'],

            ['code' => 'J1', 'name' => 'Сфера обслуговування', 'field_code' => 'J'],
            ['code' => 'J2', 'name' => 'Готельно-ресторанна справа та кейтеринг', 'field_code' => 'J'],
            ['code' => 'J3', 'name' => 'Туризм та рекреація', 'field_code' => 'J'],
            ['code' => 'J4', 'name' => 'Морський та внутрішній водний транспорт', 'field_code' => 'J'],
            ['code' => 'J5', 'name' => 'Авіаційний транспорт', 'field_code' => 'J'],
            ['code' => 'J6', 'name' => 'Залізничний транспорт', 'field_code' => 'J'],
            ['code' => 'J7', 'name' => 'Автомобільний транспорт', 'field_code' => 'J'],
            ['code' => 'J8', 'name' => 'Транспортні технології (за видами)', 'field_code' => 'J'],

            ['code' => 'K1', 'name' => 'Військове управління (за видами збройних сил)', 'field_code' => 'K'],
            ['code' => 'K2', 'name' => 'Забезпечення військ (сил)', 'field_code' => 'K'],
            ['code' => 'K3', 'name' => 'Озброєння та військова техніка', 'field_code' => 'K'],
            ['code' => 'K4', 'name' => 'Національна безпека (за окремими сферами)', 'field_code' => 'K'],
            ['code' => 'K5', 'name' => 'Безпека державного кордону', 'field_code' => 'K'],
            ['code' => 'K6', 'name' => 'Цивільна безпека', 'field_code' => 'K'],
            ['code' => 'K7', 'name' => 'Пожежна безпека', 'field_code' => 'K'],
            ['code' => 'K8', 'name' => 'Правоохоронна діяльність', 'field_code' => 'K'],

        ];

        foreach ($specialties as $spec) {
            if (isset($insertedFields[$spec['field_code']])) {
                Specialty::updateOrCreate(
                    ['specialty_code' => $spec['code']],
                    [
                        'specialty_name' => $spec['name'],
                        'field_of_study_id' => $insertedFields[$spec['field_code']], // Зв'язок через Integer ID
                    ]
                );
            }
        }

        // Рівень освіти
        $degrees = [
            ['name' => 'Бакалавр', 'level' => 1],
            ['name' => 'Магістр', 'level' => 2],
            ['name' => 'Доктор філософії', 'level' => 3],
            ['name' => 'Доктор наук', 'level' => 4],
        ];

        foreach ($degrees as $degree) {
            Degree::create($degree);
        }

        // Семестр
        $semestrs = [
            ['name' => '1 семестр', 'level' => 1],
            ['name' => '2 семестр', 'level' => 2],
        ];

        foreach ($semestrs as $semestr) {
            Semester::create($semestr);
        }

        // Курс навчання
        $years_of_study = [
            ['name' => '1 курс', 'level' => 1],
            ['name' => '2 курс', 'level' => 2],
            ['name' => '3 курс', 'level' => 3],
            ['name' => '4 курс', 'level' => 4],
        ];

        foreach ($years_of_study as $year_of_study) {
            YearOfStudy::create($year_of_study);
        }
    }

    private function createProgram(
        string $name,
        string $description,
        ?string $startDate = null,
        ?string $endDate = null,
        ?int $specialtyId = null,
        ?int $degreeId = null,
        ?string $external_link = null
    ): Program {

        $finalSpecialtyId = $specialtyId ?? Specialty::inRandomOrder()->first()?->id;
        $finalDegreeId = $degreeId ?? Degree::inRandomOrder()->first()?->id;

        return Program::updateOrCreate([
            'name' => $name,
            'slug' => Str::slug($name).'-'.rand(100, 999),
            'description' => $description,
            'image' => null, // 'images/programs/default.jpg',
            'is_published' => true,
            'sort_order' => 0,
            'start_date' => $startDate ?? now()->format('Y-m-d'),
            'end_date' => $endDate ?? now()->addYears(4)->format('Y-m-d'),
            'specialty_id' => $finalSpecialtyId,
            'degree_id' => $finalDegreeId,
            'external_link' => $external_link,
        ]);
    }
}
