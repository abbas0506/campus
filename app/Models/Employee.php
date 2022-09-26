<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
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
    public function department()
    {
        return $this->belongsTo(Department::class);
    }
    public function prefix()
    {
        return $this->belongsTo(Prefix::class);
    }
    public function gender()
    {
        return $this->belongsTo(Gender::class);
    }
    public function nationality()
    {
        return $this->belongsTo(Nationality::class);
    }
    public function province()
    {
        return $this->belongsTo(Province::class);
    }
    public function domicile()
    {
        return $this->belongsTo(Domicile::class);
    }
    public function religion()
    {
        return $this->belongsTo(Religion::class);
    }
    public function faculty()
    {
        return $this->belongsTo(Faculty::class);
    }
    public function jobtype()
    {
        return $this->belongsTo(Jobtype::class);
    }
    public function speicalization()
    {
        return $this->belongsTo(Specialization::class);
    }
    public function designation()
    {
        return $this->belongsTo(Designation::class);
    }
    public function qualification()
    {
        return $this->belongsTo(Qualification::class);
    }
}
