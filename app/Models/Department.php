<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'title', //degree title
        'user_id',

    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function users()
    {
        // return $this->hasMany(Department::class);
        return $this->belongsToMany(User::class, 'user_departments');
    }
}
