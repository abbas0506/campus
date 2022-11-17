<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'short',
        'code',
        'course_type_id',
        'credit_hrs_theory',
        'max_marks_theory',
        'credit_hrs_practical',
        'max_marks_practical',
        'department_id',
    ];

    public function course_type()
    {
        return $this->belongsTo(CourseType::class);
    }
    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
