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

    public function syllabuses(Request $request): View|string
    {
        $query = Discipline::published()->with(['program.degree', 'yearOfStudy', 'semester', 'modeOfStudy', 'staff']);

        $perPageOptions = [5, 10, 15, 25];
        $defaultPerPage = 5;

        $perPage = (int) $request->query('per_page', $defaultPerPage);
        if (! in_array($perPage, $perPageOptions)) {
            $perPage = $defaultPerPage;
        }

        // Фільтри
        $filters = [
            'q' => trim((string) $request->query('q', '')),
            'staff_id' => $request->query('staff_id'),
            'discipline_name' => trim((string) $request->query('discipline_name', '')),
            'program_id' => $request->query('program_id'),
            'year_of_study_id' => $request->query('year_of_study_id'),
            'semester_id' => $request->query('semester_id'),
            'degree_id' => $request->query('degree_id'),
            'mode_of_study_id' => $request->query('mode_of_study_id'),
            'academic_year' => $request->query('academic_year'),
            'syllabus_id' => $request->query('syllabus_id'),
            'per_page' => $perPage,
        ];

        // Пошук по кожному слову окремо для назви та викладачів
        if ($filters['q'] !== '') {
            $searchTerms = explode(' ', $filters['q']);

            $query->where(function ($q) use ($searchTerms) {
                foreach ($searchTerms as $term) {
                    $term = trim($term);
                    if ($term === '') {
                        continue;
                    }

                    $q->where(function ($subQ) use ($term) {
                        $subQ->where('name', 'like', "%{$term}%")
                            ->orWhereHas('staff', function ($staffQuery) use ($term) {
                                $staffQuery->where('last_name', 'like', "%{$term}%")
                                    ->orWhere('first_name', 'like', "%{$term}%")
                                    ->orWhere('patronymic', 'like', "%{$term}%");
                            });
                    });
                }
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

        // Фільтрація за ID викладача
        if (filled($filters['staff_id'])) {
            $query->whereHas('staff', function ($q) use ($filters) {
                $q->where('staff.id', $filters['staff_id']);
            });
        }

        // Фільтрація за назвою дисципліни (частковий збіг)
        if (filled($filters['discipline_name'])) {
            $query->where('name', 'like', "%{$filters['discipline_name']}%");
        }

        $disciplines = $query->orderBy('start_date', 'desc')
            ->orderBy('end_date', 'desc')
            ->orderBy('name')
            ->paginate($perPage)
            ->onEachSide(1)
            ->withQueryString();

        // Перевірка на AJAX або частковий рендеринг
        if ($request->ajax() || $request->header('X-Partial-Render') === 'true') {
            return view('partials.syllabuses-table-content', [
                'filters' => $filters,
                'disciplines' => $disciplines,
                'perPageOptions' => $perPageOptions,
            ])->render();
        }

        // Відображати всі освітні програми
        // Освітні програми (не кафедри) позначені як is_external = true
        // Інші освітні програми не відображаються у розділі на сайті кафедри, але для фільтрів та таблиці дисциплін із силабусами відображаються
        $programs = Program::published()->orderBy('academic_year', 'desc')
            ->select(['id', 'name', 'academic_year'])->get();

        $yearsOfStudy = YearOfStudy::select(['id', 'name'])->get();
        $semesters = Semester::select(['id', 'name'])->get();
        $degrees = Degree::select(['id', 'name'])->get();
        $studyForms = ModeofStudy::select(['id', 'name'])->get();
        $academicYears = Discipline::published()->distinct()->orderBy('academic_period', 'desc')->pluck('academic_period');

        return view('syllabuses', [
            'filters' => $filters,
            'disciplines' => $disciplines,
            'found' => $disciplines->total(),
            'perPageOptions' => $perPageOptions,
            'programs' => $programs,
            'yearsOfStudy' => $yearsOfStudy,
            'semesters' => $semesters,
            'degrees' => $degrees,
            'studyForms' => $studyForms,
            'academicYears' => $academicYears,
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
