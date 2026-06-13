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
        return __("admin.enums.competition_type.{$this->value}");
    }

    public static function options(): array
    {
        return collect(self::cases())->mapWithKeys(fn (self $type): array => [$type->value => $type->label()])->all();
    }
}
