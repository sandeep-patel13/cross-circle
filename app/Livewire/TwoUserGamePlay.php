<?php

namespace App\Livewire;

use App\Enums\GameSessionStatusEnum;
use App\Events\GameMoveUpdationEvent;
use App\Models\GameSession;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Component;
use Log;

class TwoUserGamePlay extends Component
{
    public $gameBoard;

    public $gameSession;

    public $inviteeSymbol;

    public $inviterSymbol;

    public $userSymbol;

    public $timer = 25;

    public $movedCells;

    public $winingAlertShown = false;

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

        // Set current user turn
        $this->gameSession->update([
            'current_user_turn_id' => $this->gameSession->inviter_id,
        ]);

        // Refresh game session
        $this->gameSession->refresh();

        if (auth()->id() == $this->gameSession->inviter_id) {
            $this->userSymbol = $this->inviterSymbol;
        } else {
            $this->userSymbol = $this->inviteeSymbol;
        }

        // Initialize the game board
        $this->initializeGameBoard();

        // Initialize disabled cells
        $this->movedCells = collect();

        // Clear session variables
        session()->forget('gameCompleted');
        session()->forget('wonByTimeout');
        session()->forget('lostButNotByTimeout');
    }

    public function handleTimeUp()
    {

        session()->put('gameCompleted', true);

        // Current user is the loser, his time is up
        $loserId = auth()->id();
        // Get the winner user
        $winnerId = ($loserId == $this->gameSession->inviter_id) ? $this->gameSession->invitee_id : $this->gameSession->inviter_id;
        // Update game session
        $this->gameSession->update([
            'status' => GameSessionStatusEnum::Completed->value,
            'winner_id' => $winnerId,
            'game_won_by_timeout' => true,
        ]);

        $this->gameSession->refresh();

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
        // don't process if game is not completed
        if ($this->gameSession->status != GameSessionStatusEnum::Completed->value) {
            return;
        }

        // Refresh model
        $this->gameSession->refresh();

        // If current user is winner & won by timeout
        if (auth()->id() == $this->gameSession->winner_id && $this->gameSession->game_won_by_timeout && ! session('wonByTimeout')) {
            LivewireAlert::title('You Won!')
                ->text('Congratulations 🎉, you won this match by the time')
                ->success()
                ->toast()
                ->position('top-end')
                ->show();
            $this->timer = 0;
            session()->put('wonByTimeout', true);

            return;
        }

        Log::info('Checking game status for user id: ', [
            'user_id' => auth()->id(),
            'loser_id' => $this->gameSession->loser_id,
            'game_won_by_timeout' => $this->gameSession->game_won_by_timeout,
            'lostButNotByTimeoutSession' => session('lostButNotByTimeout'),
        ]);
        // If current user is looser but not by timeout
        if (auth()->id() == $this->gameSession->loser_id && $this->gameSession->game_won_by_timeout == false && ! session('lostButNotByTimeout')) {
            LivewireAlert::title('You Lost!')
                ->text('Dear user, you lost the game 😢')
                ->error()
                ->toast()
                ->position('top-end')
                ->show();
            session()->put('lostButNotByTimeout', true);
            return;
        }

    }

    public function printGameBoard()
    {
        foreach ($this->gameBoard as $row) {
            Log::info(implode(' | ', $row));
        }
    }

    public function decrementTimer()
    {
        if ($this->timer > 0) {
            $this->timer--;
        } else {
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

    public function isThisUserWon($move, $row, $column)
    {
        $horizontalWin = 0;
        $verticalWin = 0;
        $diagonalWin1 = 0;
        $diagonalWin2 = 0;

        // Check horizontal
        for ($col = 0; $col < 3; $col++) {
            if ($this->gameSession->game_board[$row][$col] != '' && $this->gameSession->game_board[$row][$col] == $move) {
                $horizontalWin++;
            }
        }

        // Check vertical
        for ($r = 0; $r < 3; $r++) {
            if ($this->gameSession->game_board[$r][$column] != '' && $this->gameSession->game_board[$r][$column] == $move) {
                $verticalWin++;
            }
        }

        // Check diagonal (top-left to bottom-right)
        if ($row == $column) {
            for ($i = 0; $i < 3; $i++) {
                if ($this->gameSession->game_board[$i][$i] != '' && $this->gameSession->game_board[$i][$i] == $move) {
                    $diagonalWin1++;
                }
            }
        }

        // Check diagonal (top-right to bottom-left)
        if ($row + $column == 2) {
            for ($i = 0; $i < 3; $i++) {
                if ($this->gameSession->game_board[$i][2 - $i] != '' && $this->gameSession->game_board[$i][2 - $i] == $move) {
                    $diagonalWin2++;
                }
            }
        }

        if ($horizontalWin == 3 || $verticalWin == 3 || $diagonalWin1 == 3 || $diagonalWin2 == 3) {
            session()->put('gameCompleted', true);
            // Current user is the winner
            $winnerId = auth()->id();
            // Get the loser user
            $loserId = ($winnerId == $this->gameSession->inviter_id) ? $this->gameSession->invitee_id : $this->gameSession->inviter_id;
            // Update game session
            $this->gameSession->update([
                'status' => GameSessionStatusEnum::Completed->value,
                'winner_id' => $winnerId,
                'loser_id' => $loserId,
            ]);

            return true;
        }

        return false;
    }

    public function handleMove($row, $column, $move)
    {
        // Since user has selected, make it disable
        $this->movedCells->put(
            'cordinate', "{$row}-{$column}",
        );
        $this->movedCells->put(
            'symbol', $move,
        );

        // Get prev turn user
        $prev_user_turn_id = $this->gameSession->current_user_turn_id;

        // Get current user turn id
        $current_user_turn_id = $this->gameSession->current_user_turn_id == $this->gameSession->inviter_id
            ? $this->gameSession->invitee_id
            : $this->gameSession->inviter_id;

        // Update the current user turn, and game board
        $gameBoard = $this->gameSession->game_board;
        $gameBoard[$row][$column] = $move;
        $this->gameSession->update([
            'current_user_turn_id' => $current_user_turn_id,
            'game_board' => $gameBoard,
        ]);

        // Refresh game session
        $this->gameSession->refresh();

        // Reset the timer
        $this->timer = 25;

        // Now fire the event to notify the opponent about the move
        GameMoveUpdationEvent::dispatch($this->movedCells, $this->gameSession->current_user_turn_id);

        // Check if someone has won
        $isThisUserWon = $this->isThisUserWon($move, $row, $column);

        // Show winning alert if user won
        if ($isThisUserWon) {
            LivewireAlert::title('You Won!')
                ->text('Congratulations 🎉, you won this match')
                ->success()
                ->toast()
                ->position('top-end')
                ->show();
        }
    }
}
