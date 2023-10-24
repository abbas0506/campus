<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'father',
        'cnic',
        'phone',
        'email',
        'password',
        'address',
        'dob',
        'gender',
        'image',

        //root status
        'section_id',
        'regno',
        'rollno',

        //current
        'status_id',
        // 'section_id',

    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function status()
    {
        return $this->belongsTo(Status::class);
    }
    public function scopeGender($query, $gender)
    {
        return $query->where('gender', $gender);
    }

    public function session()
    {
        $semester = $this->section->clas->semester->semester_type->name;
        $start = $this->section->clas->semester->year;
        $end = $start + $this->section->clas->program->min_t;
        return  $start . "-" . $end - 2000 . " (" . $semester . ")";
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function program()
    {
        return $this->section->program;
    }
    public function first_attempts()
    {
        return $this->hasMany(FirstAttempt::class);
    }
    public function credits_covered()
    {
        $sum = $this->first_attempts()->till(session('semester_id'))->get()->sum(function ($attempt) {
            return $attempt->course_allocation->course->cr();
        });
        return $sum;
    }
    public function sum_of_obtained()
    {
        //exclude the marks of subjects that have been failed
        $sum = $this->first_attempts->sum(function ($attempt) {
            $bestscore = $attempt->best_attempt()->total();
            if ($bestscore < 50) return 0;
            else return $bestscore;
        });
        return $sum;
    }
    public function total_marks_covered()
    {
        $sum = $this->first_attempts->sum(function ($attempt) {
            return $attempt->course_allocation->course->marks();
        });
        return $sum;
    }
    public function overall_percentage()
    {
        if ($this->total_marks_covered() == 0) return '-';
        else return round($this->sum_of_obtained() / $this->total_marks_covered() * 100, 2);
    }
    public function cgpa()
    {
        $sum = $this->first_attempts->sum(function ($attempt) {
            return $attempt->course_allocation->course->cr() * $attempt->best_attempt()->gpa();
        });
        if ($this->credits_covered() == 0) $cgpa = 0;
        else $cgpa = round($sum / $this->credits_covered(), 2);
        return $cgpa;
    }

    //promotion according to hec rules
    public function promotion_status()
    {
        $status = '';
        $required_cgpa = 2.0;
        if ($this->section->clas->semesterNo(session('semester_id')) == 1) $required_cgpa = 1.7;
        else if ($this->section->clas->semesterNo(session('semester_id')) == 2) $required_cgpa = 1.8;

        if ($this->cgpa() >= $required_cgpa) $status = 'Promoted';
        else $status = 'Ceased';
        return $status;
    }

    //overall failing courses
    public function failed_courses()
    {
        $subjects = '';
        $failed = false;
        foreach ($this->first_attempts as $attempt) {
            if ($attempt->total() < 50) {
                $failed = true;
                //now check re-attempts, skip if passed
                foreach ($attempt->reappears as $reappear) {
                    if ($reappear->total() >= 50) {
                        $failed = false;
                        break;
                    }
                }
                //if has never passed, add to overall failing subjects list
                if ($failed) {
                    if ($subjects == '')
                        $subjects = $subjects . $attempt->course_allocation->course->code;
                    else
                        $subjects = $subjects . ', ' . $attempt->course_allocation->course->code;
                }
            }
        }
        return $subjects;
    }
    public function scopeActive($query)
    {
        return $query->where('status_id', 1);
    }
    public function scopeFrozen($query)
    {
        return $query->where('status_id', 2);
    }
    public function scopeStruckoff($query)
    {
        return $query->where('status_id', 3);
    }
}
