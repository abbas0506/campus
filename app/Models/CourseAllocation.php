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
        'scheme_detail_id',
        'course_id',    //optional course id
        'teacher_id',

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
        return $this->belongsTo(Teacher::class);
    }
}
