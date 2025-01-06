<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    use HasFactory;
    protected $fillable = [
        'semester_type_id',
        'year',
        'status',
    ];
    public function semester_type()
    {
        return $this->belongsTo(SemesterType::class);
    }
    public function course_allocations()
    {
        return $this->hasMany(CourseAllocation::class);
    }
    public function title()
    {
        return $this->semester_type->name . ' ' . $this->year - 2000;
    }
    public function short()
    {
        return $this->semester_type->short . '' . $this->year - 2000;
    }
    public function scopeTill($query, $semester_id)
    {
        return $query->where('id', '<=', session('semester_id'));
    }
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}
