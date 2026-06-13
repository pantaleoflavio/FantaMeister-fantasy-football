<?php

namespace App\Filament\Resources\RealMatches\Pages;

use App\Filament\Resources\RealMatches\RealMatchResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditRealMatch extends EditRecord
{
    protected static string $resource = RealMatchResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
