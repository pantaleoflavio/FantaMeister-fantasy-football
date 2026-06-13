<?php

namespace App\Enums;

enum CompetitionType: string
{
    case DomesticLeague = 'domestic_league';
    case DomesticCup = 'domestic_cup';
    case InternationalClub = 'international_club';
    case Custom = 'custom';

    public function label(): string
    {
        return match ($this) {
            self::DomesticLeague => 'Domestic league',
            self::DomesticCup => 'Domestic cup',
            self::InternationalClub => 'International club',
            self::Custom => 'Custom',
        };
    }

    public static function options(): array
    {
        return collect(self::cases())->mapWithKeys(fn (self $type): array => [$type->value => $type->label()])->all();
    }
}
