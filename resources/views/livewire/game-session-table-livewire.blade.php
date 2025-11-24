<div class="mx-auto max-w-screen-xl px-4 lg:px-12">
    <div
        class="relative shadow-2xl sm:rounded-xl overflow-hidden 
                bg-black/80 backdrop-blur-md border border-red-500/40">

        <!-- TOP BAR -->
        <div
            class="flex flex-col md:flex-row items-center justify-between 
                    space-y-3 md:space-y-0 md:space-x-4 p-4 
                    border-b border-red-500/30 bg-black/60">

            <div class="w-full md:w-1/2">
                <form class="flex items-center">
                    <label for="simple-search" class="sr-only">Search</label>

                    <div class="relative w-full">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg aria-hidden="true" class="w-5 h-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </div>

                        <input type="text" id="simple-search" wire:model.live.debounce.500ms="search"
                            class="bg-black/40 border border-red-500/40 text-white placeholder-red-300/60 
                                   text-sm rounded-lg focus:ring-red-500 focus:border-red-500 
                                   block w-full pl-10 p-2.5 backdrop-blur-sm"
                            placeholder="Search game sessions">
                    </div>
                </form>
            </div>
        </div>

        <!-- TABLE -->
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-red-200">
                <thead class="text-xs uppercase bg-red-900/40 text-red-300">
                    <tr>
                        <th class="px-4 py-3">Inviter</th>
                        <th class="px-4 py-3">Invitee</th>
                        <th class="px-4 py-3">Game Won By Timeout</th>
                        <th class="px-4 py-3">Started At</th>
                        <th class="px-4 py-3">Ended At</th>
                        <th class="px-4 py-3">
                            <span class="sr-only">Actions</span>
                        </th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($gameSessions as $gameSession)
                        @php
                            $inviterIsWinner = $gameSession->inviter_id == $gameSession->winner_id;
                            $inviteeIsWinner = $gameSession->invitee_id == $gameSession->winner_id;

                            $inviterStatusLabel = $inviterIsWinner ? ' (🏆 Winner)' : ' (❌ Loser)';
                            $inviteeStatusLabel = $inviteeIsWinner ? ' (🏆 Winner)' : ' (❌ Loser)';

                            $inviterName = $gameSession->inviter->name . $inviterStatusLabel;
                            $inviteeName = $gameSession->invitee->name . $inviteeStatusLabel;
                        @endphp

                        <tr
                            class="transition duration-300 
                                   bg-black/60 border-b border-red-500/20 
                                   hover:bg-red-900/20 hover:shadow-xl">
                            <td
                                class="px-4 py-3 font-medium 
                                @if ($inviterIsWinner) text-green-400 font-bold @else text-red-300 @endif">
                                {{ $inviterName }}
                            </td>

                            <td
                                class="px-4 py-3 font-medium 
                                @if ($inviteeIsWinner) text-green-400 font-bold @else text-red-300 @endif">
                                {{ $inviteeName }}
                            </td>

                            <td class="px-4 py-3">
                                <span
                                    class="font-medium 
                                    @if ($gameSession->game_won_by_timeout) text-red-400 @else text-green-400 @endif">
                                    {{ $gameSession->game_won_by_timeout ? 'Yes' : 'No' }}
                                </span>
                            </td>

                            <td class="px-4 py-3 text-red-300">
                                {{ $gameSession->created_at->format('d M Y h:i:s A') }}
                            </td>

                            <td class="px-4 py-3 text-red-300">
                                {{ $gameSession->ended_at?->format('d M Y h:i:s A') ?? '—' }}
                            </td>
                        </tr>
                    @endforeach

                    @if (count($gameSessions) === 0)
                        <tr>
                            <td colspan="6" class="px-4 py-6 text-center text-red-300/70">
                                No game sessions found.
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <!-- FOOTER -->
        <div
            class="py-4 px-4 border-t border-red-500/30 
                    flex flex-col md:flex-row justify-between items-center 
                    space-y-3 md:space-y-0 bg-black/60">

            <div class="flex space-x-4 items-center w-full md:w-auto">
                <label for="per-page-select" class="text-sm font-medium text-red-300 whitespace-nowrap">
                    Show Per Page:
                </label>

                <select id="per-page-select"
                    class="bg-black/40 border border-red-500/40 text-red-200 text-sm 
                           rounded-lg focus:ring-red-500 focus:border-red-500 p-2"
                           wire:model.live="perPage">
                    <option value="5">5</option>
                    <option value="10" selected>10</option>
                    <option value="20">20</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </div>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $gameSessions->links() }}
            </div>

        </div>

    </div>
</div>
