<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'prefix_id',
        'father',
        'phone',
        'cnic',
        'address',
        'pic',
        'dob',
        'gender',
        'blood_group',
        'is_married',
        'is_special',
        'nationality_id',
        'province_id',
        'domicile_id',
        'religion_id',
        'department_id',
        'faculty_id', //teaching, non-teaching
        'jobtype_id',
        'specialization_id',
        'designation_id',
        'qualification_id',
        'salaray',

    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function designation()
    {
        return $this->belongsTo(Designation::class);
    }
    public function department()
    {
        return $this->belongsTo(Department::class);
    }
    public function course_allocations()
    {
        return $this->hasMany(CourseAllocation::class)->where('semester_id', session('semester_id'));
    }
}
