<div>
    @foreach ($onlineUsers as $onlineUser)
        <div class="max-w-sm rounded-lg overflow-hidden shadow-2xl relative 
                    bg-black/80 backdrop-blur-sm border border-red-500/30
                    text-white transition-all duration-300">
            <div class="relative p-6">
                <img class="mx-auto w-1/3 rounded-full border-4 border-red-500/50" 
                     src="{{ $defaultImage }}" alt="User Image">

                <span class="absolute top-8 right-8">
                    <span class="flex h-4 w-4">
                        <span
                            class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-4 w-4 bg-red-500"></span>
                    </span>
                </span>
            </div>

            <div class="px-6 py-4 text-center">
                <div class="font-bold text-xl mb-2 text-white">{{ $onlineUser->name }}</div>
                <p class="text-gray-400 text-sm">Online Now</p>
            </div>

            <div class="px-6 pt-4 pb-6 text-center">
                <flux:button wire:click="sendGamePlayInvitation('{{ $onlineUser->id }}')" 
                    class="cursor-pointer play-btn w-full bg-gradient-to-r from-red-600 to-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-6 py-2.5 transition-all duration-200"
                    variant="primary">
                    Challenge to Play
                </flux:button>
            </div>
        </div>
    @endforeach
</div>