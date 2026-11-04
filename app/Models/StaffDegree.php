<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StaffDegree extends Model
{
    protected $table = 'staff_degrees';

    protected $fillable = ['name', 'sort_order'];

    public function staff()
    {
        return $this->hasMany(Staff::class, 'degree_id');
    }
}
