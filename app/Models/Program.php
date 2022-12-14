<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'short',
        'credit_hrs',   //total credits to pass
        'min_duration',
        'max_duration',
        'department_id',
    ];
    public function department()
    {
        return $this->belongsTo(Department::class);
    }
    public function schemes()
    {
        return $this->hasMany(Scheme::class);
    }
    public function clases()
    {
        return $this->hasMany(Clas::class);
    }
    public function morning_clases()
    {
        return $this->hasMany(Clas::class)
            ->where('shift_id', 1)
            ->where('semester_id', session('semester_id'))
            ->where('status', 1); //currently active
    }

    public function selfsupport_clases()
    {
        return $this->hasMany(Clas::class)
            ->where('shift_id', 2)
            ->where('semester_id', session('semester_id'))
            ->where('status', 1); //currently active;
    }

    public function sections()
    {
        return $this->hasMany(Section::class);
    }
    public function students()
    {
        return $this->hasMany(Student::class);
    }
    public function series_of_all_semesters()
    {
        $series = collect();
        for ($i = 1; $i <= $this->min_duration * 2; $i++) {
            $series->add($i);
        }
        return $series;
    }
}
