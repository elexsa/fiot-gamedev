<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class YearOfStudy extends Model
{
    protected $table = 'years_of_study';

    protected $fillable = ['name', 'level'];
}
