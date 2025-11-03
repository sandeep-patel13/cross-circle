<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GameSession extends Model
{
    protected $fillable = [
        'inviter_id',
        'invitee_id',
        'current_user_turn_id',
        'game_board',
        'status',
        'started_at',
        'ended_at',
        'winner_id',
        'loser_id',
        'game_won_by_timeout',
    ];

    public $casts = [
        'game_board' => 'array',
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
