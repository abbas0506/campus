<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hod extends Model
{
    use HasFactory;
    protected $fillables = [
        'department_id',
        'employee_id',

    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
    public function departments()
    {
        return $this->belongsToMany(Department::class);
    }
}
