<?php

namespace App\Livewire;

use App\Enums\GameSessionStatusEnum;
use App\Models\GameSession;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Component;

class TwoUserGamePlay extends Component
{
    public $gameBoard;

    public $gameSession;

    public $inviteeSymbol;

    public $inviterSymbol;

    public $userSymbol;

    public $timer = 15;

    public $timeUpAlertShown = false;

    public $userTurn;

    public $gameCompleted = false;

    public function render()
    {
        return view('livewire.two-user-game-play');
    }

    public function mount($gameSessionId)
    {
        // Initialize game session
        $this->gameSession = GameSession::find($gameSessionId);

        // Set player symbols
        $this->inviterSymbol = 'X';
        $this->inviteeSymbol = 'O';
        $this->userTurn = $this->gameSession->inviter_id;

        if (auth()->id() == $this->gameSession->inviter_id) {
            $this->userSymbol = $this->inviterSymbol;
        } else {
            $this->userSymbol = $this->inviteeSymbol;
        }

        // Initialize the game board
        $this->initializeGameBoard();
    }

    public function handleTimeUp()
    {
        $this->timeUpAlertShown = true;

        $this->gameCompleted = true;

        // Current user is the loser, his time is up
        $loserId = auth()->id();
        // Get the winner user
        $winnerId = ($loserId == $this->gameSession->inviter_id) ? $this->gameSession->invitee_id : $this->gameSession->inviter_id;
        // Update game session
        $this->gameSession->update([
            'status' => GameSessionStatusEnum::Completed->value,
            'winner_id' => $winnerId,
        ]);

        LivewireAlert::title('Time Up!')
            ->text('You lost this game, better luck next time!')
            ->info()
            ->toast()
            ->position('top-end')
            ->show();
        $this->timer = 0;
    }

    public function checkGameStatus()
    {
        // Refresh model
        $this->gameSession->refresh();
        // Handle game compeletion
        if (! $this->gameCompleted && $this->gameSession->status == GameSessionStatusEnum::Completed->value) {
            $this->gameCompleted = true;
            // If current user is winner
            if (auth()->id() == $this->gameSession->winner_id) {
                LivewireAlert::title('You Won!')
                    ->text('Congratulations 🎉, you won this match by the time')
                    ->success()
                    ->toast()
                    ->position('top-end')
                    ->show();
                $this->timer = 0;
            }
        }
    }

    public function decrementTimer()
    {
        if ($this->timer > 0) {
            $this->timer--;
        } elseif (! $this->timeUpAlertShown) {
            $this->handleTimeUp();
        }
    }

    public function initializeGameBoard()
    {
        $this->gameBoard = array_fill(0, 3, array_fill(0, 3, $this->userSymbol));
    }
    public function goBack()
    {
        return redirect()->route('play-online');
    }
}
