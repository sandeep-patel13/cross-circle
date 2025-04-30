<?php

namespace App\Livewire;

use Livewire\Attributes\Rule;
use Livewire\Component;

class GameStarterFormLivewire extends Component
{
    #[Rule('required')]
    public $gameStarter;

    public function mount()
    {
        $this->gameStarter = null;
    }

    public function chooseGameStarter()
    {
        $this->validate();
        $this->dispatch('updateGameStarter', $this->gameStarter);
    }

    public function render()
    {
        return view('livewire.game-starter-form-livewire');
    }
}
