<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StaffAcademicRank extends Model
{
    protected $table = 'staff_academic_ranks';

    protected $fillable = ['name', 'sort_order'];

    public function staff()
    {
        return $this->hasMany(Staff::class, 'academic_rank_id');
    }
}
