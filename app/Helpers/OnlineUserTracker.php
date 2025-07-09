<?php

namespace App\Helpers;

use App\Models\User;
use Cache;


class OnlineUserTracker
{
    protected static $key = 'onlineUsers';


    public static function add($userId)
    {
        $onlineUsers = Cache::get(self::$key, []);
        $onlineUsers[$userId] = now();
        Cache::forever(self::$key, $onlineUsers);
    }
     
    public static function remove($userId)
    {
        $onlineUsers = Cache::get(self::$key, []);
        unset($onlineUsers[$userId]);
        Cache::forever(self::$key, $onlineUsers);
    }

    public static function onlineUsers()
    {
        $onlineUsers = Cache::get(self::$key, []);
        unset($onlineUsers[auth()->user()->id]);
        return User::whereIn('id', array_keys($onlineUsers))->get();
    }
}