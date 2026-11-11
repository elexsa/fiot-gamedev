<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class Staff extends Model
{
    protected $table = 'staff';

    protected $fillable = [
        'first_name',
        'last_name',
        'patronymic',
        'degree_id',
        'academic_rank_id',
        'position_id',
        'avatar',
        'bio',
        'scopus_url',
        'orcid_url',
        'wos_url',
        'scholar_url',
        'intellect_url',
        'is_published',
    ];

    protected $appends = [
        'avatar_url',
        'position_color',
        'degree_color',
        'rank_color',
    ];

    // ==========================================
    // ЗВ'ЯЗКИ (RELATIONS) - Чисті для Filament
    // ==========================================

    public function disciplines(): BelongsToMany
    {
        return $this->belongsToMany(Discipline::class, 'staff_disciplines', 'staff_id', 'discipline_id');
    }

    public function degree(): BelongsTo
    {
        return $this->belongsTo(StaffDegree::class, 'degree_id');
    }

    public function academicRank(): BelongsTo
    {
        return $this->belongsTo(StaffAcademicRank::class, 'academic_rank_id');
    }

    public function position(): BelongsTo
    {
        return $this->belongsTo(StaffPosition::class, 'position_id');
    }

    public function achievements(): HasMany
    {
        return $this->hasMany(StaffAchievement::class, 'staff_id');
    }

    // ==========================================
    // ДОПОМІЖНІ МЕТОДИ
    // ==========================================

    public function activeDisciplines(): BelongsToMany
    {
        $now = Carbon::now();

        return $this->disciplines()
            ->whereDate('disciplines.start_date', '<=', $now)
            ->whereDate('disciplines.end_date', '>=', $now);
    }

    // ==========================================
    // ЛОКАЛЬНІ СКРОПИ (SCOPES)
    // ==========================================

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('staff.is_published', true);
    }

    public function scopeSearch(Builder $query, ?string $term): Builder
    {
        if (blank($term)) {
            return $query;
        }

        $searchTerms = array_filter(explode(' ', $term), fn ($t) => trim($t) !== '');

        return $query->where(function ($q) use ($searchTerms) {
            foreach ($searchTerms as $t) {
                $q->where(function ($subQ) use ($t) {
                    $subQ->where('staff.first_name', 'like', "%{$t}%")
                        ->orWhere('staff.last_name', 'like', "%{$t}%")
                        ->orWhere('staff.patronymic', 'like', "%{$t}%")
                        ->orWhereHas('position', fn ($posQ) => $posQ->where('name', 'like', "%{$t}%"))
                        ->orWhereHas('degree', fn ($degQ) => $degQ->where('name', 'like', "%{$t}%"))
                        ->orWhereHas('academicRank', fn ($rankQ) => $rankQ->where('name', 'like', "%{$t}%"))
                        ->orWhereHas('disciplines', fn ($discQ) => $discQ->where('disciplines.name', 'like', "%{$t}%"));
                });
            }
        });
    }

    public function scopeWithStaffRelations(Builder $query): Builder
    {
        $now = Carbon::now();

        return $query->with([
            'achievements' => fn ($q) => $q->orderBy('year', 'desc'),
            'degree',
            'academicRank',
            'position',
            'disciplines' => fn ($q) => $q//->whereDate('disciplines.start_date', '<=', $now)
                ->whereDate('disciplines.end_date', '>=', $now),
        ]);
    }

    public function scopeSortedByPositionAndName(Builder $query): Builder
    {
        return $query->leftJoin('staff_positions', 'staff.position_id', '=', 'staff_positions.id')
            ->orderByRaw('COALESCE(staff_positions.sort_order, 999) asc')
            ->orderBy('staff.last_name', 'asc')
            ->orderBy('staff.first_name', 'asc')
            ->select('staff.*');
    }

    // ==========================================
    // АКСЕСОАРИ (ATTRIBUTES)
    // ==========================================

    protected function avatarUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->avatar ? Storage::url($this->avatar) : null,
        );
    }

    protected function positionColor(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->resolveColor($this->position?->name, 'position')
        );
    }

    protected function degreeColor(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->resolveColor($this->degree?->name, 'degree')
        );
    }

    protected function rankColor(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->resolveColor($this->academicRank?->name, 'rank')
        );
    }

    private function resolveColor(?string $name, string $categoryType): string
    {
        if (! $name || in_array($name, ['Відсутнє', 'Відсутній', 'Відсутня'], true)) {
            return 'bg-slate-800 border-slate-700 text-slate-400 shadow-none';
        }

        $hash = crc32($name);

        $palettes = [
            'position' => [
                'bg-rose-950 border-rose-800 text-rose-100',
                'bg-pink-950 border-pink-800 text-pink-100',
                'bg-fuchsia-950 border-fuchsia-800 text-fuchsia-100',
                'bg-red-950 border-red-800 text-red-100',
                'bg-teal-950 border-teal-800 text-teal-100',
            ],
            'degree' => [
                'bg-violet-950 border-violet-800 text-violet-100',
                'bg-emerald-950 border-emerald-800 text-emerald-100',
                'bg-blue-950 border-blue-800 text-blue-100',
                'bg-cyan-950 border-cyan-800 text-cyan-100',
            ],
            'rank' => [
                'bg-purple-950 border-purple-800 text-purple-100',
                'bg-indigo-950 border-indigo-800 text-indigo-100',
                'bg-amber-950 border-amber-800 text-amber-100',
                'bg-sky-950 border-sky-800 text-sky-100',
            ],
        ];

        $pool = $palettes[$categoryType] ?? $palettes['position'];

        return $pool[abs($hash) % count($pool)];
    }
}
