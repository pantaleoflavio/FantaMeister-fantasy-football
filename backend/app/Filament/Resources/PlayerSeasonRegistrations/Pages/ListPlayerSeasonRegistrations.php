<?php

namespace App\Filament\Resources\PlayerSeasonRegistrations\Pages;

use App\Filament\Resources\PlayerSeasonRegistrations\PlayerSeasonRegistrationResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPlayerSeasonRegistrations extends ListRecords
{
    protected static string $resource = PlayerSeasonRegistrationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
