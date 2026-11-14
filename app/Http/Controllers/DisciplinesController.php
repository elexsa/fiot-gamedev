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
    public function syllabuses(Request $request): View|string
    {
        $perPageOptions = [5, 10, 15, 25];
        $defaultPerPage = 5;

        $perPage = (int) $request->query('per_page', $defaultPerPage);
        if (! in_array($perPage, $perPageOptions)) {
            $perPage = $defaultPerPage;
        }

        $filters = [
            'q' => trim((string) $request->query('q', '')),
            'staff_id' => $request->query('staff_id'),
            //'discipline_name' => trim((string) $request->query('discipline_name', '')),
            'program_id' => $request->query('program_id'),
            'year_of_study_id' => $request->query('year_of_study_id'),
            'semester_id' => $request->query('semester_id'),
            'degree_id' => $request->query('degree_id'),
            'mode_of_study_id' => $request->query('mode_of_study_id'),
            'academic_year' => $request->query('academic_year'),
            'syllabus_id' => $request->query('syllabus_id'),
            'per_page' => $perPage,
        ];

        $disciplines = Discipline::published()
            ->with([
                'program:id,name,academic_year,is_published,is_external,external_link,degree_id',
                'program.degree:id,name',
                'yearOfStudy:id,name',
                'semester:id,name',
                'modeOfStudy:id,name',
                'staff:id,first_name,last_name,patronymic,avatar'
            ])
            ->filter($filters)
            ->orderBy('start_date', 'desc')
            ->orderBy('end_date', 'desc')
            ->orderBy('name')
            ->paginate($perPage)
            ->onEachSide(1)
            ->withQueryString();

        // Якщо це AJAX-запит пагінації/фільтрації — віддаємо лише таблицю, не навантажуючи довідниками
        if ($request->ajax() || $request->header('X-Partial-Render') === 'true') {
            return view('partials.syllabuses-table-content', [
                'filters' => $filters,
                'disciplines' => $disciplines,
                'perPageOptions' => $perPageOptions,
            ])->render();
        }

        return view('syllabuses', [
            'filters' => $filters,
            'disciplines' => $disciplines,
            'found' => $disciplines->total(),
            'perPageOptions' => $perPageOptions,
            'programs' => Program::published()->orderBy('academic_year', 'desc')->select(['id', 'name', 'academic_year'])->get(),
            'yearsOfStudy' => YearOfStudy::select(['id', 'name'])->get(),
            'semesters' => Semester::select(['id', 'name'])->get(),
            'degrees' => Degree::select(['id', 'name'])->get(),
            'studyForms' => ModeofStudy::select(['id', 'name'])->get(),
            'academicYears' => Discipline::published()->whereNotNull('academic_period')->select('academic_period')->distinct()->orderBy('academic_period', 'desc')->pluck('academic_period'),
        ]);
    }

    public function diagram(Request $request): View|string
    {
        $programs = Program::published()->notExternal()
            ->orderBy('academic_year', 'desc')
            ->select(['id', 'name', 'academic_year'])
            ->get();

        $programId = $request->query('program_id', $programs->first()?->id);

        $disciplines = Discipline::published()
            ->where('program_id', $programId)
            ->with(['program', 'yearOfStudy', 'semester', 'modeOfStudy', 'staff', 'prerequisites:id', 'successors:id'])
            ->join('years_of_study', 'disciplines.year_of_study_id', '=', 'years_of_study.id')
            ->join('semesters', 'disciplines.semester_id', '=', 'semesters.id')
            ->orderBy('years_of_study.level', 'asc')
            ->orderBy('semesters.level', 'asc')
            ->orderBy('disciplines.sort_order')
            ->orderBy('disciplines.name')
            ->select('disciplines.*')
            ->get();

        $coursesData = $disciplines->map(fn($discipline) => [
            'id' => $discipline->id,
            'name' => $discipline->name,
            'year' => $discipline->yearOfStudy?->name ?? '—',
            'semester' => $discipline->semester?->name ?? '—',
            'year_id' => $discipline->year_of_study_id,
            'semester_id' => $discipline->semester_id,
            'prerequisites' => $discipline->prerequisites->pluck('id')->all(),
            'successors' => $discipline->successors->pluck('id')->all(),
        ])->values(); // Гарантує, що у JSON це буде масив, який зберігає порядок сортування з бази даних

        $viewData = [
            'filters' => ['program_id' => $programId],
            'disciplines' => $disciplines,
            'coursesJson' => $coursesData->toJson(),
            'programs' => $programs,
            'selectedProgramId' => $programId,
        ];

        // Якщо це AJAX-запит зміни програми — повертаємо лише контент діаграми
        if ($request->ajax() || $request->header('X-Partial-Render') === 'true') {
            return view('partials.diagram-content', $viewData)->render();
        }

        return view('syllabuses-diagram', $viewData);
    }
}
