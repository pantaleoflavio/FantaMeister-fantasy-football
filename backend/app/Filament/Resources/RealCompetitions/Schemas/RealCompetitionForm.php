<?php

namespace App\Filament\Resources\RealCompetitions\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class RealCompetitionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('code')
                    ->required(),
                TextInput::make('country_code'),
                TextInput::make('type')
                    ->required(),
                Toggle::make('is_active')
                    ->required(),
            ]);
    }
}
