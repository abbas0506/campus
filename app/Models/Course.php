<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'short',
        'code',
        'course_type_id',
        'cr_theory',
        'cr_practical',
        'marks_theory',
        'marks_practical',
        'department_id',
        'prerequisite_course_id',
    ];

    public function course_type()
    {
        return $this->belongsTo(CourseType::class);
    }
    public function prerequisite_course()
    {
        return $this->belongsTo(Course::class);
    }
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    // related allocations
    public function course_allocations()
    {
        return $this->hasMany(CourseAllocation::class);
    }

    public function creditHrs()
    {
        return $this->cr_theory + $this->cr_practical;
    }
    public function marks()
    {
        return $this->marks_theory + $this->marks_practical;
    }
    public function creditHrsLabel()
    {
        return $this->cr_theory + $this->cr_practical . "(" . $this->cr_theory . "-" . $this->cr_practical . ")";
    }
    public function scopeType($query, $type)
    {
        return $query->where('course_type_id', $type);
    }
    public function scopeDeptt($query, $id)
    {
        return $query->where('department_id', $id);
    }

    //new style for cr hr, will replace the older
    public function lblCr()
    {
        return $this->cr_theory + $this->cr_practical . "(" . $this->cr_theory . "-" . $this->cr_practical . ")";
    }
    public function cr()
    {
        return $this->cr_theory + $this->cr_practical;
    }
}
