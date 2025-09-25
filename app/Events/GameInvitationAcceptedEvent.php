<?php

namespace App\Events;

use App\Models\GameSession;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class GameInvitationAcceptedEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(private GameSession $gameSession)
    {
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
            new PrivateChannel("invite.{$this->gameSession->inviter_id}"),
        ];
    }

    public function broadcastAs()
    {
        return 'invitation-accepted';
    }

    public function broadcastWith()
    {
        return [
            'invitee_name' => $this->gameSession->invitee->name,
        ];
    }
}
