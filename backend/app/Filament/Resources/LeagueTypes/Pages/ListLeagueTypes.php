<?php

namespace App\Filament\Resources\LeagueTypes\Pages;

use App\Filament\Resources\LeagueTypes\LeagueTypeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListLeagueTypes extends ListRecords
{
    protected static string $resource = LeagueTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
