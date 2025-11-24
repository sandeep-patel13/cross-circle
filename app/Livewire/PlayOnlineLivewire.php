<?php

namespace App\Livewire;

use App\Enums\GameSessionStatusEnum;
use App\Events\GameInvitationAcceptedEvent;
use App\Events\GameInvitationRejectedEvent;
use App\Events\SendGamePlayInvitationEvent;
use App\Helpers\OnlineUserTracker;
use App\Models\GameSession;
use Livewire\Component;
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
        $this->defaultImage = Storage::disk('public')->url('images/gaming-avatar.jpg');
        $this->onlineUsers = OnlineUserTracker::onlineUsers();
    }

    public function sendGamePlayInvitation($onlineUserId)
    {
        $gameSession = GameSession::create([
            'inviter_id' => auth()->user()->id,
            'invitee_id' => $onlineUserId,
            'status' => GameSessionStatusEnum::Pending->value,
        ]);
        $gameSession = $gameSession->load('inviter', 'invitee');
        SendGamePlayInvitationEvent::dispatch($gameSession);
        $this->dispatch('show-toast', [
            'message' => 'Game play invitation sent successfully',
        ]);
    }

    public function gamePlayInvitationAccecpted($gameSessionId)
    {
        $gameSession = GameSession::findOrFail($gameSessionId);
        $gameSession->update([
            'status' => GameSessionStatusEnum::Active->value,
            'started_at' => now(),
        ]);
        $gameSession->refresh();
        GameInvitationAcceptedEvent::dispatch($gameSession);

        return redirect()->route('request-accpeted', [
            'gameSessionId' => $gameSessionId,
        ]);
    }

    public function gamePlayInvitationRejected($gameSessionId)
    {
        $gameSession = GameSession::with('inviter', 'invitee')->findOrFail($gameSessionId);
        $gameSession->update([
            'status' => GameSessionStatusEnum::Cancelled->value,
        ]);
        $gameSession->refresh();
        GameInvitationRejectedEvent::dispatch($gameSession);
    }

    public function render()
    {
        return view('livewire.play-online-livewire');
    }
}
