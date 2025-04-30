<?php


if (!function_exists('getConditionedClassesFor_X_and_O')) {
    function getConditionedClassesFor_X_and_O(
        $row,
        $column,
        $gameBoard,
        $currentMovingPlayer,
        $userSymbol,
        $systemSymbol
    ) {
        $xClasses = '';
        $oClasses = '';
        $selectedSymbol = $gameBoard[$row][$column];
        $currentMovingPlayerSymbol = $currentMovingPlayer != null ? ($currentMovingPlayer == 'user' ? $userSymbol : $systemSymbol) : null;
        if ($selectedSymbol != null) { // If any symbol is selected
            if ($selectedSymbol == 'X') { // If X is selected
                $xClasses = 'disabled fake-disabled'; // Show X but make it disabled
                $oClasses = 'hidden'; // Hide O
            } else { // If O is selected
                $oClasses = 'disabled fake-disabled'; // Show O but make it diabled 
                $xClasses = 'hidden'; // Hide X
            }
        } else {
            if ($currentMovingPlayerSymbol != null) { // If current moving player exists
                if ($currentMovingPlayerSymbol == 'X') { // If current moving player symbol is X 
                    $oClasses = 'hidden'; // So hide O
                } else {
                    $xClasses = 'hidden'; // Otherwise hide X
                }
            }
        }
        return [
            'xClasses' => $xClasses,
            'oClasses' => $oClasses
        ];
    }
}