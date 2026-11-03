<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ModeofStudy extends Model
{
    use HasFactory;

    protected $table = 'modes_of_study';

    protected $fillable = ['name'];

    public function disciplines(): HasMany
    {
        return $this->hasMany(Discipline::class, 'mode_of_study_id');
    }
}
