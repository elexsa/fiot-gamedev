<?php

namespace Database\Seeders;

use App\Models\Degree;
use App\Models\Discipline;
use App\Models\FieldOfStudy;
use App\Models\ModeofStudy;
use App\Models\Partner;
use App\Models\Program;
use App\Models\Semester;
use App\Models\SiteSetting;
use App\Models\Specialty;
use App\Models\Staff;
use App\Models\StaffAcademicRank;
use App\Models\StaffAchievement;
use App\Models\StaffDegree;
use App\Models\StaffPosition;
use App\Models\User;
use App\Models\YearOfStudy;
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

        $this->seedBaseInfo();
        $this->seedPrograms();
        $this->seedDiscipline();
        $this->seedStaff();
        $this->seedSiteSettings();
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

    private function seedBaseInfo(): void
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

        // Форми навчання
        $modesofStudy = [
            ['name' => 'Денна'],
            ['name' => 'Заочна'],
            ['name' => 'Вечірня'],
            ['name' => 'Дистанційна'],
        ];

        foreach ($modesofStudy as $modeofStudy) {
            ModeofStudy::create($modeofStudy);
        }

        // Довідник наукових ступенів
        $staffDegrees = [
            ['name' => 'Доктор наук', 'sort_order' => 1],
            ['name' => 'Кандидат наук', 'sort_order' => 2],
            ['name' => 'Доктор філософії', 'sort_order' => 3],
        ];

        foreach ($staffDegrees as $staffDegree) {
            StaffDegree::create($staffDegree);
        }

        // Довідник вчених звань
        $staffAcademicRank = [
            ['name' => 'Професор', 'sort_order' => 1],
            ['name' => 'Доцент', 'sort_order' => 2],
            ['name' => 'Відсутнє', 'sort_order' => 3],
        ];

        foreach ($staffAcademicRank as $staffRank) {
            StaffAcademicRank::create($staffRank);
        }

        // Довідник посад (із sort_order для сортування)
        $staffPosition = [
            ['name' => 'Завідувач кафедри', 'sort_order' => 1],
            ['name' => 'Професор кафедри', 'sort_order' => 2],
            ['name' => 'Доцент кафедри', 'sort_order' => 3],
            ['name' => 'Асистент', 'sort_order' => 4],
        ];

        foreach ($staffPosition as $position) {
            StaffPosition::create($position);
        }

    }

    private function seedPrograms(): void
    {
        // --- Освітня програма ---
        $programs =
        [
            [
                'image' => null,
                'is_published' => true,
                'name' => "Програмування комп'ютерних ігор",
                'description' => 'Освітньо-професійна програма першого (бакалаврського) рівня вищої освіти.',
                'start_date' => '2026-09-01',
                'end_date' => '2030-06-30',
                'specialty_id' => Specialty::inRandomOrder()->first()?->id,
                'degree_id' => Degree::inRandomOrder()->first()?->id,
                'external_link' => 'https://osvita.kpi.ua/sites/default/files/oop/f2_oppb_pki_2026.pdf',
            ],
            [
                'image' => null,
                'is_published' => true,
                'name' => "Програмування комп'ютерних ігор",
                'description' => 'Освітньо-професійна програма першого (бакалаврського) рівня вищої освіти.',
                'start_date' => '2025-09-01',
                'end_date' => '2029-06-30',
                'specialty_id' => Specialty::inRandomOrder()->first()?->id,
                'degree_id' => Degree::inRandomOrder()->first()?->id,
                'external_link' => 'https://osvita.kpi.ua/sites/default/files/oop/f2_oppb_pki_2025.pdf',
            ],
            [
                'image' => null,
                'is_published' => true,
                'name' => 'Інженерія програмного забезпечення',
                'description' => 'Освітньо-наукова програма третього (освітньо-наукового) рівня вищої освіти.',
                'start_date' => '2026-09-01',
                'end_date' => '2030-06-30',
                'specialty_id' => Specialty::inRandomOrder()->first()?->id,
                'degree_id' => Degree::inRandomOrder()->first()?->id,
                'external_link' => 'https://osvita.kpi.ua/sites/default/files/oop/f2_oppb_pki_2025.pdf',
            ],
            [
                'image' => null,
                'is_published' => true,
                'name' => 'Інженерія програмного забезпечення',
                'description' => 'Освітньо-наукова програма третього (освітньо-наукового) рівня вищої освіти.',
                'start_date' => '2025-09-01',
                'end_date' => '2029-06-30',
                'specialty_id' => Specialty::inRandomOrder()->first()?->id,
                'degree_id' => Degree::inRandomOrder()->first()?->id,
                'external_link' => 'https://osvita.kpi.ua/sites/default/files/oop/f2_onpd_ipz_2025.pdf',
            ],
        ];

        foreach ($programs as $program) {
            Program::create($program);
        }

    }

    private function seedDiscipline(): void
    {
        // Створення дисциплін
        $disciplines = [
            [
                'name' => 'Програмна інженерія',
                'description' => 'Тест1',
                'program_id' => Program::inRandomOrder()->first()?->id,
                'credits' => rand(1, 5),
                'hours' => rand(1, 120),
                'mode_of_study_id' => ModeofStudy::inRandomOrder()->first()?->id,
                'semester_id' => Semester::inRandomOrder()->first()?->id,
                'year_of_study_id' => YearOfStudy::inRandomOrder()->first()?->id,
                'start_date' => '2025-09-01',
                'end_date' => '2029-06-30',
            ],
            [
                'name' => 'Штучний інтелект',
                'description' => 'Тест2',
                'program_id' => Program::inRandomOrder()->first()?->id,
                'credits' => rand(1, 5),
                'hours' => rand(1, 120),
                'mode_of_study_id' => ModeofStudy::inRandomOrder()->first()?->id,
                'semester_id' => Semester::inRandomOrder()->first()?->id,
                'year_of_study_id' => YearOfStudy::inRandomOrder()->first()?->id,
                'start_date' => '2025-09-01',
                'end_date' => '2029-06-30',
            ],
            [
                'name' => 'Алгоритми та структури даних',
                'description' => 'Тест3',
                'program_id' => Program::inRandomOrder()->first()?->id,
                'credits' => rand(1, 5),
                'hours' => rand(1, 120),
                'mode_of_study_id' => ModeofStudy::inRandomOrder()->first()?->id,
                'semester_id' => Semester::inRandomOrder()->first()?->id,
                'year_of_study_id' => YearOfStudy::inRandomOrder()->first()?->id,
                'start_date' => '2025-09-01',
                'end_date' => '2029-06-30',
            ],
            [
                'name' => 'Веб-технології та вебдизайн',
                'description' => 'Тест3',
                'program_id' => Program::inRandomOrder()->first()?->id,
                'credits' => rand(1, 5),
                'hours' => rand(1, 120),
                'mode_of_study_id' => ModeofStudy::inRandomOrder()->first()?->id,
                'semester_id' => Semester::inRandomOrder()->first()?->id,
                'year_of_study_id' => YearOfStudy::inRandomOrder()->first()?->id,
                'start_date' => '2025-09-01',
                'end_date' => '2029-06-30',
            ],
            [
                'name' => 'Кібербезпека',
                'description' => 'Тест3',
                'program_id' => Program::inRandomOrder()->first()?->id,
                'credits' => rand(1, 5),
                'hours' => rand(1, 120),
                'mode_of_study_id' => ModeofStudy::inRandomOrder()->first()?->id,
                'semester_id' => Semester::inRandomOrder()->first()?->id,
                'year_of_study_id' => YearOfStudy::inRandomOrder()->first()?->id,
                'start_date' => '2025-09-01',
                'end_date' => '2029-06-30',
            ],
        ];

        foreach ($disciplines as $discipline) {
            Discipline::create($discipline);
        }

    }

    private function seedStaff(): void
    {
        // Cписок викладачів з дисциплінами та досягненнями
        $staffMembers = [
            [
                'data' => [
                    'last_name' => 'Петренко',
                    'first_name' => 'Іван',
                    'patronymic' => 'Іванович',
                    'degree_id' => StaffDegree::inRandomOrder()->first()?->id,
                    'academic_rank_id' => StaffAcademicRank::inRandomOrder()->first()?->id,
                    'position_id' => StaffPosition::inRandomOrder()->first()?->id,
                    'bio' => 'Досвідчений викладач та дослідник у галузі штучного інтелекту, системного аналізу та розподілених обчислень.',
                    'scopus_url' => 'https://scopus.com',
                    'orcid_url' => 'https://orcid.org',
                    'scholar_url' => 'https://scholar.google.com',
                    'intellect_url' => 'https://intellect.kpi.ua',
                ],
                'disciplines' => [Discipline::inRandomOrder()->first()?->id],
                'achievements' => [
                    ['year' => 2025, 'achievement_description' => 'Отримання премії за найкращу монографію у сфері штучного інтелекту.'],
                    ['year' => 2022, 'achievement_description' => 'Призначення на посаду завідувача кафедри програмної інженерії.'],
                    ['year' => 2018, 'achievement_description' => 'успішний захист докторської дисертації.'],
                ],
            ],
            [
                'data' => [
                    'last_name' => 'Коваленко',
                    'first_name' => 'Олена',
                    'patronymic' => 'Петрівна',
                    'degree_id' => StaffDegree::inRandomOrder()->first()?->id,
                    'academic_rank_id' => StaffAcademicRank::inRandomOrder()->first()?->id,
                    'position_id' => StaffPosition::inRandomOrder()->first()?->id,
                    'bio' => 'Спеціаліст з вебтехнологій, архітектури сучасних додатків та баз даних високого навантаження.',
                    'scopus_url' => 'https://scopus.com',
                    'orcid_url' => 'https://orcid.org',
                ],
                'disciplines' => [Discipline::inRandomOrder()->first()?->id],
                'achievements' => [
                    ['year' => 2024, 'achievement_description' => 'Випуск оновленого електронного підручника з вебдизайну.'],
                    ['year' => 2020, 'achievement_description' => 'Отримання вченого звання доцента.'],
                ],
            ],
            [
                'data' => [
                    'last_name' => 'Шевченко',
                    'first_name' => 'Андрій',
                    'patronymic' => 'Миколайович',
                    'degree_id' => StaffDegree::inRandomOrder()->first()?->id,
                    'academic_rank_id' => StaffAcademicRank::inRandomOrder()->first()?->id,
                    'position_id' => StaffPosition::inRandomOrder()->first()?->id,
                    'bio' => 'Дослідник у сфері кібербезпеки, криптографії та захисту інформаційних систем.',
                    'scholar_url' => 'https://scholar.google.com',
                    'intellect_url' => 'https://intellect.kpi.ua',
                ],
                'disciplines' => [Discipline::inRandomOrder()->first()?->id],
                'achievements' => [
                    ['year' => 2025, 'achievement_description' => 'Успішний захист дисертації доктора філософії (PhD).'],
                    ['year' => 2021, 'achievement_description' => 'Перемога у конкурсі молодих науковців із кібербезпеки.'],
                ],
            ],
        ];

        // Заповнення таблиці викладачів та прив'язка пов'язаних таблиць
        foreach ($staffMembers as $item) {
            $staff = Staff::updateOrCreate(
                ['last_name' => $item['data']['last_name'], 'first_name' => $item['data']['first_name']],
                $item['data']
            );

            // Прив'язка дисциплін (багато-до-багатьох)
            $staff->disciplines()->sync($item['disciplines']);

            // Додавання хронології подій (досягнень)
            foreach ($item['achievements'] as $ach) {
                StaffAchievement::updateOrCreate(
                    [
                        'staff_id' => $staff->id,
                        'year' => $ach['year'],
                        'achievement_description' => $ach['achievement_description'],
                    ]
                );
            }
        }

    }
}
