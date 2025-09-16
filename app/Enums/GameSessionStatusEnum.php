<?php



namespace App\Enums;



enum GameSessionStatusEnum: string
{

    case Pending = 'pending';

    case Active = 'active';

    case Completed = 'completed';

    case Abandoned = 'abandoned';

    case Cancelled = 'cancelled';
}