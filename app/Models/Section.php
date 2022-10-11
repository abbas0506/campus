<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'clas_id'
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
        $program = $this->clas->program->name;
        $shift = $this->clas->shift->name;
        return $semester . ' | ' . $program . ' | ' . $shift .  ' | Semester -  ' . $this->clas->semester_no . ' | Section -  ' . $this->name;
    }
}
