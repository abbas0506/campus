<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseEnrollment extends Model
{
    use HasFactory;
    protected $fillable = [
        'student_id',
        'course_id',
        'semester_no',
    ];
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
    public function status()
    {
        return ''; //not appreared: '', fail:0, pass:1 
    }
    public function attempts()
    {
        return $this->hasMany(Attempt::class);
    }
    public function successfulAttempt()
    {
        // return attempt where passed;
        return '';
    }
}
