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
        'semester_no',  //intake semester no
        'first_semester_id',
        'last_semester_id',
        'status',       //0, finished
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
        $semester_no = session('semester_id') - $this->first_semester_id + $this->semester_no;
        $roman = config('global.romans');
        return $semester . " / " . $program . " / " . $shift . " / " . $roman[$semester_no - 1];
    }

    public function old_short()
    {
        $semester = $this->semester->short();
        $roman = config('global.romans');
        $shift = $this->shift->short;
        $semester_no = session('semester_id') - $this->first_semester_id + $this->semester_no;
        return $semester . " / " . $shift . " / " . $roman[$semester_no - 1];
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
        return $semester_id - $this->first_semester_id + $this->semester_no;
    }
    public function semesters()
    {
        return Semester::whereBetween('id', [$this->first_semester_id, $this->last_semester_id]);
    }
}
