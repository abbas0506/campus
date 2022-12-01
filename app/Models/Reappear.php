<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reappear extends Model
{
    use HasFactory;
    protected $fillable = [
        'first_attempt_id',
        'semester_no',
        'semester_id',

        'assignment',
        'presentation',
        'midterm',
        'summative',

        'course_allocation_id', //2 year old course allocations will be purged

    ];
    public function first_attempt()
    {
        return $this->belongsTo(FirstAttempt::class);
    }
    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }
    public function course_allocation()
    {
        return $this->belongsTo(CourseAllocation::class);
    }
}
