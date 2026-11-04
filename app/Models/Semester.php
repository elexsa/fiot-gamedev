<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Semester extends Model
{
    protected $table = 'semesters';

    protected $fillable = ['name', 'level'];

    public function disciplines(): HasMany
    {
        return $this->hasMany(Discipline::class, 'semester_id');
    }
}
