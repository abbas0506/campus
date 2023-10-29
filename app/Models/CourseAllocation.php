<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseAllocation extends Model
{
    use HasFactory;
    protected $fillable = [
        'section_id',
        'slot_option_id',
        'course_id',    //optional course id
        'teacher_id',
        'semester_id',

        'lecture_no',
        'room_no',
        'starts_at',
        'ends_at',

        'submitted_at',
        'verfied_at',
        'internal_id',  //verified by
        'hod_id',       //forwarded by

    ];

    public function section()
    {
        return $this->belongsTo(Section::class);
    }
    public function slot_option()
    {
        return $this->belongsTo(SlotOption::class);
    }
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }
    public function semester()
    {
        return $this->belongsTo(Course::class);
    }
    public function internal()
    {
        return $this->section->clas->program->internal;
    }
    public function hod()
    {
        return $this->section->clas->program->department->headship->user;
    }

    public function first_attempts()
    {
        return $this->hasMany(FirstAttempt::class);
    }
    public function reappears()
    {
        return $this->hasMany(Reappear::class);
    }
    public function strength()
    {
        return $this->first_attempts->count() + $this->reappears->count();
    }
    public function enrolled_students()
    {
        return Student::whereRelation('first_attempts.student', 'course_allocation_id', $this->id)->get();
    }
    public function first_attempts_sorted()
    {
        return FirstAttempt::with('student')->where('course_allocation_id', $this->id)->get()->sortBy('student.rollno');
    }
    public function reappears_sorted()
    {
        return Reappear::with('first_attempt')->where('course_allocation_id', $this->id)->get()->sortBy('first_attempt.student.rollno');
    }

    public function scopeSumOfCreditHrs($query, $id)
    {
        return $query->where('semester_id', $id)->get()->sum(function ($allocation) {
            return $allocation->course->creditHrs();
        });
    }
    public function scopeDuring($query, $semester_id)
    {
        return $query->where('semester_id', $semester_id);
    }
    public function scopeFor($query, $semester_id)
    {
        return $query->where('semester_id', $semester_id);
    }
    public function scopeTill($query, $semester_id)
    {
        return $query->where('semester_id', '<=', $semester_id);
    }
    public function scopeBefore($query, $semester_id)
    {
        return $query->where('semester_id', '<', $semester_id);
    }
    public function scopeOn($query, $slot_id)
    {
        $slot_option_ids = SlotOption::where('slot_id', $slot_id)->pluck('id')->toArray();
        return $query->whereIn('slot_option_id', $slot_option_ids);
    }
    // find already allocated course by id
    public function scopeContains($query, $course_id)
    {
        return $query->where('course_id', $course_id)->count() > 0 ? true : false;;
    }
    public function scopeAllocatedCr($query)
    {
        // w.r.t slot credits
        $slot_ids = $query->pluck('slot_id')->toArray();
        return Slot::whereIn('id', array_unique($slot_ids))->sum('cr');
    }
    public function scopeSumOfCr($query)
    {
        return $query->get()->sum(function ($allocation) {
            return $allocation->slot_option->slot->cr;
        });
    }

    public function status()
    {

        if ($this->approved_at) return "Approved";
        else if ($this->verified_at) return "Verified";
        else if ($this->submitted_at) return "Submitted";
        else return "Pending";
    }

    public function scopeCurrent($query)
    {
        return $query->where('semester_id', session('semester_id'));
    }
    public function scopeAssigned($query)
    {
        return $query->whereNotNull('course_id')->whereNotNull('teacher_id');
    }
    public function scopeSubmitted($query)
    {
        return $query->whereNotNull('submitted_at');
    }
    public function scopePending($query)
    {
        return $query->whereNull('submitted_at');
    }
    public function scopeShift($query, $shift)
    {
        return $query->whereRelation('section.clas', 'shift_id', $shift);
    }
}
