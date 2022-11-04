<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'semester_id',
        'scheme_detail_id',
        'split_course_id',
        'is_reapper',
        'assignment',
        'presentation',
        'midterm',
        'summative',
        'teacher_id',
        'internal_id',
        'hod_id',
        'forwarded_at',
        'kpo_id',
        'controller_id',
        'approved_at',

    ];
}
