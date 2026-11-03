<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StaffAchievement extends Model
{
    protected $table = 'staff_achievements';

    protected $fillable = [
        'staff_id',
        'year',
        'achievement_description',
    ];

    public function staff()
    {
        return $this->belongsTo(Staff::class, 'staff_id');
    }
}
