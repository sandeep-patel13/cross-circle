<?php

namespace App\Events;

use App\Models\GameSession;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Log;

class GameInvitationRejectedEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public GameSession $gameSession;

    /**
     * Create a new event instance.
     */
    public function __construct(GameSession $gameSession)
    {
        $this->gameSession = $gameSession;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        // The relationship is already loaded, so no need for an extra query.
        return [
            new PrivateChannel("invite.{$this->gameSession->inviter_id}"),
        ];
    }

    public function broadcastAs()
    {
        return 'invitation-rejected';
    }

    public function broadcastWith()
    {
        return [
            'invitee_name' => $this->gameSession->invitee->name,
        ];
    }
}
