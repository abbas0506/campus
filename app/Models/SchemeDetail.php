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
        return $this->hasMany(CourseAllocation::class)
            ->where('section_id', session('section_id'))
            ->where('semester_id', session('semester_id'));
    }
    public function has_allocations()
    {
        return $this->course_allocations()->count() > 0 ? true : false;
    }
    public function is_compulsory()
    {
        return $this->course->course_type_id == 1 ? true : false;
    }
    public function scopeSemester($query, $no)
    {
        return $query->where('semester_no', $no);
    }
    public function scopeFor($query, $semester_no)
    {
        return $query->where('semester_no', $semester_no);
    }
    public function scopeHavingSlot($query, $slot)
    {
        return $query->where('slot', $slot);
    }
}
