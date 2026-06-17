<?php

namespace App\Filament\Resources\RealCompetitions\Pages;

use App\Filament\Resources\RealCompetitions\RealCompetitionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListRealCompetitions extends ListRecords
{
    protected static string $resource = RealCompetitionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
