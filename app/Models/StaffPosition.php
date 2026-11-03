<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StaffPosition extends Model
{
    protected $table = 'staff_positions';

    protected $fillable = ['name', 'sort_order'];

    public function staff()
    {
        return $this->hasMany(Staff::class, 'position_id');
    }
}
