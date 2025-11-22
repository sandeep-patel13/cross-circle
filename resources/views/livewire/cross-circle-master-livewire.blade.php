<div class="fixed inset-0 ml-64 flex items-center justify-center p-4 bg-gradient-to-br from-black via-red-950 to-black">
    <!-- Animated background pattern -->
    <div class="absolute inset-0 opacity-20">
        <div class="absolute inset-0"
            style="background-image: 
            repeating-linear-gradient(0deg, transparent, transparent 2px, rgba(220, 38, 38, 0.1) 2px, rgba(220, 38, 38, 0.1) 4px),
            repeating-linear-gradient(90deg, transparent, transparent 2px, rgba(220, 38, 38, 0.1) 2px, rgba(220, 38, 38, 0.1) 4px);
            background-size: 50px 50px;">
        </div>
    </div>

    <!-- Glowing orbs effect -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div
            class="absolute top-1/4 left-1/4 w-96 h-96 bg-red-600 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse">
        </div>
        <div class="absolute top-1/3 right-1/4 w-96 h-96 bg-red-800 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse"
            style="animation-delay: 2s;"></div>
        <div class="absolute bottom-1/4 left-1/3 w-96 h-96 bg-red-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse"
            style="animation-delay: 4s;"></div>
    </div>

    @if ($gameStarter == null)
        <livewire:game-starter-form-livewire />
    @else
        <livewire:cross-circle-box-livewire :gameStarter="$gameStarter" />
    @endif
</div>
