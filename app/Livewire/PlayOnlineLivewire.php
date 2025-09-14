<?php

namespace App\Livewire;

use App\Events\SendGamePlayInvitationEvent;
use App\Helpers\OnlineUserTracker;
use Livewire\Component;
use Log;
use Storage;

class PlayOnlineLivewire extends Component
{
    public $defaultImage;
    public $onlineUsers;

    public function mount()
    {
        $this->defaultImage = Storage::disk('public')->url('images/user.png');
        $this->onlineUsers = OnlineUserTracker::onlineUsers();
    }

    public function sendGamePlayInvitation($onlineUserId)
    {
        SendGamePlayInvitationEvent::dispatch($onlineUserId, auth()->user()->id);
        $this->dispatch('show-toast', [
            'message' => 'Game play invitation sent successfully'
        ]);
    }

    public function render()
    {
        return view('livewire.play-online-livewire');
    }
}
