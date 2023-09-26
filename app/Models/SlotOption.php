<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SlotOption extends Model
{
    use HasFactory;
    protected $fillable = [
        'slot_id',
        'course_type_id',
        'course_id',
    ];
    public function slot()
    {
        return $this->belongsTo(Slot::class);
    }
    public function course_type()
    {
        return $this->belongsTo(CourseType::class);
    }
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
    public function availableCourses()
    {
        return $this->course_type->courses->where('department_id', session('department_id'));
    }
}
