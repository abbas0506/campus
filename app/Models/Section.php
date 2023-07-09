<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'clas_id',

    ];

    public function clas()
    {
        return $this->belongsTo(Clas::class, 'clas_id');
    }

    public  function students()
    {
        return $this->hasMany(Student::class);
    }
    public  function course_allocations()
    {
        return $this->hasMany(CourseAllocation::class);
    }

    public function name()
    {
        return 'Section - ' . $this->name;
    }
    public function title()
    {
        return $this->clas->title() . "-" . $this->name;
    }

    public function has_course($course_id)
    {
        // if course already scheduled, return true
        return $this->course_allocations()->where('course_id', $course_id)->count() > 0 ? true : false;
    }
    public function cr() //allocated till now
    {
        $sum = $this->course_allocations->where('semester_id', '<=', session('semester_id'))->sum(function ($course_allocation) {
            return $course_allocation->course->creditHrs();
        });
        return $sum;
    }
    public function total_marks() //w.r.t course allocations
    {
        $sum = $this->course_allocations->where('semester_id', '<=', session('semester_id'))->sum(function ($course_allocation) {
            return $course_allocation->course->marks_theory + $course_allocation->course->marks_practical;
        });
        return $sum;
    }
    public function currentSemester()
    {
        return $this->clas->semester_no;
    }
    public function semesters()
    {
        return Semester::whereBetween('id', [$this->clas->first_semester_id, session('semester_id')])->get();
    }
}
