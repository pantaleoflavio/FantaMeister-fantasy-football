<?php

namespace App\Filament\Resources\PlayerRoles\Pages;

use App\Filament\Resources\PlayerRoles\PlayerRoleResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPlayerRole extends EditRecord
{
    protected static string $resource = PlayerRoleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
