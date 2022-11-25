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

    // public function semester()
    // {
    //     return $this->belongsTo(Semester::class);
    // }
    // public function program()
    // {
    //     return $this->belongsTo(Program::class);
    // }
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
        return 'Section -  ' . $this->name;
    }
    public function title()
    {
        return $this->clas->title() . " / " . $this->name();
    }

    public function has_course($course_id)
    {
        // if course already scheduled, return true
        return $this->course_allocations()->where('course_id', $course_id)->count() > 0 ? true : false;
    }
}
