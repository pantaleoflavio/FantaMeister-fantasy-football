<?php

namespace App\Filament\Resources\RealMatches\Pages;

use App\Filament\Resources\RealMatches\RealMatchResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListRealMatches extends ListRecords
{
    protected static string $resource = RealMatchResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
