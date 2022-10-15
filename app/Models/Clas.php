<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clas extends Model
{
    use HasFactory;
    protected $fillable = [
        'program_id',
        'semester_id', //root semester id
        'semester_no',
        'shift_id',
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
    public function sections()
    {
        return $this->hasMany(Section::class);
    }
    public function title()
    {
        $semester = $this->semester->title();
        $program = $this->program->short;
        $shift = $this->shift->name;
        return $semester . ' | ' . $program . ' | ' . $shift;
    }
}
