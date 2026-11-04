<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FieldOfStudy extends Model
{
    protected $table = 'fields_of_study';

    protected $fillable = ['fieldOfStudy_code', 'fieldOfStudy_name'];

    public function specialties(): HasMany
    {
        return $this->hasMany(Specialty::class, 'field_of_study_id', 'id');
    }
}
