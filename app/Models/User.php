<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    /**
     * Check if the current user has sent any friend requests.
     *
     * @return bool
     */
    public function hasSentRequest()
    {
        return $this->sentFriendRequests()->exists();
    }

    /**
     * Define a relationship for sent friend requests.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sentFriendRequests()
    {
        return $this->hasMany(FriendRequest::class, 'receiver_email', 'email');
    }
    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_email', 'email');
    }

    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'receiver_email', 'email');
    }
    public function userinfo()
{
    return $this->hasOne(Userinfo::class, 'email');
}


}

