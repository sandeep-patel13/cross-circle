<?php

namespace App\Events;

use App\Models\GameSession;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Log;

class GameInvitationRejectedEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $gameSessionId;

    /**
     * Create a new event instance.
     */
    public function __construct($gameSessionId)
    {
        $this->gameSessionId = $gameSessionId;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        $inviter_id = GameSession::find($this->gameSessionId)->inviter->id;
        return [
            new PrivateChannel("invite.{$inviter_id}"),
        ];
    }

    public function broadcastAs()
    {
        return 'invitation-rejected';
    }

    public function broadcastWith()
    {
        return [
            'invitee_name' => GameSession::find($this->gameSessionId)->invitee->name
        ];
    }
}
