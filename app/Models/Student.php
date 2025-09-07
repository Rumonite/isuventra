<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'name',
        'course',
        'year_level',
        'campus',
    ];

    public function participations()
    {
        return $this->hasMany(\App\Models\Participation::class);
    }
}
