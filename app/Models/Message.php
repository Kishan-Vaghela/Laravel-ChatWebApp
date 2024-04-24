<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;


    protected $fillable = ['sender_email','receiver_email','message'];

    public function sender()
    {
        return $this->belongsTo(FriendRequest::class, 'sender_email', 'sender_email');
    }

    public function receiver()
    {
        return $this->belongsTo(FriendRequest::class, 'receiver_email', 'receiver_email');
    }
}
