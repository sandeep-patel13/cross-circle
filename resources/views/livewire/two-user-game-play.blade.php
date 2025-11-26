<div x-data=""
    x-init=
    "
        Echo.private('game-move-update.{{ auth()->id() }}')
        .listen('.game-move-update', (e) => {
            let countdownSection = $('#countdownSection');
            let gameBoardSection = $('#gameBoardSection');
            countdownSection.removeClass('opacity-50 pointer-events-none');
            gameBoardSection.removeClass('opacity-50 pointer-events-none');
            {{-- console.log(countdownSection);
            $('.symbol-buttons').each(function() {
                if ($(this).attr('id') === `${e.moveCells.cordinate}`) {
                    $(this).text(e.moveCells.symbol);
                    $(this).addClass('pointer-events-none opacity-50');
                }
            }); --}}
        });

    "
    wire:poll.1s="checkGameStatus">
    <!-- Countdown Section -->
    <div id="countdownSection"
        class="w-64 mx-auto p-4 rounded-xl text-center font-bold 
               bg-black/80 backdrop-blur-md border border-red-500/40 text-red-400
               {{ auth()->id() != $gameSession->current_user_turn_id ? 'opacity-50 pointer-events-none' : '' }}
               {{ $this->gameSession->status == $this->gameSessionStatusEnum::Completed->value ? 'opacity-60 select-none' : '' }}"
        @if (auth()->id() == $gameSession->current_user_turn_id && !($this->gameSession->status == $this->gameSessionStatusEnum::Completed->value)) wire:poll.1000ms="decrementTimer" @endif>
        <div class="text-lg tracking-wide uppercase">⏳ Countdown</div>
        <div class="text-3xl mt-1 font-extrabold">{{ $timer }}</div>
    </div>

    <!-- Game Board Section -->
    <div id="gameBoardSection" class="flex flex-col items-center justify-start min-h-screen mt-16 text-white">
        <h1
            class="text-4xl font-extrabold mb-6 text-cyan-400 tracking-wider">
            ⚔️ TIC TAC TOE ⚔️
        </h1>

        <!-- Board -->
        <div
            class="grid grid-cols-3 gap-3 p-4 rounded-2xl 
                   bg-black/80 backdrop-blur-md border border-red-500/40
                   shadow-[0_0_20px_rgba(6,182,212,0.3)]
                   {{ auth()->id() != $gameSession->current_user_turn_id || $this->gameSession->status == $this->gameSessionStatusEnum::Completed->value ? 'opacity-50 pointer-events-none' : '' }}">
            @foreach ($gameBoard as $x => $row)
                @foreach ($row as $y => $cell)
                    <button id="{{ "{$x}-{$y}" }}"
                        class="btn-dark-red
                               {{ strlen($gameSession->game_board[$x][$y]) > 0 ? 'pointer-events-none opacity-50' : '' }}"
                        wire:click="handleMove('{{ $x }}', '{{ $y }}', '{{ strlen($gameSession->game_board[$x][$y]) > 0 ? $gameSession->game_board[$x][$y] : $cell }}')">
                        {{ strlen($gameSession->game_board[$x][$y]) > 0 ? $gameSession->game_board[$x][$y] : $cell }}
                    </button>
                @endforeach
            @endforeach
        </div>

        <!-- Go Back Button -->
        @if ($this->gameSession->status == $this->gameSessionStatusEnum::Completed->value)
            <div class="mt-6 text-center">
                <flux:button class="btn-dark-red" wire:click="goBack()" variant="primary">Go Back</flux:button>
            </div>
        @endif
    </div>
</div>
