<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TwoFa extends Model
{
    use HasFactory;
    public $table = "two_fas";
    protected $fillable = [
        'user_id',
        'code',
    ];
}
