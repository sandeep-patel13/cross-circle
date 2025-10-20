<?php

use App\Models\User;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('invite.{onlineUserId}', function (User $user, $onlineUserId) {
    return (int) $user->id === (int) $onlineUserId;
});

Broadcast::channel('game-move-update.{userTurn}', function (User $user, $userTurn) {
    return (int) $user->id === (int) $userTurn;
});