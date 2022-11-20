<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attempt extends Model
{
    use HasFactory;
    protected $fillable = [
        'course_enrollment_id',
        'semester_id',
        'semester_no',

        'assignment',
        'presentation',
        'midterm',
        'summative',
        'teacher_id',
        'internal_id',
        'hod_id',
        'forwarded_at',
        'kpo_id',
        'controller_id',
        'approved_at',  //make it blank to make editable

    ];
    public function course_enrollment()
    {
        return $this->belongsTo(CourseEnrollment::class);
    }
    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }
    public function status()
    {
        return ''; //not appreared: '', fail:0, pass:1 
    }
    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }
}
