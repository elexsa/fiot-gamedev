<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'name',
    'description',
    'image',
    'is_published',
    'sort_order',
    'start_date',
    'end_date',
    'specialty_id',
    'degree_id',
    'external_link',
])]
class Program extends Model
{
    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'start_date' => 'date',
            'end_date' => 'date',
        ];
    }

    public function disciplines(): HasMany
    {
        return $this->hasMany(Discipline::class);
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true);
    }

    public function specialty(): BelongsTo
    {
        return $this->belongsTo(Specialty::class, 'specialty_id', 'id');
    }

    public function degree(): BelongsTo
    {
        return $this->belongsTo(Degree::class, 'degree_id', 'id');
    }

    public static function getGroupedPrograms(): array
    {
        // Отримуємо ступені відразу з відфільтрованими опублікованими програмами та спеціальностями
        $degrees = Degree::query()
            ->orderBy('level', 'asc')
            ->whereHas('programs', fn ($q) => $q->published())
            ->with([
                'programs' => fn ($q) => $q->published()
                    ->with('specialty:id,specialty_name,specialty_code')
                    ->orderBy('start_date', 'desc')
                    ->orderBy('end_date', 'desc')
                    ->select([
                        'id',
                        'name',
                        'description',
                        'start_date',
                        'end_date',
                        'academic_year',
                        'degree_id',
                        'specialty_id',
                        'external_link',
                    ]),
            ])
            ->get();

        // Формуємо зручну структуру даних для Blade
        return $degrees->mapWithKeys(function ($degree) {
            $academicYears = $degree->programs->groupBy('academic_year')->map(function ($programsInYear) {
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
            })->all();

            return [
                $degree->id => [
                    'degree_name' => $degree->name,
                    'degree_level' => $degree->level,
                    'academic_years' => $academicYears,
                ],
            ];
        })->all();
    }
}
