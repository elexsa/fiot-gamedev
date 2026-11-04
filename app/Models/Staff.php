<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
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

    public function disciplines()
    {
        return $this->belongsToMany(Discipline::class, 'staff_disciplines', 'staff_id', 'discipline_id');
    }

    public function degree()
    {
        return $this->belongsTo(StaffDegree::class, 'degree_id');
    }

    public function academicRank()
    {
        return $this->belongsTo(StaffAcademicRank::class, 'academic_rank_id');
    }

    public function position()
    {
        return $this->belongsTo(StaffPosition::class, 'position_id');
    }

    public function achievements()
    {
        return $this->hasMany(StaffAchievement::class, 'staff_id'); // ->orderBy('year', 'desc');
    }

    /**
     * Автоматично додаємо avatar_url до масиву/JSON для фронтенду.
     */
    protected $appends = ['avatar_url'];

    /**
     * Генерація повного публічного URL для фронтенду (Blade / Alpine.js).
     */
    protected function avatarUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->avatar ? Storage::url($this->avatar) : null,
        );
    }
}
