<div class="mx-auto max-w-screen-xl px-4 lg:px-12">
    <div class="bg-white dark:bg-gray-800 relative shadow-lg sm:rounded-xl overflow-hidden">
        <div
            class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4 border-b dark:border-gray-700">
            <div class="w-full md:w-1/2">
                <form class="flex items-center">
                    <label for="simple-search" class="sr-only">Search</label>
                    <div class="relative w-full">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor"
                                viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <input type="text" id="simple-search" wire:model.live.debounce.500ms="search"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            placeholder="Search game sessions" required="">
                    </div>
                </form>
            </div>

        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-4 py-3 font-semibold tracking-wider">Inviter</th>
                        <th scope="col" class="px-4 py-3 font-semibold tracking-wider">Invitee</th>
                        <th scope="col" class="px-4 py-3 font-semibold tracking-wider">Game Won By Timeout</th>
                        <th scope="col" class="px-4 py-3 font-semibold tracking-wider">Started At</th>
                        <th scope="col" class="px-4 py-3 font-semibold tracking-wider">Ended At</th>
                        <th scope="col" class="px-4 py-3">
                            <span class="sr-only">Actions</span>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($gameSessions as $gameSession)
                        <tr
                            class="border-b dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50 transition duration-150 ease-in-out">

                            @php
                                // Determine Status
                                $inviterIsWinner = $gameSession->inviter_id == $gameSession->winner_id;
                                $inviteeIsWinner = $gameSession->invitee_id == $gameSession->winner_id;

                                // Status Labels
                                $inviterStatusLabel = $inviterIsWinner ? ' (🏆 Winner)' : ' (❌ Loser)';
                                $inviteeStatusLabel = $inviteeIsWinner ? ' (🏆 Winner)' : ' (❌ Loser)';

                                // Full Names with Status
                                $inviterName = $gameSession->inviter->name . $inviterStatusLabel;
                                $inviteeName = $gameSession->invitee->name . $inviteeStatusLabel;
                            @endphp

                            <td
                                class="px-4 py-3 font-medium whitespace-nowrap 
                                @if ($inviterIsWinner) font-bold text-green-600 dark:text-green-400 
                                @else 
                                    text-gray-700 dark:text-gray-300 @endif">
                                {{ $inviterName }}
                            </td>

                            <td
                                class="px-4 py-3 font-medium whitespace-nowrap 
                                @if ($inviteeIsWinner) font-bold text-green-600 dark:text-green-400 
                                @else 
                                    text-gray-700 dark:text-gray-300 @endif">
                                {{ $inviteeName }}
                            </td>

                            <td class="px-4 py-3">
                                <span
                                    class="font-medium 
                                    @if ($gameSession->game_won_by_timeout) text-red-600 dark:text-red-400 
                                    @else 
                                        text-green-600 dark:text-green-400 @endif">
                                    {{ $gameSession->game_won_by_timeout ? 'Yes' : 'No' }}
                                </span>
                            </td>

                            <td class="px-4 py-3 text-gray-600 dark:text-gray-300">
                                {{ $gameSession->created_at->format('d M Y h:i:s A') }}
                            </td>

                            <td class="px-4 py-3 text-gray-600 dark:text-gray-300">
                                {{ $gameSession->ended_at?->format('d M Y h:i:s A') ?? '—' }}
                            </td>
                        </tr>
                    @endforeach

                    @if (count($gameSessions) === 0)
                        <tr>
                            <td colspan="6" class="px-4 py-6 text-center text-gray-500 dark:text-gray-400">
                                No game sessions found.
                            </td>
                        </tr>
                    @endif

                </tbody>
            </table>
        </div>

        <div
            class="py-4 px-4 border-t dark:border-gray-700 flex flex-col md:flex-row justify-between items-center space-y-3 md:space-y-0">

            <div class="flex space-x-4 items-center w-full md:w-auto">
                <label for="per-page-select"
                    class="w-45 text-sm font-medium text-gray-700 dark:text-gray-300 whitespace-nowrap">Show Per
                    Page:</label>
                <select id="per-page-select"
                    class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                    <option value="5">5</option>
                    <option value="10" selected>10</option>
                    <option value="20">20</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </div>

            <nav class="flex justify-center items-center space-x-1" aria-label="Table pagination">
                <a href="#"
                    class="flex items-center justify-center h-8 px-3 ml-0 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-lg bg-gray-100 text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:bg-gray-700 dark:text-white">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                            clip-rule="evenodd"></path>
                    </svg>
                    Prev
                </a>
                <a href="#"
                    class="flex items-center justify-center text-sm font-medium text-primary-600 bg-primary-50 border border-primary-300 rounded-lg h-8 px-3 dark:bg-primary-900 dark:border-primary-700 dark:text-white">1</a>
                <a href="#"
                    class="flex items-center justify-center h-8 px-3 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-lg bg-gray-100 text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:bg-gray-700 dark:text-white">2</a>
                <a href="#"
                    class="flex items-center justify-center h-8 px-3 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-lg bg-gray-100 text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:bg-gray-700 dark:text-white">
                    Next
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                            clip-rule="evenodd"></path>
                    </svg>
                </a>
            </nav>

        </div>
    </div>
</div>
