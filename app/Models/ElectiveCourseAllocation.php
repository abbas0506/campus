<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ElectiveCourseAllocation extends Model
{
    use HasFactory;
    protected $fillable = [
        'semester_id',
        'section_id',
        'scheme_detail_id',
        'course_id',
        'teacher_id',

    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
    public function scheme_detail()
    {
        return $this->belongsTo(SchemeDetail::class);
    }
}
