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

        //root status
        'root_semester_id',
        'program_id',
        'shift',

        //current status
        'section_id',
        'current_semester_id',
        'semester_no',
        'rollno',

    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function root_semester()
    {
        return $this->belongsTo(Semester::class, 'root_semester_id');
    }
    public function current_semester()
    {
        return $this->belongsTo(Semester::class, 'current_semester_id');
    }
    public function program()
    {
        return $this->belongsTo(Program::class);
    }
    public function section()
    {
        return $this->belongsTo(Section::class);
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
