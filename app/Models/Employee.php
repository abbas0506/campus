<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'father',
        'cnic',
        'phone',
        'dob',
        'gender',
        'blood_group',
        'is_married',
        'is_special',
        'nationality_id',
        'province_id',
        'domicile_id',
        'religion_id',
        'faculty_id', //teaching, non-teaching
        'job_type_id',
        'specialization_id',
        'designation_id',
        'qualification_id',
        'salaray',

    ];
}
