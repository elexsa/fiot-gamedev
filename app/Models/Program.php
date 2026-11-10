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
}
