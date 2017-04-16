<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * @var array
     */
    public $appends = ['image_url'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'image'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Get full url path for profile image
     *
     * @return string
     */
    public function getImageUrlAttribute()
    {
        return asset('images/' . $this->image);
    }

    /**
     * Get all user except current one
     *
     * @return mixed
     */
    public function exceptMe()
    {
        return User::select('id', 'name', 'image')
            ->where('id', '!=', $this->id);
    }

    /**
     * Get all conversations for current user
     *
     * @return mixed
     */
    public function conversations()
    {
        return Conversation::where(function($query) {
            $query->where('user_id', $this->id)
                ->orWhere('sender_id', $this->id);
        });
    }

    /**
     * @param $UserId
     * @return mixed
     */
    public function conversationWithUser($UserId)
    {
        return $this->conversations()->where(function($query) use($UserId) {
            $query->where('user_id', $UserId)
                ->orWhere('sender_id', $UserId);
        });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function messagesSent()
    {
        return $this->hasMany(Conversation::class, 'sender_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function messagesReceived()
    {
        return $this->hasMany(Conversation::class, 'user_id');
    }
}
