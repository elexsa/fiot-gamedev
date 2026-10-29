<?php

namespace App\Http\Controllers;

use App\Models\Degree;
use App\Models\Faculty;
use App\Models\News;
use App\Models\Partner;
use App\Models\Program;
use App\Models\SiteSetting;
use Illuminate\Contracts\View\View;

class PageController extends Controller
{
    public function home(): View
    {
        return view('welcome', [
            'latestNews' => News::published()
                ->orderBy('published_at', 'desc')
                ->take(3)
                ->get(),
        ]);
    }

    public function about(): View
    {
        return view('about', [
            'faculty' => Faculty::published()->orderBy('sort_order')->get(),
        ]);
    }

    public function partners(): View
    {
        return view('partners', [
            'partners' => Partner::published()->orderBy('sort_order')->get(),
        ]);
    }

    public function programs(): View
    {

        $groupedData = Degree::query()
            ->orderBy('level', 'asc')
            ->get()
            ->mapWithKeys(function ($degree) {
                // Завантажуємо тільки опубліковані програми для кожного рівня
                $programs = $degree->programs()
                    ->with('specialty:id,specialty_name,specialty_code') // Необхідні поля
                    ->where('is_published', true)
                    ->orderBy('start_date', 'desc')
                    ->orderBy('end_date', 'desc')
                    ->select([
                        'id',
                        'name',
                        'slug',
                        'description',
                        'start_date',
                        'end_date',
                        'academic_year',
                        'degree_id',
                        'specialty_id',
                        'external_link',
                    ])
                    ->get();

                // Якщо ступінь немає опублікованих програм, виключаємо з UI
                if ($programs->isEmpty()) {
                    return [];
                }

                return [
                    $degree->id => [
                        'degree_name' => $degree->name,
                        'degree_level' => $degree->level,
                        'academic_years' => $programs->groupBy('academic_year')
                            ->map(function ($programsInYear) {
                                return $programsInYear->map(function ($program) {
                                    return [
                                        'id' => $program->id,
                                        'name' => $program->name,
                                        'description' => $program->description,
                                        'start_date' => $program->start_date?->format('Y-m-d'),
                                        'end_date' => $program->end_date?->format('Y-m-d'),
                                        'academic_year' => $program->academic_year,
                                        'specialty_name' => $program->specialty?->specialty_name,
                                        'specialty_code' => $program->specialty?->specialty_code,
                                        'external_link' => $program->external_link,
                                    ];
                                })->values()->all();
                            })->all(),
                    ],
                ];
            })
            ->all();

        return view('programs', [
            'degrees' => $groupedData,
        ]);
    }

    public function admission(): View
    {
        return view('admission', [
            'steps' => SiteSetting::get('admission.steps', []),
            'calculator' => SiteSetting::get('admission.calculator', []),
            'programs' => Program::published()->orderBy('sort_order')->get(),
        ]);
    }

    public function contacts(): View
    {
        return view('contacts');
    }
}
