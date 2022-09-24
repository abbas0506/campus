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

    ];
    public function hod()
    {
        return $this->hasOne(Hod::class);
    }
}
