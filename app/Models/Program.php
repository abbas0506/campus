<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'short',
        'code',
        'min_duration',
        'max_duration',
        'department_id',
    ];
    public function department()
    {
        return $this->belongsTo(Department::class);
    }
    public function schemes()
    {
        return $this->hasMany(Scheme::class);
    }
    public function sections()
    {
        return $this->hasMany(Section::class);
    }
    public function students()
    {
        return $this->hasMany(Student::class);
    }
}
