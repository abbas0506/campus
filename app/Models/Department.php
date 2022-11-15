<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'title', //degree title

    ];
    public function hod()
    {
        return $this->hasOne(Hod::class);
    }
    public function headship()
    {
        return $this->hasOne(Headship::class);
    }
    public function teachers()
    {
        return $this->hasMany(Teacher::class);
    }
    public function courses()
    {
        return $this->hasMany(Course::class);
    }
}
