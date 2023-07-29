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
    public function scopeFor($query, $semester_no)
    {
        return $query->where('semester_no', $semester_no);
    }
}
