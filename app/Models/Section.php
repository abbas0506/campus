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
    // public function cr() //allocated till current semester
    // {
    //     $sum = $this->course_allocations()->till(session('semester_id'))->where('slot_id', '>', 0)->get()->sum(function ($course_allocation) {
    //         return $course_allocation->course->creditHrs();
    //     });
    //     return $sum;
    // }

    public function completed_cr() //completed till current semester no
    {
        $semester_no = $this->clas->semesterNo(session('semester_id'));
        $completed = $this->clas->scheme->slots()->till($semester_no)->get()->sum(function ($slot) {
            return $slot->cr;
        });
        return $completed;
    }

    public function total_marks() //w.r.t course allocations
    {
        $sum = $this->course_allocations()->till(session('semester_id'))->get()->sum(function ($course_allocation) {
            return $course_allocation->course->marks_theory + $course_allocation->course->marks_practical;
        });
        return $sum;
    }

    public function semesters()
    {
        return Semester::whereBetween('id', [$this->clas->first_semester_id, session('semester_id')])->get();
    }

    public function equivalent()
    {
        $classes = Clas::where('program_id', $this->clas->program_id)->get();

        echo $classes;

        //return $classes;


    }

    // public function semester_nos()
    // {
    //     $semester_nos = collect();
    //     for ($i = $this->clas->program->intake; $i < $this->clas->program->intake + $this->clas->program->min_t * 2; $i++) {
    //         $semester_nos->add($i);
    //     }
    // }
}
