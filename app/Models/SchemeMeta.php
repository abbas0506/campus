<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchemeMeta extends Model
{
    use HasFactory;
    protected $fillable = [
        'scheme_id',
        'semester_no',
        'slot',
        'course_type_id',
        'cr',
    ];

    public function scheme()
    {
        return $this->belongsTo(Scheme::class);
    }
    public function course_type()
    {
        return $this->belongsTo(CourseType::class);
    }
    public function isEmpty()
    {
        $scheme_details_count = SchemeDetail::where('scheme_id', $this->scheme_id)
            ->where('semester_no', $this->semester_no)
            ->where('slot', $this->slot)
            ->count();
        if ($scheme_details_count == 0) return true;
        else return false;
    }
    public function scopeFor($query, $semester_no)
    {
        return $query->where('semester_no', $semester_no);
    }
    public function sumOfCr($query)
    {
        return $query->sum('cr');
    }
    public function maxSlot($query)
    {
        return $query->max('slot');
    }
    public function minSlot($query)
    {
        return $query->min('slot');
    }
}
