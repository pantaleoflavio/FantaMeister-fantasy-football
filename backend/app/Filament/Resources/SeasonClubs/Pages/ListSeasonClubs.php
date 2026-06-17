<?php

namespace App\Filament\Resources\SeasonClubs\Pages;

use App\Filament\Resources\SeasonClubs\SeasonClubResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSeasonClubs extends ListRecords
{
    protected static string $resource = SeasonClubResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
