<?php

namespace App\Filament\Resources\FormationModuleRequirements\Pages;

use App\Filament\Resources\FormationModuleRequirements\FormationModuleRequirementResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditFormationModuleRequirement extends EditRecord
{
    protected static string $resource = FormationModuleRequirementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
