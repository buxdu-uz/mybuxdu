<?php

namespace App\Enums;

enum LibBookResourceEnum: string
{
    case VALID      = 'valid';
    case REPAIR_DEMAND       = 'repair_demand';
    case INVALID     = 'invalid';
    case LOSER     = 'loser';
    case DISPOSAL     = 'disposal';

    public function label(): string
    {
        return match ($this) {
            self::VALID               => 'Yaroqli',
            self::REPAIR_DEMAND       => 'Tamir talab',
            self::INVALID             => 'Yaroqsiz',
            self::LOSER               => 'Yo`qolgan ',
            self::DISPOSAL            => 'Utilizatsiya '
        };
    }
}
