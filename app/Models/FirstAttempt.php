<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FirstAttempt extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'program_id',
        'course_id',
        'semester_no',
        'semester_id',

        'assignment',
        'presentation',
        'midterm',
        'summative',

        'course_allocation_id', //2 year old course allocations will be purged
        // 'internal_id',
        // 'hod_id',
        // 'forwarded_at',
        // 'kpo_id',
        // 'controller_id',
        // 'approved_at',  //make it blank to allow editing

    ];
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
    public function program()
    {
        return $this->belongsTo(Program::class);
    }
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }
    public function course_allocation()
    {
        return $this->belongsTo(CourseAllocation::class);
    }
    public function reappears()
    {
        return $this->hasMany(Reappear::class);
    }
}
