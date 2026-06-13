<?php

namespace App\Filament\Resources\PlayerScores\Pages;

use App\Filament\Resources\PlayerScores\PlayerScoreResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPlayerScore extends EditRecord
{
    protected static string $resource = PlayerScoreResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
