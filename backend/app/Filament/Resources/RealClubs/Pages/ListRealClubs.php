<?php

namespace App\Filament\Resources\RealClubs\Pages;

use App\Filament\Resources\RealClubs\RealClubResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListRealClubs extends ListRecords
{
    protected static string $resource = RealClubResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
