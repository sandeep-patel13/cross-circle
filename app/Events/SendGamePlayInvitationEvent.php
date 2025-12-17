<?php

namespace App\Events;

use App\Models\GameSession;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SendGamePlayInvitationEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(
        private GameSession $gameSession
    ) {
        $this->gameSession->load('inviter', 'invitee');
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel("invite.{$this->gameSession->invitee_id}"),
        ];
    }

    public function broadcastAs()
    {
        return 'play-event';
    }

    public function broadcastWith(): array
    {
        return [
            'fromUserId' => $this->gameSession->inviter_id,
            'fromUserName' => $this->gameSession->inviter->name,
            'onlineUserId' => $this->gameSession->invitee_id,
            'gameSession' => $this->gameSession,
        ];
    }
}
