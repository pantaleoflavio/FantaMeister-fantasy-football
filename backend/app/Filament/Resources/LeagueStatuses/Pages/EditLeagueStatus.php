<?php

namespace App\Filament\Resources\LeagueStatuses\Pages;

use App\Filament\Resources\LeagueStatuses\LeagueStatusResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditLeagueStatus extends EditRecord
{
    protected static string $resource = LeagueStatusResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
