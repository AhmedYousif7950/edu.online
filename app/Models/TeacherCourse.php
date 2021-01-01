<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeacherCourse extends Model
{
    protected $table = 'teacher_courses';

    public function course()
    {
        return $this->belongsTo('App\Models\Course');
    }
}
