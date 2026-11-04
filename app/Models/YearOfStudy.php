<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class YearOfStudy extends Model
{
    protected $table = 'years_of_study';

    protected $fillable = ['name', 'level'];

    public function disciplines(): HasMany
    {
        return $this->hasMany(Discipline::class, 'year_of_study_id');
    }
}
