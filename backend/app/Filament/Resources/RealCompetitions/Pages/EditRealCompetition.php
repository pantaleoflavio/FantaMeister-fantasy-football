<?php

namespace App\Filament\Resources\RealCompetitions\Pages;

use App\Filament\Resources\RealCompetitions\RealCompetitionResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditRealCompetition extends EditRecord
{
    protected static string $resource = RealCompetitionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
