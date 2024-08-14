<?php

namespace App\Enums;

enum DelayedOrderStatus: string
{
    case ASSIGNED = 'ASSIGNED';
    case Done = 'DONE';
    case WITHOUT_OWNER = 'WITHOUT_OWNER';

    public function label(): string
    {
        return match($this) {
            self::ASSIGNED => 'Assigned',
            self::Done => 'Done',
            self::WITHOUT_OWNER => 'Without owner',
        };
    }
}
