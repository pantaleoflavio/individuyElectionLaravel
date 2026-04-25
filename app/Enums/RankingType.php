<?php

namespace App\Enums;

enum RankingType: string
{
    case Wrestler = 'wrestler';
    case TagTeam = 'tag team';
    case Federation = 'federation';

    public static function values(): array
    {
        return array_map(static fn (self $type) => $type->value, self::cases());
    }
}