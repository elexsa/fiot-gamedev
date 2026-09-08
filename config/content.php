<?php

/*
|--------------------------------------------------------------------------
| Content Configuration (PLACEHOLDER DATA)
|--------------------------------------------------------------------------
|
| Усі тексти на сайті — тимчасові (Lorem Ipsum-подібні). Коли деканат
| надасть реальний контент, його достатньо замінити ТУТ, у цьому файлі.
| Жодних змін у Blade-шаблонах для заміни тексту не потрібно.
|
| All texts on the site are temporary placeholders. When the dean's office
| provides real content, replace it HERE — no Blade template edits needed.
|
*/

return [

    // ------------------------------------------------------------------
    // Контакти кафедри (внизу сторінки — footer)
    // ------------------------------------------------------------------
    'contacts' => [
        'address' => 'м. Київ, просп. Політехнічний 41, КПІ ім. Ігоря Сікорського, корп. 18, кімн. XXX',
        'phone'   => '+380 (44) 204 XX XX',
        'email'   => 'gamedev@kpi.ua',
        'social'  => [
            'telegram' => '#',
            'discord'  => '#',
            'facebook' => '#',
        ],
    ],

    // ------------------------------------------------------------------
    // Статистика (смуга на головній сторінці)
    // ------------------------------------------------------------------
    'stats' => [
        ['value' => '120+', 'label' => 'студентів на програмі'],
        ['value' => '25',   'label' => 'профільних дисциплін'],
        ['value' => '6',    'label' => 'індустріальних партнерів'],
        ['value' => '15',   'label' => 'років досвіду викладання'],
    ],

    // ------------------------------------------------------------------
    // Викладачі (сторінка «Про кафедру»)
    // ------------------------------------------------------------------
    'faculty' => [
        [
            'name'  => 'Прізвище І. Б.',
            'role'  => 'Завідувач кафедри, професор, д.т.н.',
            'focus' => 'Архітектура ігрових рушіїв, комп’ютерна графіка',
        ],
        [
            'name'  => 'Прізвище І. Б.',
            'role'  => 'Доцент, к.т.н.',
            'focus' => 'Програмування графіки, шейдери, GPU',
        ],
        [
            'name'  => 'Прізвище І. Б.',
            'role'  => 'Доцент, к.т.н.',
            'focus' => 'Штучний інтелект у іграх, поведінкові моделі',
        ],
        [
            'name'  => 'Прізвище І. Б.',
            'role'  => 'Старший викладач',
            'focus' => 'Ігрові рушії, Unreal Engine, фізична симуляція',
        ],
        [
            'name'  => 'Прізвище І. Б.',
            'role'  => 'Викладач',
            'focus' => 'Алгоритми та структури даних, оптимізація',
        ],
        [
            'name'  => 'Прізвище І. Б.',
            'role'  => 'Викладач (індустріальний ментор)',
            'focus' => 'Практика розробки ААА-проєктів, C++',
        ],
    ],

    // ------------------------------------------------------------------
    // Новини (сторінка «Новини» + прев’ю на головній)
    // ------------------------------------------------------------------
    'news' => [
        [
            'slug'      => 'open-day-2026',
            'date'      => '2026-09-01',
            'tag'       => 'Подія',
            'title'     => 'День відкритих дверей на ФІОТ',
            'excerpt'   => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Запрошуємо абітурієнтів на зустріч з викладачами та студентами програми.',
            'body'      => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.',
        ],
        [
            'slug'      => 'student-game-jam',
            'date'      => '2026-08-20',
            'tag'       => 'Хакатон',
            'title'     => 'Студентський Game Jam: 48 годин на прототип',
            'excerpt'   => 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.',
            'body'      => 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit.',
        ],
        [
            'slug'      => 'unreal-engine-course',
            'date'      => '2026-08-05',
            'tag'       => 'Навчання',
            'title'     => 'Новий курс: Unreal Engine 5 у навчальному плані',
            'excerpt'   => 'Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione.',
            'body'      => 'Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit.',
        ],
        [
            'slug'      => 'partnership-aaa-studio',
            'date'      => '2026-07-18',
            'tag'       => 'Партнери',
            'title'     => 'Угоду про співпрацю з ігровою студією підписано',
            'excerpt'   => 'Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam.',
            'body'      => 'Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam.',
        ],
        [
            'slug'      => 'admission-2026-results',
            'date'      => '2026-07-01',
            'tag'       => 'Вступ',
            'title'     => 'Підсумки вступної кампанії 2026',
            'excerpt'   => 'Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur.',
            'body'      => 'Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur.',
        ],
        [
            'slug'      => 'student-project-showcase',
            'date'      => '2026-06-15',
            'tag'       => 'Проєкти',
            'title'     => 'Захист студентських ігрових проєктів',
            'excerpt'   => 'At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores.',
            'body'      => 'At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi.',
        ],
    ],

];