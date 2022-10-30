<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'semester_id', //root semester id
        'program_id',
        'shift_id',
        'semester_no',  //will be dynamic

    ];

    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }
    public function program()
    {
        return $this->belongsTo(Program::class);
    }
    public function shift()
    {
        return $this->belongsTo(Shift::class);
    }

    public function similar($program_id, $shift_id)
    {
        return $program_id . "+" . $shift_id;
    }
    public  function students()
    {
        return $this->hasMany(Student::class);
    }
    public function title()
    {
        $semester = $this->semester->title();
        $program = $this->program->short;
        $shift = $this->shift->name;
        $roman = config('global.romans');
        return $semester . ' / ' . $program . ' / ' . $shift .  ' / Semester - ' . $roman[$this->semester_no - 1] . ' / Section -  ' . $this->name;
    }
}
