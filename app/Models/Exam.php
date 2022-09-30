<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;
    protected $fillable = [
        'semester_id',
        'exam_type_id',
        'edit_till',
    ];

    public function exam_type()
    {
        return $this->belongsTo(ExamType::class, 'exam_type_id');
    }
    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }
}
