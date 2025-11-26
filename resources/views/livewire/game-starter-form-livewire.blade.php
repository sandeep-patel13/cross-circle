<form wire:submit.prevent="chooseGameStarter"
    class="relative z-10 w-full max-w-sm flex flex-col items-center text-center shadow-2xl p-8 rounded-xl bg-black/80 backdrop-blur-sm border border-red-500/30">
    <div class="mb-5 w-full">
        <label for="gameStarter" class="block mb-4 text-sm font-medium text-white">
            What you prefer ?
        </label>

        <div class="flex flex-col space-y-4 items-center">
            <div class="flex items-center">
                <input wire:model="gameStarter" id="startGame" type="radio" value="user" name="gameStarter"
                    class="w-4 h-4 text-red-600 bg-gray-900 border-gray-700 focus:ring-red-500 focus:ring-2">
                <label for="startGame" class="ms-2 text-sm font-medium text-gray-200">Start
                    Game</label>
            </div>
            <div class="flex items-center">
                <input wire:model="gameStarter" id="letStartGame" type="radio" value="system" name="gameStarter"
                    class="w-4 h-4 text-red-600 bg-gray-900 border-gray-700 focus:ring-red-500 focus:ring-2">
                <label for="letStartGame" class="ms-2 text-sm font-medium text-gray-200">Let
                    System Start
                    Game</label>
            </div>
        </div>
    </div>
    @error('gameStarter')
        <span class="text-red-400 text-xs mb-3">{{ $message }}</span>
    @enderror
    <button type="submit" class="btn-dark-red">Let's Start Game</button>
</form>
