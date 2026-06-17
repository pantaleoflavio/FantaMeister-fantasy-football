<?php

namespace App\Filament\Resources\LeagueStatuses\Pages;

use App\Filament\Resources\LeagueStatuses\LeagueStatusResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListLeagueStatuses extends ListRecords
{
    protected static string $resource = LeagueStatusResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
