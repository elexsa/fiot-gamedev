<?php

namespace App\Http\Controllers;

use App\Models\Discipline;
use App\Models\Program;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class DisciplinesController extends Controller
{
    /**
     * Пасхалка: ігрове дерево навичок (/disciplines). У навбарі немає —
     * доступ через 5 кліків по лого або прямим посиланням.
     */
    public function index(): View
    {
        $disciplines = Discipline::published()->with('program')
            ->orderBy('level')->orderBy('semester')->orderBy('sort_order')->orderBy('name')->get();

        $connections = [];
        $existingIds = $disciplines->pluck('id')->flip();
        foreach ($disciplines as $discipline) {
            foreach ($discipline->prerequisites ?? [] as $prerequisiteId) {
                if (isset($existingIds[$prerequisiteId])) {
                    $connections[] = ["disc-{$prerequisiteId}", "disc-{$discipline->id}"];
                }
            }
        }

        return view('disciplines', [
            'levels' => $disciplines->groupBy('level')->sortKeys(),
            'connections' => $connections,
        ]);
    }

    /**
     * Аналог https://syllabuses.ist.kpi.ua/uk/Index — каталог силабусів з фільтрами.
     */
    public function syllabuses(Request $request): View
    {
        $query = Discipline::published()->with('program');

        $filters = [
            'q' => trim((string) $request->query('q', '')),
            'program_id' => $request->query('program_id'),
            'course' => $request->query('course'),
            'semester' => $request->query('semester'),
            'education_level' => $request->query('education_level'),
            'study_form' => $request->query('study_form'),
            'academic_year' => $request->query('academic_year'),
        ];

        if ($filters['q'] !== '') {
            $query->where(function ($q) use ($filters) {
                $q->where('name', 'like', "%{$filters['q']}%")
                    ->orWhere('teacher', 'like', "%{$filters['q']}%");
            });
        }

        foreach (['program_id', 'course', 'semester', 'education_level', 'study_form', 'academic_year'] as $field) {
            if (filled($filters[$field])) {
                $query->where($field, $filters[$field]);
            }
        }

        $disciplines = $query->orderBy('course')->orderBy('semester')->orderBy('sort_order')->orderBy('name')->get();

        return view('syllabuses', [
            'filters' => $filters,
            'disciplines' => $disciplines,
            'found' => $disciplines->count(),
            'programs' => Program::published()->orderBy('sort_order')->get(),
            'courses' => Discipline::published()->whereNotNull('course')->distinct()->orderBy('course')->pluck('course'),
            'semesters' => Discipline::published()->whereNotNull('semester')->distinct()->orderBy('semester')->pluck('semester'),
            'educationLevels' => Discipline::published()->whereNotNull('education_level')->distinct()->orderBy('education_level')->pluck('education_level'),
            'studyForms' => Discipline::published()->whereNotNull('study_form')->distinct()->orderBy('study_form')->pluck('study_form'),
            'academicYears' => Discipline::published()->whereNotNull('academic_year')->distinct()->orderBy('academic_year')->pluck('academic_year'),
        ]);
    }

    /**
     * Аналог https://syllabuses.ist.kpi.ua/uk/Diagram — діаграма по курсах/семестрах, циклах + ігрове дерево навичок.
     */
    public function diagram(Request $request): View
    {
        $query = Discipline::published()->with('program');

        $filters = [
            'program_id' => $request->query('program_id'),
            'education_level' => $request->query('education_level'),
            'study_form' => $request->query('study_form'),
            'academic_year' => $request->query('academic_year'),
            'mode' => $request->query('mode', 'courses'),
        ];

        if (! in_array($filters['mode'], ['courses', 'cycles', 'skill'])) {
            $filters['mode'] = 'courses';
        }

        foreach (['program_id', 'education_level', 'study_form', 'academic_year'] as $field) {
            if (filled($filters[$field])) {
                $query->where($field, $filters[$field]);
            }
        }

        $disciplines = $query->orderBy('course')->orderBy('semester')->orderBy('sort_order')->orderBy('name')->get();

        $byCourse = $disciplines->groupBy(fn ($d) => $d->course ?? 0)->sortKeys();
        $byCycle = $disciplines->groupBy(fn ($d) => $d->cycle ?: 'Без циклу')->sortKeys();

        // Зв'язки для ігрового дерева навичок: пари "disc-{id}" на основі prerequisites
        $connections = [];
        $existingIds = $disciplines->pluck('id')->flip();
        foreach ($disciplines as $discipline) {
            foreach ($discipline->prerequisites ?? [] as $prerequisiteId) {
                if (isset($existingIds[$prerequisiteId])) {
                    $connections[] = ["disc-{$prerequisiteId}", "disc-{$discipline->id}"];
                }
            }
        }

        return view('syllabuses-diagram', [
            'filters' => $filters,
            'disciplines' => $disciplines,
            'byCourse' => $byCourse,
            'byCycle' => $byCycle,
            'levels' => $disciplines->groupBy('level')->sortKeys(),
            'connections' => $connections,
            'programs' => Program::published()->orderBy('sort_order')->get(),
            'educationLevels' => Discipline::published()->whereNotNull('education_level')->distinct()->orderBy('education_level')->pluck('education_level'),
            'studyForms' => Discipline::published()->whereNotNull('study_form')->distinct()->orderBy('study_form')->pluck('study_form'),
            'academicYears' => Discipline::published()->whereNotNull('academic_year')->distinct()->orderBy('academic_year')->pluck('academic_year'),
        ]);
    }
}
