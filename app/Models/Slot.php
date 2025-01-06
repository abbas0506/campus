<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slot extends Model
{
    use HasFactory;
    protected $fillable = [
        'scheme_id',
        'semester_no',
        'slot_no',
        'cr',
    ];
    public function scheme()
    {
        return $this->belongsTo(Scheme::class);
    }
    public  function slot_options()
    {
        return $this->hasMany(SlotOption::class);
    }
    public  function course_allocations()
    {
        return CourseAllocation::whereRelation('slot_option', 'slot_id', $this->id)->get();
        // return $this->hasMany(CourseAllocation::class);
    }
    public function scopeFor($query, $semester_no)
    {
        return $query->where('semester_no', $semester_no);
    }
    public function lblCrsType()
    {
        $lbl = '';
        $count = $this->slot_options->count();
        foreach ($this->slot_options as $slot_option) {
            $lbl .= $slot_option->course_type->name;
            $count--;
            if ($count > 0) {
                $lbl .= " / ";
            }
        }
        return $lbl;
    }
    public function scopeTill($query, $semester_no)
    {
        return $query->where('semester_no', '<=', $semester_no);
    }
}
