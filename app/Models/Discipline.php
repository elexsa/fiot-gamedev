<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Discipline extends Model
{
    use HasFactory;

    protected $table = 'disciplines';

    protected $fillable = [
        'program_id',
        'name',
        'description',
        'syllabus_url',
        'image',
        'is_published',
        'sort_order',
        'credits',
        'hours',
        'is_elective',
        'mode_of_study_id',
        'semester_id',
        'year_of_study_id',
        'start_date',
        'end_date',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function staff()
    {
        return $this->belongsToMany(Staff::class, 'staff_disciplines', 'discipline_id', 'staff_id');
    }

    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class, 'program_id');
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true);
    }

    // Зв'язок із формою навчання (створений раніше)
    public function modeOfStudy(): BelongsTo
    {
        return $this->belongsTo(ModeofStudy::class, 'mode_of_study_id');
    }

    // Зв'язок із семестром
    public function semester(): BelongsTo
    {
        return $this->belongsTo(Semester::class, 'semester_id');
    }

    // Зв'язок із курсом навчання
    public function yearOfStudy(): BelongsTo
    {
        return $this->belongsTo(YearOfStudy::class, 'year_of_study_id');
    }

    public function scopeFilter(Builder $query, array $filters): Builder
    {
        // Пошук по кожному слову (назва дисципліни або ПІБ викладача)
        if (!empty($filters['q'])) {
            $searchTerms = explode(' ', $filters['q']);
            $query->where(function ($q) use ($searchTerms) {
                foreach ($searchTerms as $term) {
                    $term = trim($term);
                    if ($term === '') continue;

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

        // Точкові фільтри
        return $query
            ->when($filters['syllabus_id'] ?? null, fn($q, $id) => $q->where('id', $id))
            ->when($filters['program_id'] ?? null, fn($q, $id) => $q->where('program_id', $id))
            ->when($filters['year_of_study_id'] ?? null, fn($q, $id) => $q->where('year_of_study_id', $id))
            ->when($filters['semester_id'] ?? null, fn($q, $id) => $q->where('semester_id', $id))
            ->when($filters['mode_of_study_id'] ?? null, fn($q, $id) => $q->where('mode_of_study_id', $id))
            ->when($filters['academic_year'] ?? null, fn($q, $year) => $q->where('academic_period', $year))
            ->when($filters['degree_id'] ?? null, fn($q, $degreeId) => $q->whereHas('program', fn($sub) => $sub->where('degree_id', $degreeId)))
            ->when($filters['staff_id'] ?? null, fn($q, $staffId) => $q->whereHas('staff', fn($sub) => $sub->where('staff.id', $staffId)));
        //->when($filters['discipline_name'] ?? null, fn($q, $name) => $q->where('name', 'like', "%{$name}%"));
    }

    /**
     * Дисципліни, які є попередніми (пререквізити) для поточної.
     */
    public function prerequisites(): BelongsToMany
    {
        return $this->belongsToMany(
            Discipline::class,
            'discipline_prerequisites',
            'discipline_id',
            'prerequisite_id'
        );
    }

    /**
     * Дисципліни, для яких поточна є попередньою.
     */
    public function successors(): BelongsToMany
    {
        return $this->belongsToMany(
            Discipline::class,
            'discipline_prerequisites',
            'prerequisite_id',
            'discipline_id'
        );
    }
}
