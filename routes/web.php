<?php

use App\Events\SendGamePlayInvitationEvent;
use App\Http\Controllers\PlayOnlineController;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');

    Route::view('play-game', 'gaming.index')->name('play-game');

    Route::get('play-online', [PlayOnlineController::class, 'index'])->name('play-online');

    Route::get('broadcast', function () {
        SendGamePlayInvitationEvent::dispatch();
        return 'Event broadcasted';
    });
});

require __DIR__ . '/auth.php';
