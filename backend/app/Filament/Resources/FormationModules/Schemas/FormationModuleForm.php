<?php

namespace App\Filament\Resources\FormationModules\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class FormationModuleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('label')
                    ->required(),
                Toggle::make('is_active')
                    ->required(),
            ]);
    }
}
