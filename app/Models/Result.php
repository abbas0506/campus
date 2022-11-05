<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'course_allocation_id',
        'is_reappear',
        'assignment',
        'presentation',
        'midterm',
        'summative',
        'internal_id',
        'hod_id',
        'forwarded_at',
        'kpo_id',
        'controller_id',
        'approved_at',

    ];
    public  function student()
    {
        return $this->belongsTo(Student::class);
    }
    public  function course_allocation()
    {
        return $this->belongsTo(CourseAllocation::class);
    }
}
