<?php

namespace App\Livewire;

use App\Enums\GameSessionStatusEnum;
use App\Events\GameInvitationAcceptedEvent;
use App\Events\GameInvitationRejectedEvent;
use App\Events\SendGamePlayInvitationEvent;
use App\GameStatus;
use App\Helpers\OnlineUserTracker;
use App\Models\GameSession;
use Livewire\Component;
use Log;
use Storage;

class PlayOnlineLivewire extends Component
{
    public $defaultImage;
    public $onlineUsers;

    public $listeners = [
        'game-play-invitation-accepted' => 'gamePlayInvitationAccecpted',
        'game-play-invitation-rejected' => 'gamePlayInvitationRejected',
    ];

    public function mount()
    {
        $this->defaultImage = Storage::disk('public')->url('images/user.png');
        $this->onlineUsers = OnlineUserTracker::onlineUsers();
    }

    public function sendGamePlayInvitation($onlineUserId)
    {
        $gameSession = GameSession::create([
            'inviter_id' => auth()->user()->id,
            'invitee_id' => $onlineUserId,
            'status' => GameSessionStatusEnum::Pending->value,
        ]);
        SendGamePlayInvitationEvent::dispatch($onlineUserId, auth()->user()->id, $gameSession->id);
        $this->dispatch('show-toast', [
            'message' => 'Game play invitation sent successfully'
        ]);
    }

    public function gamePlayInvitationAccecpted($gameSessionId)
    {
        $gameSession = GameSession::findOrFail($gameSessionId);
        $gameSession->update([
            'status' => GameSessionStatusEnum::Active->value,
            'started_at' => now()
        ]);
        GameInvitationAcceptedEvent::dispatch($gameSessionId);
    }

    public function gamePlayInvitationRejected($gameSessionId)
    {
        $gameSession = GameSession::findOrFail($gameSessionId);
        $gameSession->update([
            'status' => GameSessionStatusEnum::Cancelled->value,
        ]);
        GameInvitationRejectedEvent::dispatch($gameSessionId);
    }

    public function render()
    {
        return view('livewire.play-online-livewire');
    }
}
