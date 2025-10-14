<div class="{{ $gameCompleted ? 'opacity-60 pointer-events-none select-none' : '' }}" wire:poll.1s="checkGameStatus">
    <!-- Countdown Callout -->
    <div class="w-64 mx-auto p-4 rounded-xl text-center font-bold 
           bg-gradient-to-br from-gray-900 to-gray-800 
           border-2 border-red-600 text-red-400
           shadow-[0_0_15px_rgba(239,68,68,0.6)] 
           drop-shadow-[0_0_10px_rgba(239,68,68,0.4)]
           {{ auth()->id() != $userTurn ? 'opacity-50 pointer-events-none' : '' }}"
        @if (auth()->id() == $userTurn && !$gameCompleted) wire:poll.1000ms="decrementTimer" @endif>

        <div class="text-lg tracking-wide uppercase">⏳ Countdown</div>
        <div class="text-3xl mt-1 font-extrabold">{{ $timer }}</div>
    </div>

    <!-- Game Board Section -->
    <div
        class="flex flex-col items-center justify-start min-h-screen mt-16 text-white {{ auth()->id() != $userTurn || $gameCompleted ? 'opacity-50 pointer-events-none' : '' }}">
        <h1 class="text-4xl font-extrabold mb-6 text-cyan-400 drop-shadow-[0_0_10px_rgba(6,182,212,0.8)] tracking-wider">
            ⚔️ TIC TAC TOE ⚔️
        </h1>

        <div
            class="grid grid-cols-3 gap-3 p-4 rounded-2xl bg-gradient-to-br from-gray-800 to-gray-900 shadow-[0_0_20px_rgba(6,182,212,0.3)]">
            @foreach ($gameBoard as $row)
                @foreach ($row as $cell)
                    <button
                        class="w-24 h-24 text-5xl font-extrabold rounded-xl bg-gray-900 border-2 border-cyan-500 text-cyan-400 hover:bg-cyan-500 hover:text-black hover:scale-105 transition-all duration-200 shadow-[0_0_10px_rgba(6,182,212,0.6)]">
                        {{ $userSymbol }}
                    </button>
                @endforeach
            @endforeach
        </div>
    </div>
</div>
