<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Scheme extends Model
{
    use HasFactory;
    protected $fillable = [
        'program_id',
        'wef_semester_id',
    ];

    public function program()
    {
        return $this->belongsTo(Program::class);
    }
    public function clases()
    {
        return $this->hasMany(Clas::class);
    }
    public function slots()
    {
        return $this->hasMany(Slot::class);
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class, 'wef_semester_id');
    }
    public function title()
    {
        return $this->program->short . ' / ' . $this->semester->title();
    }
    public function subtitle()
    {
        return $this->semester->short();
    }

    public function creditHrsMax()
    {
        return $this->program->cr;
    }
    public function semester_nos()
    {
        $collection = collect();
        for ($i = $this->program->intake; $i < $this->program->intake + $this->program->min_t * 2; $i++) {
            $collection->add($i);
        }
        return $collection;
    }
    public function has_allocation()
    {
        return CourseAllocation::whereRelation('slot_option.slot', 'scheme_id', $this->id)->count();
    }
}
