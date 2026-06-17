<?php

namespace App\Filament\Resources\PlayerSeasonRegistrations\Pages;

use App\Filament\Resources\PlayerSeasonRegistrations\PlayerSeasonRegistrationResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPlayerSeasonRegistration extends EditRecord
{
    protected static string $resource = PlayerSeasonRegistrationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
