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
        'level',
        'cr',   //total credits to pass
        'min_t',
        'max_t',
        'intake', //intake semester no
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
    public function sections()
    {
        return Section::whereRelation('clas', 'program_id', $this->id)->get();
    }

    public function students()
    {
        return Student::whereRelation('section.clas', 'program_id', $this->id)->get();
    }
    public function semester_nos()
    {
        $series = collect();
        for ($i = $this->intake; $i <= $this->min_t * 2; $i++) {
            $series->add($i);
        }
        return $series;
    }
}
