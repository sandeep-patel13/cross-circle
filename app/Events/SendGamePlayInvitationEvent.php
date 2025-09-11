<?php

namespace App\Events;

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

    /**
     * Create a new event instance.
     */
    public function __construct(
        private $onlineUserId,
        private $fromUserId
    ) {}

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
        Log::info('broadcastWith() was called', [
            'fromUserId' => $this->fromUserId,
            'onlineUserId' => $this->onlineUserId,
        ]);
        return [
            'fromUserId' => $this->fromUserId,
            'onlineUserId' => $this->onlineUserId,
        ];
    }

}
