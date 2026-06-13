<?php

namespace App\Filament\Resources\PlayerScores\Pages;

use App\Filament\Resources\PlayerScores\PlayerScoreResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPlayerScores extends ListRecords
{
    protected static string $resource = PlayerScoreResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
