<?php

namespace App\Filament\Resources\LeagueRoles\Pages;

use App\Filament\Resources\LeagueRoles\LeagueRoleResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditLeagueRole extends EditRecord
{
    protected static string $resource = LeagueRoleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
