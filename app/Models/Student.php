<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'father',
        'cnic',
        'phone',
        'email',
        'address',
        'dob',
        'gender',

        //root status
        'section_id',
        'regno',

        //current section: if frozen 

        'rollno',

    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }
    public function clas()
    {
        return $this->section->clas;
    }
    public function program()
    {
        return $this->section->clas->program;
    }
}
