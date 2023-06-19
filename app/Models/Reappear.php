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
    public function total()
    {
        if ($this->status() == 'Pass')
            return $this->assignment + $this->presentation + $this->midterm + $this->summative;
        else
            return 0;
    }

    public function status()
    {
        if ($this->formative() > 24 && $this->summative > 24)
            return "Pass";
        else
            return "Fail";
    }
    public function gpa()
    {
        $marks = $this->total();
        $gp = 0;
        //for MS/Mphil education
        if ($this->first_attempt->program->level == 18) {
            if ($marks >= 85) $gp = 4;
            elseif ($marks >= 80) $gp = 3.66;
            elseif ($marks >= 75)  $gp = 3.33;
            elseif ($marks >= 71)  $gp = 3;
            elseif ($marks >= 68)  $gp = 2.66;
            elseif ($marks >= 64)  $gp = 2.33;
            elseif ($marks >= 61)  $gp = 2;
            elseif ($marks >= 58)  $gp = 1.66;
            elseif ($marks >= 54)  $gp = 1.33;
            elseif ($marks >= 50)  $gp = 1;
        } else { //for BS or PhD
            if ($marks >= 90) $gp = 4;
            elseif ($marks >= 50) $gp = ($marks - 10) * 0.05;
        }
        return $gp;
    }
    public function grade()
    {
        $gp = $this->gpa();
        $grade = '';
        // for MS/Mphil
        if ($this->first_attempt->program->level == 18) {
            if ($gp == 4) $grade = 'A';
            elseif ($gp == 3.66) $grade = 'A-';
            elseif ($gp == 3.33) $grade = 'B+';
            elseif ($gp == 3) $grade = 'B';
            elseif ($gp == 2.66) $grade = 'B-';
            elseif ($gp == 2.33) $grade = 'C+';
            elseif ($gp == 2) $grade = 'C';
            elseif ($gp == 1.66) $grade = 'C-';
            elseif ($gp == 1.33) $grade = 'D+';
            elseif ($gp == 1) $grade = 'D';
            else $grade = 'F';
        } else {    // for BS or PhD
            if ($gp == 4) $grade = 'A+';
            elseif ($gp >= 3.5 && $gp <= 3.99) $grade = 'A';
            elseif ($gp >= 3 && $gp <= 3.49) $grade = 'B';
            elseif ($gp >= 2.5 && $gp <= 2.99) $grade = 'C';
            elseif ($gp >= 2 && $gp <= 2.49) $grade = 'D';
            else $grade = 'F';
        }
        return $grade;
    }
}
