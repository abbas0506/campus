<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FirstAttempt extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'semester_id',
        'course_allocation_id',
        'assignment',
        'presentation',
        'midterm',
        'summative',
        'is_active',

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

    public function status()
    {
        if ($this->formative() > 24 && $this->summative > 24)
            return "Pass";
        else
            return "Fail";
    }
    public function obtained()
    {
        if ($this->status() == 'Pass')
            return $this->assignment + $this->presentation + $this->midterm + $this->summative;
        else return 0;
    }
    public function total()
    {
        //if pass, then return total else zero
        if ($this->status() == 'Pass')
            return $this->assignment + $this->presentation + $this->midterm + $this->summative;
        else return 0;
    }

    public function cr()
    {
    }
    public function gpa()
    {
        $marks = $this->total();
        $gp = 0;
        //for MS/Mphil education
        if ($this->student->section->clas->program->level == 18) {
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
        if ($this->student->section->clas->program->level == 18) {
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
                if ($reappear->total() > $best->total())
                    $best = $reappear;
            }
        }
        return $best;
    }
    public function attempt_stars()
    {
        //if passed, return starts equal to successful attempt
        $best = $this;
        $attempt_no = 0;
        $stars = '';
        if ($this->reappears->count() > 0) {
            foreach ($this->reappears as $reappear) {
                $attempt_no++;
                if ($reappear->total() > $best->total())
                    $best = $reappear;
            }
            if ($best->total() >= 50) {
                for ($i = 1; $i <= $attempt_no; $i++) {
                    $stars .= '*';
                }
            }
        }
        return $stars;
    }

    public function scopeDuring($query, $semester_id)
    {
        return $query->where('semester_id', $semester_id);
    }
    public function scopeTill($query, $semester_id)
    {
        return $query->where('semester_id', '<=', $semester_id);
    }
    public function scopeBy($query, $student_id)
    {
        return $query->where('student_id', '<=', $student_id);
    }
    public function scopeSlot($query, $slot_no)
    {
        return $query->whereRelation('course_allocation.slot_option.slot', 'slot_no', $slot_no);
    }
    public function scopePassed($query)
    {
        return $query->whereRaw('assignment+presentation+midterm+summative>=50');
    }
    public function scopeFailed($query)
    {
        return $query->whereRaw('assignment+presentation+midterm+summative<50');
    }
    public function scopeCourse($query, $course_id)
    {
        return $query->whereRelation('course_allocation.course', 'id', $course_id);
    }
}
