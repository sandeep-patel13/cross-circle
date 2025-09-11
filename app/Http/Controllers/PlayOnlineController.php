<?php

namespace App\Http\Controllers;

use App\Helpers\OnlineUserTracker;
use Illuminate\Support\Facades\Storage;

class PlayOnlineController extends Controller
{
    public function index()
    {
        return view('gaming.play-online.index', [
            'defaultImage' => Storage::disk('public')->url('images/user.png'),
            'onlineUsers' => OnlineUserTracker::onlineUsers()
        ]);
    }
}
