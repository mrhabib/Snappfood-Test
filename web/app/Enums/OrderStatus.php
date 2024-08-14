<?php

namespace App\Enums;

enum OrderStatus: string
{
    case WAITING = 'WAITING';
    case ACCEPTED = 'ACCEPTED';
    case REJECTED = 'REJECTED';
    case DELIVERED = 'DELIVERED';
    case DELAYED = 'DELAYED';
    case ON_THE_WAY = 'ON_THE_WAY';

    public function label(): string
    {
        return match ($this) {
            self::WAITING => 'Waiting',
            self::ACCEPTED => 'Accepted',
            self::REJECTED => 'Rejected',
            self::DELIVERED => 'Delivered',
            self::DELAYED => 'Delayed',
            self::ON_THE_WAY => 'On_the_way',
        };
    }
}

