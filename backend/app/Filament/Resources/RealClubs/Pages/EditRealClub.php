<?php

namespace App\Filament\Resources\RealClubs\Pages;

use App\Filament\Resources\RealClubs\RealClubResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditRealClub extends EditRecord
{
    protected static string $resource = RealClubResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
