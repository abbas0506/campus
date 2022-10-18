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
}
