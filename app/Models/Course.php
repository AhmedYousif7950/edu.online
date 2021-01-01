<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $table = 'courses';

    public function students()
    {
        return $this->hasMany('App\Models\CourseStudent');
    }
    public function teachers()
    {
        return $this->hasMany('App\Models\TeacherCourse');
    }
    public function assignments()
    {
        return $this->hasMany('App\Models\CourseAssignment');
    }
}
