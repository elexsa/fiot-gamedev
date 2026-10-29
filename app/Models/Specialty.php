<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Specialty extends Model
{
    protected $table = 'specialties';

    protected $fillable = ['specialty_code', 'specialty_name', 'field_of_study_id'];

    public function fieldOfStudy(): BelongsTo
    {
        return $this->belongsTo(FieldOfStudy::class, 'field_of_study_id', 'id');
    }

    public function programs(): HasMany
    {
        return $this->hasMany(Program::class, 'specialty_id', 'id');
    }
}
