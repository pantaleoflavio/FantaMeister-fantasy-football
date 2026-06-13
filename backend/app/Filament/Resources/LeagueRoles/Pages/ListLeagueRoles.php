<?php

namespace App\Filament\Resources\LeagueRoles\Pages;

use App\Filament\Resources\LeagueRoles\LeagueRoleResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListLeagueRoles extends ListRecords
{
    protected static string $resource = LeagueRoleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
