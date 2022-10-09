<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clas extends Model
{
    use HasFactory;
    protected $fillable = [
        'program_id',
        'semester_id', //root semester id
        'semester_no',
        'shift',
    ];

    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }
    public function program()
    {
        return $this->belongsTo(Program::class);
    }
    public function sections()
    {
        return $this->hasMany(Section::class);
    }
}
