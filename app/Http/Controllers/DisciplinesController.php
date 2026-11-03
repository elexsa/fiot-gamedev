<?php

namespace App\Http\Controllers;

use App\Models\Degree;
use App\Models\Discipline;
use App\Models\ModeofStudy;
use App\Models\Program;
use App\Models\Semester;
use App\Models\YearOfStudy;
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
        /*
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
        */

        // Сторінка тимчасово недоступна.
        return view('coming-soon');
    }

    public function syllabuses(Request $request): View
    {

        $query = Discipline::published()->with(['program.degree', 'yearOfStudy', 'semester', 'modeOfStudy', 'staff']);

        // Фільтри
        $filters = [
            'q' => trim((string) $request->query('q', '')),
            'program_id' => $request->query('program_id'),
            'year_of_study_id' => $request->query('year_of_study_id'),
            'semester_id' => $request->query('semester_id'),
            'degree_id' => $request->query('degree_id'),
            'mode_of_study_id' => $request->query('mode_of_study_id'),
            'academic_year' => $request->query('academic_year'),
            'syllabus_id' => $request->query('syllabus_id'),
        ];

        if ($filters['q'] !== '') {
            $query->where(function ($q) use ($filters) {
                $q->where('name', 'like', "%{$filters['q']}%")
                    ->orWhereHas('staff', function ($staffQuery) use ($filters) {
                        $staffQuery->where('last_name', 'like', "%{$filters['q']}%")
                            ->orWhere('first_name', 'like', "%{$filters['q']}%")
                            ->orWhere('patronymic', 'like', "%{$filters['q']}%");
                    });
            });
        }

        if (filled($filters['syllabus_id'])) {
            $query->where('id', $filters['syllabus_id']);
        }
        if (filled($filters['program_id'])) {
            $query->where('program_id', $filters['program_id']);
        }
        if (filled($filters['year_of_study_id'])) {
            $query->where('year_of_study_id', $filters['year_of_study_id']);
        }
        if (filled($filters['semester_id'])) {
            $query->where('semester_id', $filters['semester_id']);
        }
        if (filled($filters['mode_of_study_id'])) {
            $query->where('mode_of_study_id', $filters['mode_of_study_id']);
        }
        if (filled($filters['academic_year'])) {
            $query->where('academic_period', $filters['academic_year']);
        }
        if (filled($filters['degree_id'])) {
            $query->whereHas('program', function ($q) use ($filters) {
                $q->where('degree_id', $filters['degree_id']);
            });
        }

        $disciplines = $query->orderBy('start_date', 'desc')->orderBy('end_date', 'desc')->orderBy('name')->get();

        return view('syllabuses', [
            'filters' => $filters,
            'disciplines' => $disciplines,
            'found' => $disciplines->count(),
            'programs' => Program::published()->distinct()->orderBy('academic_year', 'desc')
                ->select(['id', 'name', 'academic_year'])->get(),
            'yearsOfStudy' => YearOfStudy::select(['id', 'name'])->get(),
            'semesters' => Semester::select(['id', 'name'])->get(),
            'degrees' => Degree::select(['id', 'name'])->get(),
            'studyForms' => ModeofStudy::select(['id', 'name'])->get(),
            'academicYears' => Discipline::published()->distinct()->orderBy('academic_period', 'desc')->pluck('academic_period'),
        ]);
    }

    /**
     * Аналог https://syllabuses.ist.kpi.ua/uk/Diagram — діаграма по курсах/семестрах, циклах + ігрове дерево навичок.
     */
    public function diagram(Request $request): View
    {
        /*
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
        */

        // Сторінка тимчасово недоступна.
        return view('coming-soon');
    }
}
