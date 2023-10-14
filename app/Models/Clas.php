<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clas extends Model
{
    use HasFactory;
    protected $fillable = [
        'program_id',
        'shift_id',
        'scheme_id',
        'first_semester_id',
        'last_semester_id', //calculated from program duration, to maintain status of class
    ];

    public function program()
    {
        return $this->belongsTo(Program::class);
    }
    public function shift()
    {
        return $this->belongsTo(Shift::class);
    }
    public function semester()
    {
        return $this->belongsTo(Semester::class, 'first_semester_id', 'id');
    }
    public function session()
    {
        $start = $this->semester->year - 2000;
        $end = $start + $this->program->min_t;
        return $this->semester->semester_type->name . ' ' . $start . '-' . $end;
    }
    public function scheme()
    {
        return $this->belongsTo(Scheme::class);
    }

    public  function sections()
    {
        return $this->hasMany(Section::class);
    }

    public function lastSection()
    {
        return $this->sections->last();
    }
    public function title()
    {
        $semester = $this->semester->short();
        $program = $this->program->short;
        $shift = $this->shift->short;
        $semester_no = session('semester_id') - $this->first_semester_id + $this->program->intake;
        $roman = config('global.romans');
        return $semester . " / " . $program . " / " . $shift . " / " . $roman[$semester_no - 1];
    }

    public function short()
    {
        $semester = $this->semester->short();
        $program = $this->program->short;
        $shift = $this->shift->short;
        $roman = config('global.romans');
        return $semester . " / " . $program . " / " . $shift;
    }

    public function strength()
    {
        return $this->sections->sum(function ($query) {
            return $query->students->count();
        });
    }
    public function course_allocations()
    {
        return CourseAllocation::whereRelation('section', 'clas_id', $this->id);
    }
    public function students()
    {
        return Student::whereRelation('section', 'clas_id', $this->id);
    }

    public function scopeTill($query, $semester_id)
    {
        return $query->where('last_semester_id', '<=', $semester_id);
    }
    public function scopeActive($query)
    {
        $semester_id = session('semester_id');
        return $query->where('first_semester_id', '<=', $semester_id)
            ->where('last_semester_id', '>=', $semester_id)->orderBy('first_semester_id');
    }
    public function semesterNo($semester_id)
    {
        // current semester gap + initial offset i.e intake semester
        return $semester_id - $this->first_semester_id + $this->program->intake;
    }
    public function semesters()
    {
        return Semester::whereBetween('id', [$this->first_semester_id, $this->last_semester_id]);
    }
    public function scopeValidForMove($query, $id)
    {
        $student = Student::find($id);
        //grace period in years
        $grace_period = $student->section->clas->program->max_t - $student->section->clas->program->min_t;
        return  $query->where('last_semester_id', '<=', $student->section->clas->last_semester_id + $grace_period * 2);
    }
    public function scopeFollowingScheme($query, $scheme_id)
    {
        return  $query->where('scheme_id', $scheme_id);
    }
}
