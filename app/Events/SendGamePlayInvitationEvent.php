<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Log;

class SendGamePlayInvitationEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private $fromUserName;
    /**
     * Create a new event instance.
     */
    public function __construct(
        private $onlineUserId,
        private $fromUserId,
    ) {
        $this->fromUserName = User::find($fromUserId)->name;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel("invite.{$this->onlineUserId}")
        ];
    }

    public function broadcastAs()
    {
        return 'play-event';
    }

    public function broadcastWith(): array
    {
        return [
            'fromUserId' => $this->fromUserId,
            'fromUserName' => $this->fromUserName,
            'onlineUserId' => $this->onlineUserId,
        ];
    }

}
