<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'clas_id',
    ];


    public function clas()
    {
        return $this->belongsTo(Clas::class);
    }
    public  function students()
    {
        return $this->hasMany(Student::class);
    }
    public function title()
    {
        $semester = $this->clas->semester->title();
        $program = $this->clas->program->short;
        $shift = $this->clas->shift->name;
        $roman = config('global.romans');
        return $semester . ' / ' . $program . ' / ' . $shift .  ' / Semester - ' . $roman[$this->clas->semester_no - 1] . ' / Section -  ' . $this->name;
    }
}
