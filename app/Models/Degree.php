<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Degree extends Model
{
    protected $table = 'degrees';

    protected $fillable = ['name', 'level'];

    public function programs(): HasMany
    {
        return $this->hasMany(Program::class, 'degree_id', 'id');
    }
}
