<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'exam_type_id',
        'is_active',
    ];

    public function exam_type()
    {
        return $this->belongsTo(ExamType::class, 'exam_type_id');
    }
}
