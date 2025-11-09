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

    public function winner()
    {
        return $this->belongsTo(User::class, 'winner_id', 'id');
    }

    public function looser()
    {
        return $this->belongsTo(User::class, 'loser_id', 'id');
    }

    public function scopeAllGameSession($query, $user_master_id)
    {
        return $this->where('inviter_id', $user_master_id)
            ->orWhere('invitee_id', $user_master_id);
    }

    public function scopeSearch($query, $searchTerm)
    {
        if (empty($searchTerm)) {
            return $query;
        }

        return $query->whereHas('inviter', function ($q) use ($searchTerm) {
            $q->where('name', 'like', '%'.$searchTerm.'%');
        })->orWhereHas('invitee', function ($q) use ($searchTerm) {
            $q->where('name', 'like', '%'.$searchTerm.'%');
        });
    }
}
