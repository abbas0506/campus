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
        'course_id',    //optional course id
        'scheme_detail_id',
        'teacher_id',
        'semester_id',

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
    // public function user()
    // {
    //     return $this->belongsTo(User::class);
    // }
    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }
    public function results()
    {
        return $this->hasMany(Result::class);
    }
    public function registrations()
    {
        return $this->hasMany(Result::class); //returns registrations
    }
}
