<?php

namespace App\Livewire;

use App\Models\GamingMaster;
use Exception;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Component;

class CrossCircleBoxLivewire extends Component
{
    public $gameStarter;

    public $currentMovingPlayer;

    public $gamingMaster;

    public $gameBoard;

    public $userSymbol;

    public $systemSymbol;

    private $digonalProperty;

    public $myRow;

    public $myColumn;

    public $winner;

    public $systemLastMovecordinates;

    public $winingRow;
    public $winingColumn;

    public $endGame;

    // it is only executed on first time
    public function mount($gameStarter)
    {
        $this->gameStarter = $gameStarter;
        $this->currentMovingPlayer = $gameStarter;
        for ($i = 0; $i < 3; $i++) {
            for ($j = 0; $j < 3; $j++) {
                $this->gameBoard[$i][$j] = null;
            }
        }
        $this->endGame = false;
    }

    // it is executed on first and also whenever it is used 
    public function __construct()
    {
        $this->digonalProperty = collect([
            [0, 0],
            [2, 0],
            [2, 2],
            [0, 2],
            [1, 1],
        ]);
    }

    public function getPossiblePaths($row, $column, $systemPriorityCordinate)
    {
        try {
            $possiblePaths = collect();
            $hr = collect();
            $vr = collect();
            $digonal = collect();
            $i = 0;

            // Horizontal Row
            $hr->put('priority', 0);
            while ($i < 3) {
                $cell = $this->gameBoard[$row][$i];
                if ($cell == ($systemPriorityCordinate ? $this->systemSymbol : $this->userSymbol)) {
                    $hr->put('priority', -1);
                    break;
                }
                if ($cell == ($systemPriorityCordinate ? $this->userSymbol : $this->systemSymbol)) {
                    $hr->put('priority', $hr->get('priority') + 1);
                }
                $hr->push([$row, $i]);
                $i++;
            }
            $possiblePaths->put('hr', $hr);

            // Vertical Row
            $vr->put('priority', 0);
            $i = 0;
            while ($i < 3) {
                $cell = $this->gameBoard[$i][$column];
                if ($cell == ($systemPriorityCordinate ? $this->systemSymbol : $this->userSymbol)) {
                    $vr->put('priority', -1);
                    break;
                }
                if ($cell == ($systemPriorityCordinate ? $this->userSymbol : $this->systemSymbol)) {
                    $vr->put('priority', $vr->get('priority') + 1);
                }
                $vr->push([$i, $column]);
                $i++;
            }
            $possiblePaths->put('vr', $vr);

            // Diagonals
            if ($this->digonalProperty->contains([$row, $column])) {
                $rowColumnLength = count($this->gameBoard);
                if ($row != 1 && $column != 1) {
                    $digonal->put('priority', 0);
                    $i = $row;
                    $j = $column;
                    while ($i >= 0 && $j >= 0 && $i < $rowColumnLength && $j < $rowColumnLength) {
                        $cell = $this->gameBoard[$i][$j];
                        if ($cell == ($systemPriorityCordinate ? $this->systemSymbol : $this->userSymbol)) {
                            $digonal->put('priority', -1);
                            break;
                        }
                        if ($cell == ($systemPriorityCordinate ? $this->userSymbol : $this->systemSymbol)) {
                            $digonal->put('priority', $digonal->get('priority') + 1);
                        }
                        $digonal->push([$i, $j]);

                        switch (true) {
                            case $row == 0 && $column == 0:
                                $i++;
                                $j++;
                                break;
                            case $row == 0 && $column == $rowColumnLength - 1:
                                $i++;
                                $j--;
                                break;
                            case $row == $rowColumnLength - 1 && $column == 0:
                                $i--;
                                $j++;
                                break;
                            case $row == $rowColumnLength - 1 && $column == $rowColumnLength - 1:
                                $i--;
                                $j--;
                                break;
                        }
                    }
                    if (
                        ($row == 0 && $column == 0)
                        ||
                        ($row == $rowColumnLength - 1 && $column == $rowColumnLength - 1)
                    ) {
                        $possiblePaths->put('firstDigonal', $digonal);
                    } else {
                        $possiblePaths->put('secondDigonal', $digonal);
                    }
                } else {
                    $digonal->put('priority', 0);
                    for ($i = 0, $j = 0; $i < $rowColumnLength; $i++, $j++) {
                        $cell = $this->gameBoard[$i][$j];
                        if ($cell == ($systemPriorityCordinate ? $this->systemSymbol : $this->userSymbol)) {
                            $digonal->put('priority', -1);
                            break;
                        }
                        if ($cell == ($systemPriorityCordinate ? $this->userSymbol : $this->systemSymbol)) {
                            $digonal->put('priority', $digonal->get('priority') + 1);
                        }
                        $digonal->push([$i, $j]);
                    }
                    $possiblePaths->put('firstDigonal', $digonal);

                    $digonal = collect();
                    $digonal->put('priority', 0);
                    for ($i = 0, $j = $rowColumnLength - 1; $i < $rowColumnLength && $j >= 0; $i++, $j--) {
                        $cell = $this->gameBoard[$i][$j];
                        if ($cell == ($systemPriorityCordinate ? $this->systemSymbol : $this->userSymbol)) {
                            $digonal->put('priority', -1);
                            break;
                        }
                        if ($cell == ($systemPriorityCordinate ? $this->userSymbol : $this->systemSymbol)) {
                            $digonal->put('priority', $digonal->get('priority') + 1);
                        }
                        $digonal->push([$i, $j]);
                    }
                    $possiblePaths->put('secondDigonal', $digonal);
                }
            }

            return $possiblePaths;
        } catch (Exception $e) {
            throw $e;
        }
    }

    private function areAllCordinatesFilled()
    {
        foreach ($this->gameBoard as $row) {
            foreach ($row as $cell) {
                if (!$cell)
                    return false;
            }
        }
        return true;
    }

    private function moveRandomly()
    {
        $nullCordinates = collect();
        for ($i = 0; $i < count($this->gameBoard); $i++) {
            for ($j = 0; $j < count($this->gameBoard); $j++) {
                if (!$this->gameBoard[$i][$j])
                    $nullCordinates->push([$i, $j]);
            }
        }
        $randomCordinate = $nullCordinates->random();
        $this->myRow = $randomCordinate[0];
        $this->myColumn = $randomCordinate[1];
        return;
    }

    public function endGame()
    {
        return redirect('play-game');
    }

    public function handelUserClick($row, $column)
    {
        $this->gameBoard[$row][$column] = $this->userSymbol;
        if ($this->areAllCordinatesFilled()) {
            LivewireAlert::title('Oops, No Winner!')
                ->warning()
                ->withConfirmButton('OK')
                ->show();
            $this->endGame = true;
            return;
        }
        try {
            $possiblePaths = $this->getPossiblePaths($row, $column, true);

            $maximumPriority = $possiblePaths->max('priority');

            $rowColumnLength = count($this->gameBoard);

            if ($this->systemLastMovecordinates) {
                $userPriorityPossiblePaths = $this->getPossiblePaths($this->systemLastMovecordinates['row'], $this->systemLastMovecordinates['column'], false);
                $userMaximumPriority = $userPriorityPossiblePaths->max('priority');
                if ($userMaximumPriority == $rowColumnLength - 1) {
                    $userPriorityPossiblePaths = $userPriorityPossiblePaths->filter(function ($path) use ($rowColumnLength) {
                        if ($path['priority'] == $rowColumnLength - 1) {
                            foreach ($path as $key => $detail) {
                                if ($key != 'priority') {
                                    if (!$this->gameBoard[$detail[0]][$detail[1]]) {
                                        $this->winingRow = $detail[0];
                                        $this->winingColumn = $detail[1];
                                        $this->currentMovingPlayer = 'system';
                                        return;
                                    }
                                }
                            }
                        }
                    });
                }
            }

            switch ($maximumPriority) {
                case $rowColumnLength: // winner
                    $this->winner = $this->currentMovingPlayer;
                    LivewireAlert::title('Congraulations, You won this game')
                        ->success()
                        ->withConfirmButton('OK')
                        ->show();
                    $this->endGame = true;
                    break;

                case -1: // move randomly, no priority
                    $this->moveRandomly();
                    break;

                default: // move logically
                    $possiblePaths = $possiblePaths->filter(fn($path) => $path->get('priority') == $maximumPriority);

                    // if any digonal exists in heigh priority paths then definetly move to any digonal 
                    if ($possiblePaths->has('firstDigonal') || $possiblePaths->has('secondDigonal')) {
                        $possiblePaths = $possiblePaths->reject(fn($detail, $path) => in_array($path, ['hr', 'vr']));
                    }

                    $randomPath = $possiblePaths->keys()->random();
                    $this->myRow = $row;
                    $this->myColumn = $column;
                    switch ($randomPath) {
                        case 'hr':
                            $i = $j = $column;
                            while ($i < $rowColumnLength || $j >= 0) {
                                if ($i < $rowColumnLength && !$this->gameBoard[$row][$i]) {
                                    $this->myColumn = $i;
                                    break;
                                }
                                if ($j >= 0 && !$this->gameBoard[$row][$j]) {
                                    $this->myColumn = $j;
                                    break;
                                }
                                $i++;
                                $j--;
                            }
                            break;

                        case 'vr':
                            $i = $j = $row;
                            while ($i < $rowColumnLength || $j >= 0) {
                                if ($i < $rowColumnLength && !$this->gameBoard[$i][$column]) {
                                    $this->myRow = $i;
                                    break;
                                }
                                if ($j >= 0 && !$this->gameBoard[$j][$column]) {
                                    $this->myRow = $j;
                                    break;
                                }
                                $i++;
                                $j--;
                            }
                            break;

                        case 'firstDigonal':
                            $i = $j = $row = $column;
                            while ($i < $rowColumnLength || $j >= 0) {
                                if ($i < $rowColumnLength && !$this->gameBoard[$i][$i]) {
                                    $this->myRow = $this->myColumn = $i;
                                    break;
                                }
                                if ($j >= 0 && !$this->gameBoard[$j][$j]) {
                                    $this->myRow = $this->myColumn = $j;
                                    break;
                                }
                                $i++;
                                $j--;
                            }
                            break;

                        case 'secondDigonal':
                            $i = $row;
                            $j = $column;
                            $gotEmptyCell = false;
                            while ($i < $rowColumnLength && $j >= 0) {
                                if (!$this->gameBoard[$i][$j]) {
                                    $gotEmptyCell = true;
                                    $this->myRow = $i;
                                    $this->myColumn = $j;
                                    break;
                                }
                                $i++;
                                $j--;
                            }
                            $i = $row;
                            $j = $column;
                            while (!$gotEmptyCell && $i >= 0 && $j < $rowColumnLength) {
                                if (!$this->gameBoard[$i][$j]) {
                                    $gotEmptyCell = true;
                                    $this->myRow = $i;
                                    $this->myColumn = $j;
                                    break;
                                }
                                $i--;
                                $j++;
                            }
                            break;
                    }
                    break;
            }
            
            $this->currentMovingPlayer = 'system';
        } catch (Exception $e) {
            dd($e);
        }
    }

    public function handleSystemClick()
    {
        if(!$this->myRow && !$this->myColumn && $this->gameStarter == 'system') {
            $this->systemSymbol = collect(['X', 'O'])->random();
            $this->gameBoard[1][1] = $this->systemSymbol;
            $this->userSymbol = $this->systemSymbol == 'X' ? 'O' : 'X';  
        } else {
            if (isset($this->winingRow) && isset($this->winingColumn)) {
                $this->gameBoard[$this->winingRow][$this->winingColumn] = $this->systemSymbol;
                $this->endGame = true;
                $userName = auth()->user()->name;
                LivewireAlert::title('Oops, you lost the game!')
                    ->text("Dear {$userName}, the system won this match. Better luck next time!")
                    ->error()
                    ->withConfirmButton('OK')
                    ->show();
            } else {
                $this->gameBoard[$this->myRow][$this->myColumn] = $this->systemSymbol;
                $this->systemLastMovecordinates = [
                    'row' => $this->myRow,
                    'column' => $this->myColumn
                ];
                
            }
        }
        if ($this->areAllCordinatesFilled()) {
            LivewireAlert::title('Oops, No Winner!')
                ->warning()
                ->withConfirmButton('OK')
                ->show();
            $this->endGame = true;
        }
        $this->currentMovingPlayer = 'user';
    }

    public function handleClick($row, $column, $symbol)
    {
        if (!$this->gamingMaster) {
            $this->gamingMaster = new GamingMaster;
        }
        if ($this->userSymbol == null && $this->systemSymbol == null) {
            $this->userSymbol = $symbol;
            $this->systemSymbol = $symbol == 'X' ? 'O' : 'X';
        }
        $this->currentMovingPlayer == 'user'
            ? $this->handelUserClick($row, $column)
            : $this->handelSystemClick($row, $column);
    }

    public function render()
    {
        return view('livewire.cross-circle-box-livewire');
    }
}
