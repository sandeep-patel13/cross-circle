<?php

namespace App\Livewire;

use App\Enums\GameSessionStatusEnum;
use App\Models\GameSession;
use Livewire\Component;
use Livewire\WithPagination;

class GameSessionTableLivewire extends Component
{
    use WithPagination;

    public $perPage = 10;
    public $search = '';

    public function render()
    {
        $thisUserGameSessions = GameSession::allGameSession(auth()->user()->id)
            ->search($this->search)
            ->where('status', GameSessionStatusEnum::Completed->value)
            ->with([
                'inviter', 'invitee',
            ])
            ->select([
                'id',
                'inviter_id',
                'invitee_id',
                'status',
                'game_won_by_timeout',
                'started_at',
                'ended_at',
                'winner_id',
                'loser_id',
                'created_at',
                'ended_at',
            ])
            ->orderBy('created_at' , 'desc')
            ->paginate($this->perPage);

        return view('livewire.game-session-table-livewire', [
            'gameSessions' => $thisUserGameSessions,
        ]);
    }
}
