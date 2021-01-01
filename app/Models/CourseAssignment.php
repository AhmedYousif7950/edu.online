<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseAssignment extends Model
{
    protected $table = 'course_assignments';

    public function course()
    {
        return $this->belongsTo('App\Models\Course');
    }
}
