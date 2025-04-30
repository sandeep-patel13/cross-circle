<?php

namespace App\Livewire;

use Livewire\Attributes\On;
use Livewire\Component;

class CrossCircleMasterLivewire extends Component
{
    public $gameStarter;

    #[On('updateGameStarter')]
    public function updateGameStarter($gameStarter)
    {
        $this->gameStarter = $gameStarter;
    }

    public function render()
    {
        return view('livewire.cross-circle-master-livewire');
    }
}
