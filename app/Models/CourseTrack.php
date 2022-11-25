<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseTrack extends Model
{
    use HasFactory;
    protected $fillable = [
        'student_id',
        'program_id',
        'course_id',
        'semester_no',
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
    public function status()
    {
        return ''; //not appreared: '', fail:0, pass:1 
    }
    public function attempts()
    {
        return $this->hasMany(Result::class);
    }
    public function results()
    {
        return $this->hasMany(Result::class);
    }
    public function successfulAttempt()
    {
        // return attempt where passed;
        return '';
    }
}
