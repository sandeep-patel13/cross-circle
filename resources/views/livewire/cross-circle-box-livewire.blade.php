<div class="relative z-10 rounded-lg shadow-2xl p-6 w-full max-w-md bg-black/80 backdrop-blur-sm border border-red-500/30">

    <div class="grid gap-4 {{ $endGame ? 'hidden' : '' }}">
        @if ($currentMovingPlayer == 'user')
            <flux:callout variant="secondary" icon="information-circle"
                heading="Dear {{ auth()->user()->name }} , This is your Turn." />
        @else
            <flux:callout variant="secondary" icon="information-circle" heading="This is System Turn." />
        @endif
    </div>

    @for ($row = 0; $row < 3; $row++)
        @php
            $col = 0;
        @endphp
        <div
            class="grid grid-cols-3 gap-4 mt-5 {{ $currentMovingPlayer == 'system' || $endGame ? 'disabled fake-disabled' : '' }}">

            <div class="flex items-center justify-center" data-row="{{ $row }}"
                data-col="{{ $col }}">

                @php
                    $conditionedClasses = getConditionedClassesFor_X_and_O(
                        $row,
                        $col,
                        $gameBoard,
                        $currentMovingPlayer,
                        $userSymbol,
                        $systemSymbol,
                    );
                    $xClasses = $conditionedClasses['xClasses'];
                    $oClasses = $conditionedClasses['oClasses'];
                @endphp

                <button type="button"
                    class="
                    {{ $xClasses }}
                     btn-x me-2 mb-2 "
                    wire:click="handleClick({{ $row }}, {{ $col }}, 'X')">X
                </button>
                <button type="button"
                    class="{{ $oClasses }} btn-o me-2 mb-2 "
                    wire:click="handleClick({{ $row }}, {{ $col }}, 'O')">O
                </button>
                @php
                    $col++;
                @endphp
            </div>

            <div class="flex items-center justify-center" data-row="{{ $row }}"
                data-col="{{ $col }}">

                @php
                    $conditionedClasses = getConditionedClassesFor_X_and_O(
                        $row,
                        $col,
                        $gameBoard,
                        $currentMovingPlayer,
                        $userSymbol,
                        $systemSymbol,
                    );
                    $xClasses = $conditionedClasses['xClasses'];
                    $oClasses = $conditionedClasses['oClasses'];
                @endphp

                <button type="button"
                    class="{{ $xClasses }}  btn-x me-2 mb-2 "
                    wire:click="handleClick({{ $row }}, {{ $col }}, 'X')">
                    X
                </button>

                <button type="button"
                    class="{{ $oClasses }}  btn-o  me-2 mb-2 "
                    wire:click="handleClick({{ $row }}, {{ $col }}, 'O')">O
                </button>
                @php
                    $col++;
                @endphp
            </div>

            <div class="flex items-center justify-center" data-row="{{ $row }}"
                data-col="{{ $col }}">

                @php
                    $conditionedClasses = getConditionedClassesFor_X_and_O(
                        $row,
                        $col,
                        $gameBoard,
                        $currentMovingPlayer,
                        $userSymbol,
                        $systemSymbol,
                    );
                    $xClasses = $conditionedClasses['xClasses'];
                    $oClasses = $conditionedClasses['oClasses'];
                @endphp


                <button type="button"
                    class="{{ $xClasses }}  btn-x me-2 mb-2 "
                    wire:click="handleClick({{ $row }}, {{ $col }}, 'X')">X
                </button>

                <button type="button"
                    class="{{ $oClasses }}  btn-o  me-2 mb-2 "
                    wire:click="handleClick({{ $row }}, {{ $col }} , 'O')">O
                </button>
                @php
                    $col++;
                @endphp
            </div>

        </div>
    @endfor

    @if (!$endGame && $currentMovingPlayer == 'system')
        <div x-data x-init="setTimeout(() => $wire.handleSystemClick(), 5000)">
            <p class="text-center text-red-400 mt-4">System is thinking...</p>
        </div>
    @endif

    @if ($endGame)
        <div class="flex justify-center items-center" style="margin-top: 15px;">
            <flux:button class="btn-dark-red" size="sm" variant="primary" onclick="goBack()">Go Back</flux:button>
        </div>
    @endif
</div>