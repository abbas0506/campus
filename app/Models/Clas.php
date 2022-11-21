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
        'semester_id',  //root semester
        'scheme_id',
        'semester_no',  //will be dynamic
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
        return $this->belongsTo(Semester::class);
    }
    public function scheme()
    {
        return $this->belongsTo(Scheme::class);
    }

    public  function students()
    {
        return $this->hasMany(Student::class);
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
        $semester = $this->semester->title();
        $program = $this->program->short;
        $shift = $this->shift->name;
        $roman = config('global.romans');
        return $program . ' / ' . $shift . ' / ' . $semester . ' / ' .   'Semester - ' . $roman[$this->semester_no - 1];
    }
}
