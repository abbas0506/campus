<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchemeDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'scheme_id',
        'semester_no',
        'course_id',
    ];
}
