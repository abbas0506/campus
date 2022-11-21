<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Scheme extends Model
{
    use HasFactory;
    protected $fillable = [
        'program_id',
        'wef_semester_id',
    ];

    public function program()
    {
        return $this->belongsTo(Program::class);
    }
    public function semester()
    {
        return $this->belongsTo(Semester::class, 'wef_semester_id');
    }
    public  function scheme_details()
    {
        return $this->hasMany(SchemeDetail::class);
    }
    public function title()
    {
        return $this->program->short . ' / ' . $this->semester->title();
    }
}
