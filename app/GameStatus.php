<?php

namespace App;

enum GameStatus
{
    case PENDING;
    case COMPLETED;

    public function getValue(): string
    {
        return match ($this) {
            self::PENDING => 'Pending',
            self::COMPLETED => 'Completed',
        };
    }
}
