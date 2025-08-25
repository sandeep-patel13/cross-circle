<x-layouts.app :title="__('Dashboard')">

    @foreach ($online_users as $online_user)
        <div class="max-w-sm rounded overflow-hidden shadow-lg relative bg-gray-800 text-white">
            <div class="relative">
                <img class="mx-auto w-1/3" src="{{ $default_image }}" alt="User Image">

                <span class="absolute top-2 right-2">
                    <span class="flex h-3 w-3">
                        <span
                            class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-3 w-3 bg-green-500"></span>
                    </span>
                </span>
            </div>

            <div class="px-6 py-4">
                <div class="font-bold text-xl mb-2">{{ $online_user->name }}</div>
            </div>

            <div class="px-6 pt-4 pb-2">
                <flux:button class="cursor-pointer" variant="primary">Play</flux:button>
            </div>
        </div>
    @endforeach

    <x:slot name="script">
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                Echo.channel('invite').listen('.play-event', (e) => {
                    console.log('H');
                });
            });
        </script>
    </x:slot>
</x-layouts.app>
