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
    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }

    public function registered()
    {
    }
    public function unregistered()
    {
    }
    public function registrations()
    {
        $course_enrollment_ids = CourseEnrollment::where('course_id', $this->course_id)->pluck('id')->toArray();
        $results = Result::where('teacher_id', $this->teacher_id)
            ->where('semester_id', session('semester_id'))
            ->whereIn('course_enrollment_id', $course_enrollment_ids)
            ->get();

        return $results;
    }
    public function results()
    {
        $course_enrollment_ids = CourseEnrollment::where('course_id', $this->course_id)->pluck('id')->toArray();
        return $this->semester->results
            ->where('teacher_id', $this->teacher_id)
            ->whereIn('course_enrollment_id', $course_enrollment_ids);
    }
}
