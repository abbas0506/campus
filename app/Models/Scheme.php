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
    public function clases()
    {
        return $this->hasMany(Clas::class);
    }
    public function scheme_metas()
    {
        return $this->hasMany(SchemeMeta::class);
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
    public function subtitle()
    {
        return $this->semester->short();
    }

    public function courses($no)
    {
        return $this->scheme_details->where('semester_no', $no);
    }

    public function creditHrs($no)
    {
        //sum of all credits that have been defined during semester
        $sum = $this->courses($no)->sum(function ($scheme_detail) {
            return $scheme_detail->course->creditHrs();
        });
        return $sum;
    }
    public function creditHrsMax()
    {
        return $this->program->credit_hrs;
    }
    public function creditHrsDefined()
    {
        $sum = $this->scheme_details->sum(function ($scheme_detail) {
            return $scheme_detail->course->creditHrs();
        });
        return $sum;
    }
}
