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
        'internal_id',  //any teacher working as internal examiner
    ];
    public function department()
    {
        return $this->belongsTo(Department::class);
    }
    public function internal()
    {
        return $this->belongsTo(User::class);
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
            ->where('shift_id', 1);
    }

    public function selfsupport_clases()
    {
        return $this->hasMany(Clas::class)
            ->where('shift_id', 2);
        // ->where('status', 1); //currently active;
    }

    public function sections()
    {
        return $this->hasMany(Section::class);
    }
    public function students()
    {
        return $this->hasMany(Student::class);
    }
    public function semester_nos()
    {
        $series = collect();
        for ($i = 1; $i <= $this->min_duration * 2; $i++) {
            $series->add($i);
        }
        return $series;
    }
    public function promotable_clases()
    {
        return $this->hasMany(Clas::class)
            ->where('semester_no', '<=', $this->min_duration * 2)
            ->orderBy('shift_id')
            ->orderBy('semester_no'); //currently active;
    }
    public function revertible_clases()
    {
        return $this->hasMany(Clas::class)
            ->whereBetween('semester_no', [2, $this->min_duration * 2 + 1])
            ->orderBy('shift_id')
            ->orderBy('semester_no'); //currently active;
    }
}
