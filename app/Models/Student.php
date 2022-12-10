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
        $sum = $this->first_attempts->sum(function ($attempt) {
            return $attempt->best_attempt()->summative();
        });
        return $sum;
    }
    public function overall_total_marks()
    {
        return $this->first_attempts->count() * 100;
    }
    public function overall_percentage()
    {
        return round($this->overall_obtained() / $this->overall_total_marks() * 100, 0);
    }
    public function cgpa()
    {
        $sum = $this->first_attempts->sum(function ($attempt) {
            return $attempt->course->creditHrs() * $attempt->best_attempt()->gpa();
        });
        $cgpa = round($sum / $this->credits_attempted(), 2);
        return $cgpa;
    }
}
