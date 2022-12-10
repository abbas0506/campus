<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FirstAttempt extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'program_id',
        'course_id',
        'semester_no',
        'semester_id',

        'assignment',
        'presentation',
        'midterm',
        'summative',

        'course_allocation_id', //2 year old course allocations will be purged
        // 'internal_id',
        // 'hod_id',
        // 'forwarded_at',
        // 'kpo_id',
        // 'controller_id',
        // 'approved_at',  //make it blank to allow editing

    ];
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
    public function program()
    {
        return $this->belongsTo(Program::class);
    }
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }
    public function course_allocation()
    {
        return $this->belongsTo(CourseAllocation::class);
    }
    public function reappears()
    {
        return $this->hasMany(Reappear::class);
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
    public function failed()
    {
        if ($this->formative() < 17)
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

    public function credit_hrs()
    {
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
    public function last_gpa()
    {
        if ($this->reappears->count() > 0) {
            $last = $this->reappears->last();
            return $last->gpa();
        } else
            return $this->gpa();
    }

    public function best_attempt()
    {
        $best = $this;
        if ($this->reappears->count() > 0) {
            foreach ($this->reappears as $reappear) {
                if ($reappear->summative() > $best->summative())
                    $best = $reappear;
            }
        }
        return $best;
    }
}
