<?php

namespace App\Filament\Resources\FormationModuleRequirements\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class FormationModuleRequirementForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('formation_module_id')
                    ->relationship('formationModule', 'name')
                    ->required(),
                Select::make('player_role_id')
                    ->relationship('playerRole', 'id')
                    ->required(),
                TextInput::make('required_count')
                    ->required()
                    ->numeric(),
            ]);
    }
}
