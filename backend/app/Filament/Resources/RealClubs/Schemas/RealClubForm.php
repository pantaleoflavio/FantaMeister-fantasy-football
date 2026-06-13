<?php

namespace App\Filament\Resources\RealClubs\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class RealClubForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('short_name')
                    ->required(),
                TextInput::make('slug')
                    ->required(),
                TextInput::make('country_code'),
                TextInput::make('logo_path'),
            ]);
    }
}
