<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'father',
        'cnic',
        'phone',
        'address',
        'dob',
        'gender',
        'blood_group',
        'is_married',
        'is_special',
        'nationality_id',
        'province_id',
        'domicile_id',
        'religion_id',
        'semester_id',  //started on
        'program_id',
        'shift',
        //current attributes
        'section_id',
        'semester_no',
        'rollno',

    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function program()
    {
        return $this->belongsTo(Program::class);
    }
    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }
    public function semester_type()
    {
        return $this->belongsTo(SemesterType::class);
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
}
