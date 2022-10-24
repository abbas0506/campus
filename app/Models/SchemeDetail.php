<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchemeDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'scheme_id',
        'semester_no',
        'course_id',
    ];
    public function scheme()
    {
        return $this->belongsTo(Scheme::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
    public  function course_allocations()
    {
        return $this->hasMany(CourseAllocation::class);
    }

    public  function elective_course_allocations()
    {

        return $this->hasMany(ElectiveCourseAllocation::class);
    }
    public function compulsory_allocations()
    {
        return  $this->course_allocations->where('section_id', session('section_id'));
    }
    public function elective_allocations()
    {
        return  $this->elective_course_allocations->where('section_id', session('section_id'));
    }
    public function has_compulsory_allocations()
    {
        return $this->compulsory_allocations()->count() > 0 ? true : false;
    }
    public function has_elective_allocations()
    {
        return $this->elective_allocations()->count() > 0 ? true : false;
    }
    public function belongs_to_compulsory_course()
    {
        return $this->course->course_type_id == 1 ? true : false;
    }
    public function belongs_to_elective_course()
    {
        return $this->course->course_type_id > 1 ? true : false;
    }
}
