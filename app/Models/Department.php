<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'title', //degree title

    ];
    public function programs()
    {
        return $this->hasMany(Program::class);
    }
    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    public function headship()
    {
        return $this->hasOne(Headship::class);
    }
    public function teachers()
    {
        return User::whereRelation('roles', 'name', 'teacher')->where('department_id', $this->id)->get();
    }

    public function clases()
    {
        return Clas::whereRelation('program', 'department_id', $this->id)->get();
    }

    public function sections()
    {
        return Section::whereRelation('clas.program', 'department_id', $this->id)->get();
    }
    public function students()
    {
        return Student::whereRelation('section.clas.program', 'department_id', $this->id)->get();
    }
}
