<div id="gameStarterForm" tabindex="-1" aria-hidden="false"
    class="flex bg-white dark:bg-gray-800 overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-2xl max-h-full">
        <form wire:submit.prevent="chooseGameStarter"
            class="max-w-sm mx-auto flex flex-col items-center text-center shadow-lg p-6 rounded-lg">
            <div class="mb-5 w-full">
                <label for="gameStarter" class="block mb-4 text-sm font-medium text-gray-900 dark:text-white">
                    What you prefer ?
                </label>

                <div class="flex flex-col space-y-4 items-center">
                    <div class="flex items-center">
                        <input wire:model="gameStarter" id="startGame" type="radio" value="user"
                            name="gameStarter"
                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <label for="startGame"
                            class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Start
                            Game</label>
                    </div>
                    <div class="flex items-center">
                        <input wire:model="gameStarter" id="letStartGame" type="radio" value="system"
                            name="gameStarter"
                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <label for="letStartGame"
                            class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Let
                            System Start
                            Game</label>
                    </div>
                </div>
            </div>
            @error('gameStarter')
                <span class="text-red-500 text-xs mb-3">{{ $message }}</span>
            @enderror
            <button type="submit"
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                Let's Start Game
            </button>
        </form>
    </div>
</div>
