<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FriendRequest extends Model
{
    use HasFactory;

    protected $fillable = ['sender_email', 'receiver_email', 'status'];

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_email', 'sender_email');
    }

    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'receiver_email', 'receiver_email');
    }

}
