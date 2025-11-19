<div class="fixed inset-0 ml-64 flex items-center justify-center p-4 bg-gradient-to-br from-black via-red-950 to-black">
    <!-- Animated background pattern -->
    <div class="absolute inset-0 opacity-20">
        <div class="absolute inset-0" style="background-image: 
            repeating-linear-gradient(0deg, transparent, transparent 2px, rgba(220, 38, 38, 0.1) 2px, rgba(220, 38, 38, 0.1) 4px),
            repeating-linear-gradient(90deg, transparent, transparent 2px, rgba(220, 38, 38, 0.1) 2px, rgba(220, 38, 38, 0.1) 4px);
            background-size: 50px 50px;">
        </div>
    </div>
    
    <!-- Glowing orbs effect -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-red-600 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse"></div>
        <div class="absolute top-1/3 right-1/4 w-96 h-96 bg-red-800 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse" style="animation-delay: 2s;"></div>
        <div class="absolute bottom-1/4 left-1/3 w-96 h-96 bg-red-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse" style="animation-delay: 4s;"></div>
    </div>

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
        <button type="submit"
            class="text-white bg-gradient-to-r from-red-600 to-red-800 hover:from-red-700 hover:to-red-900 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-6 py-2.5 shadow-lg shadow-red-500/50 transition-all duration-200 hover:shadow-xl hover:shadow-red-500/50 hover:scale-105">
            Let's Start Game
        </button>
    </form>
</div>