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
    public function formative()
    {
        return $this->assignment + $this->presentation + $this->midterm;
    }
    public function summative()
    {
        return $this->assignment + $this->presentation + $this->midterm + $this->summative;
    }

    public function has_passed()
    {
        if ($this->formative() > 16 && $this->summative() > 49)
            return true;
        else
            return false;
    }
    public function status()
    {
        if ($this->has_passed())
            return "Pass";
        else
            return "Fail";
    }
    public function gpa()
    {
        $marks = $this->summative();
        $gp = 0;
        if ($marks > 90) $gp = 4;
        elseif ($marks > 50) $gp = ($marks - 10) * 0.05;
        return $gp;
    }
    public function grade()
    {
        $gp = $this->gpa();
        $grade = '';
        if ($gp == 4) $grade = 'A+';
        elseif ($gp >= 3.5 && $gp <= 3.99) $grade = 'A';
        elseif ($gp >= 3 && $gp <= 3.49) $grade = 'B';
        elseif ($gp >= 2.5 && $gp <= 2.99) $grade = 'C';
        elseif ($gp >= 2 && $gp <= 2.49) $grade = 'D';
        else $grade = 'F';
        return $grade;
    }
}
