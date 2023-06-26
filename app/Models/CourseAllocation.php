<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseAllocation extends Model
{
    use HasFactory;
    protected $fillable = [
        'section_id',
        'semester_no',
        'course_id',    //optional course id
        'scheme_detail_id',
        'teacher_id',
        'semester_id',

    ];

    public function section()
    {
        return $this->belongsTo(Section::class);
    }
    public function scheme_detail()
    {
        return $this->belongsTo(SchemeDetail::class);
    }
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }
    public function internal()
    {
        return $this->section->clas->program->internal;
    }
    public function hod()
    {
        return $this->section->clas->program->department->headship->user;
    }
    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }
    public function first_attempts()
    {
        return $this->hasMany(FirstAttempt::class);
    }
    public function reappears()
    {
        return $this->hasMany(Reappear::class);
    }
    public function strength()
    {
        return $this->first_attempts->count() + $this->reappears->count();
    }
    public function enrolled_students()
    {
        return Student::whereRelation('first_attempts.student', 'course_allocation_id', $this->id)->get();
    }
    public function first_attempts_sorted()
    {
        return FirstAttempt::with('student')->where('course_allocation_id', $this->id)->get()->sortBy('student.rollno');
    }
    public function reappears_sorted()
    {
        return Reappear::with('first_attempt')->where('course_allocation_id', $this->id)->get()->sortBy('first_attempt.student.rollno');
    }
    public function scopeAllocated($query, $no)
    {
        return $query->where('semester_no', $no);
    }
    public function scopeSumOfCreditHrs($query, $no)
    {
        return $query->where('semester_no', $no)->get()->sum(function ($allocation) {
            return $allocation->course->creditHrs();
        });
    }
    public function scopeDuring($query, $semester_id)
    {
        return $query->where('semester_id', $semester_id);
    }
}
