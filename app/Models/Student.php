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
        'address',
        'dob',
        'gender',

        //root status
        'section_id',
        'regno',
        'rollno',

        //current
        'status',
        'section_id',

    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function session()
    {
        $semester = $this->section->clas->semester->semester_type->name;
        $start = $this->section->clas->semester->year;
        $end = $start + $this->section->clas->program->min_duration;
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
    public function credits_attempted()
    {
        $sum = $this->first_attempts->sum(function ($attempt) {
            return $attempt->course->creditHrs();
        });
        return $sum;
    }
    public function overall_obtained()
    {
        //exclude the marks of subjects that have been failed
        $sum = $this->first_attempts->sum(function ($attempt) {
            $bestscore = $attempt->best_attempt()->total();
            if ($bestscore < 50) return 0;
            else return $bestscore;
        });
        return $sum;
    }
    public function overall_total_marks()
    {
        $sum = $this->first_attempts->sum(function ($attempt) {
            return $attempt->course->marks();
        });
        return $sum;
    }
    public function overall_percentage()
    {
        if ($this->overall_total_marks() == 0) return '-';
        else return round($this->overall_obtained() / $this->overall_total_marks() * 100, 0);
    }
    public function cgpa()
    {
        $sum = $this->first_attempts->sum(function ($attempt) {
            return $attempt->course->creditHrs() * $attempt->best_attempt()->gpa();
        });
        if ($this->credits_attempted() == 0) $cgpa = 0;
        else $cgpa = round($sum / $this->credits_attempted(), 2);
        return $cgpa;
    }

    //promotion according to hec rules
    public function promotion_status()
    {
        $status = '';
        $required_cgpa = 2.0;
        if ($this->semester_no == 1) $required_cgpa = 1.7;
        else if ($this->semester_no == 2) $required_cgpa = 1.8;

        if ($this->cgpa() >= $required_cgpa) $status = 'Promoted';
        else $status = 'Ceased';
        return $status;
    }

    //overall failing subjects
    public function failed_subjects()
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
                        $subjects = $subjects . $attempt->course->short;
                    else
                        $subjects = $subjects . ', ' . $attempt->course->short;
                }
            }
        }
        return $subjects;
    }
}
