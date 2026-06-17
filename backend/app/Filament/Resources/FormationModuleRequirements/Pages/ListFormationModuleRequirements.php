<?php

namespace App\Filament\Resources\FormationModuleRequirements\Pages;

use App\Filament\Resources\FormationModuleRequirements\FormationModuleRequirementResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListFormationModuleRequirements extends ListRecords
{
    protected static string $resource = FormationModuleRequirementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
