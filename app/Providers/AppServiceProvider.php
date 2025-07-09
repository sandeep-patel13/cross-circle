<?php

namespace App\Providers;

use App\Helpers\OnlineUserTracker;
use App\Livewire\Actions\Logout;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Login::class is an event, fired by laravel when user logs in
        Event::listen(Login::class, function ($event) {
            OnlineUserTracker::add($event->user->id);
        });

        // Logout::class is an event, fired by laravel when user logs out
        Event::listen(Logout::class, function ($event) {
            OnlineUserTracker::remove($event->user->id);
        });
    }
}
