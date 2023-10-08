<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentStatus extends Model
{
    use HasFactory;
    protected $fillable = [
        'student_id',
        'status_id',
        'remarks',
    ];
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
    public  function status()
    {
        return $this->belongsTo(Status::class);
    }
}
