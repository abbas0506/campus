<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseAllocation extends Model
{
    use HasFactory;
    protected $fillable = [
        'scheme_detail_id',
        'semester_id',
        'section_id',
        'course_id',    //optional course id
        'teacher_id',

    ];

    public function scheme_detail()
    {
        return $this->belongsTo(SchemeDetail::class);
    }
    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
    public function section()
    {
        return $this->belongsTo(Section::class);
    }
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
