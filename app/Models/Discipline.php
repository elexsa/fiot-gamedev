<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'program_id', 'name', 'description', 'category', 'cycle', 'credits', 'hours',
    'level', 'semester', 'course', 'study_form', 'teacher', 'academic_year',
    'education_level', 'is_elective', 'is_boss',
    'prerequisites', 'syllabus_file', 'syllabus_url', 'image',
    'is_published', 'sort_order',
])]
class Discipline extends Model
{
    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'is_boss' => 'boolean',
            'prerequisites' => 'array',
        ];
    }

    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true);
    }
}
