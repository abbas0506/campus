<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'course_allocation_id',
        'is_reappear',
        'assignment',
        'presentation',
        'midterm',
        'summative',
        'internal_id',
        'hod_id',
        'forwarded_at',
        'kpo_id',
        'controller_id',
        'approved_at',

    ];
    public  function student()
    {
        return $this->belongsTo(Student::class);
    }
    public  function course_allocation()
    {
        return $this->belongsTo(CourseAllocation::class);
    }

    public function obtained()
    {
        return $this->assignment + $this->presentation + $this->midterm + $this->summative;
    }
    public function gradePoint()
    {
        $marks = $this->obtained();
        $gradepoint = 0;
        if ($marks > 90) $gradepoint = 4;
        elseif ($marks > 50) $gradepoint = ($marks - 10) * 0.05;
        return $gradepoint;
    }
    public function gradeLetter()
    {
        $gp = $this->gradePoint();
        $letter = '';
        if ($gp == 4) $letter = 'A+';
        elseif ($gp >= 3.5 && $gp <= 3.99) $letter = 'A';
        elseif ($gp >= 3 && $gp <= 3.49) $letter = 'B';
        elseif ($gp >= 2.5 && $gp <= 2.99) $letter = 'C';
        elseif ($gp >= 2 && $gp <= 2.49) $letter = 'D';
        else $letter = 'F';
        return $letter;
    }
    public function creditHrs()
    {
        return $this->course_allocation->course->credit_hrs_theory + $this->course_allocation->course->credit_hrs_practical;
    }
}
