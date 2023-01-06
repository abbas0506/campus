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
        return  User::whereHas(
            'roles',
            function ($q) {
                $q->where('name', 'teacher');
            }
        )->where('department_id', $this->id);
    }

    public function clases()
    {
        return Clas::whereHas(
            'program',
            function ($q) {
                $q->where('department_id', $this->id);
            }
        );
    }
}
