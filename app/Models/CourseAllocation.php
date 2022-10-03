<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseAllocation extends Model
{
    use HasFactory;
    protected $fillable = [
        'semester_id',
        'shift',
        'section_id',
        'scheme_detail_id',
        'examiner_id',

    ];
}
