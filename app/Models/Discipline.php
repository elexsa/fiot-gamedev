<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
}
