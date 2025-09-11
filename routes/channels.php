<?php

use App\Models\User;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('invite.{onlineUserId}', function (User $user, $onlineUserId) {
    // Log::info($user->id);
    // Log::info($onlineUserId);
    // Log::info((int) $user->id === (int) $onlineUserId);
    return (int) $user->id === (int) $onlineUserId;
});