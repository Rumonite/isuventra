<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Participation extends Model
{
    protected $fillable = ['event_id', 'student_id', 'time_in', 'time_out', 'status'];
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
