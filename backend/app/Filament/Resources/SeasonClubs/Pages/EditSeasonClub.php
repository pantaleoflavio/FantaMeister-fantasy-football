<?php

namespace App\Filament\Resources\SeasonClubs\Pages;

use App\Filament\Resources\SeasonClubs\SeasonClubResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSeasonClub extends EditRecord
{
    protected static string $resource = SeasonClubResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
