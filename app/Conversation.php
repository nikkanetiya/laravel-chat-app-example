<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'sender_id', 'message'
    ];

    public function scopeConversationOf($query, $userId)
    {
        return $query->where('user_id', $userId)
                    ->orWhere('sender_id', $userId);
    }
}
