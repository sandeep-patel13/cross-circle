<?php

namespace App\Http\Controllers;

use App\Events\SendGamePlayInvitationEvent;
use App\Helpers\OnlineUserTracker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PlayOnlineController extends Controller
{
    public function index()
    {
        return view('gaming.play-online.index', [
            'default_image' => Storage::disk('public')->url('images/user.png'),
            'online_users' => OnlineUserTracker::onlineUsers()
        ]);
    }

}
