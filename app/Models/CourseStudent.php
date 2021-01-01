<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseStudent extends Model
{
    protected $table = 'course_students';

    public function course()
    {
        return $this->belongsTo('App\Models\Course');
    }

}
