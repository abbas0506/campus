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
        'edit_till',    //allow edits till given date
    ];
    public function semester_type()
    {
        return $this->belongsTo(SemesterType::class);
    }
    public function classes()
    {
        return $this->hasMany(Clas::class);
    }
    public function title()
    {
        return $this->semester_type->name . ' ' . $this->year;
    }
}
