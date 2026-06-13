<?php

namespace App\Filament\Resources\LeagueTypes\Pages;

use App\Filament\Resources\LeagueTypes\LeagueTypeResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditLeagueType extends EditRecord
{
    protected static string $resource = LeagueTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
