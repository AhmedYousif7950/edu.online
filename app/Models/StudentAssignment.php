<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentAssignment extends Model
{
    protected $table = 'student_assignments';

    public function course()
    {
        return $this->belongsTo('App\Models\Course');
    }
}
