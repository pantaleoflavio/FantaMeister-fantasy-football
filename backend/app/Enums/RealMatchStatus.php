<?php

namespace App\Enums;

enum RealMatchStatus: string
{
    case Scheduled = 'scheduled';
    case InProgress = 'in_progress';
    case Finished = 'finished';
    case Postponed = 'postponed';
    case Cancelled = 'cancelled';

    public function label(): string
    {
        return __("admin.enums.real_match_status.{$this->value}");
    }

    public static function options(): array
    {
        return collect(self::cases())->mapWithKeys(fn (self $status): array => [$status->value => $status->label()])->all();
    }
}
