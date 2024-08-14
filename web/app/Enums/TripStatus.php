<?php

namespace App\Enums;

enum TripStatus: string
{
    case ASSIGNED = 'ASSIGNED';
    case AT_VENDOR = 'AT_VENDOR';
    case PICKED = 'PICKED';
    case DELIVERED = 'DELIVERED';

    public function label(): string
    {
        return match ($this) {
            self::ASSIGNED => 'Assigned',
            self::AT_VENDOR => 'At_vendor',
            self::PICKED => 'Picked',
            self::DELIVERED => 'Delivered',
        };
    }
}

