<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    protected $fillable = [
        'sender_id',
        'sender_role',
        'receiver_id',
        'receiver_role',
        'message',
        'is_read',
    ];
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
    public function  scopeUnread($query)
    {
        return $query->where('is_read', 0);
    }
    public function  scopeRead($query)
    {
        return $query->where('is_read', 1);
    }
}
