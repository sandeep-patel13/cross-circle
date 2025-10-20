<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GameSession extends Model
{
    protected $fillable = [
        'inviter_id',
        'invitee_id',
        'current_user_turn_id',
        'status',
        'started_at',
        'ended_at',
        'winner_id'
    ];

    public function inviter()
    {
        return $this->belongsTo(User::class, 'inviter_id', 'id');
    }

    public function invitee()
    {
        return $this->belongsTo(User::class, 'invitee_id', 'id');
    }
}
