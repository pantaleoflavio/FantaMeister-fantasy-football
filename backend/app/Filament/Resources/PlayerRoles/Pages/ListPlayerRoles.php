<?php

namespace App\Filament\Resources\PlayerRoles\Pages;

use App\Filament\Resources\PlayerRoles\PlayerRoleResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPlayerRoles extends ListRecords
{
    protected static string $resource = PlayerRoleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
