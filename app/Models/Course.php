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
        'credit_hrs_theory',
        'max_marks_theory',
        'credit_hrs_practical',
        'max_marks_practical',
        'department_id',
    ];

    public function course_type()
    {
        return $this->belongsTo(CourseType::class);
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
        return $this->credit_hrs_theory + $this->credit_hrs_practical;
    }
    public function marks()
    {
        return $this->max_marks_theory + $this->max_marks_practical;
    }
    public function creditHrsLabel()
    {
        return $this->credit_hrs_theory + $this->credit_hrs_practical . "(" . $this->credit_hrs_theory . "-" . $this->credit_hrs_practical . ")";
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
        return $this->credit_hrs_theory + $this->credit_hrs_practical . "(" . $this->credit_hrs_theory . "-" . $this->credit_hrs_practical . ")";
    }
    public function cr()
    {
        return $this->credit_hrs_theory + $this->credit_hrs_practical;
    }
}
