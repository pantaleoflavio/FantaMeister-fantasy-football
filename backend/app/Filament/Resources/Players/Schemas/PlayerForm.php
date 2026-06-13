<?php

namespace App\Filament\Resources\Players\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class PlayerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('external_id'),
                TextInput::make('first_name'),
                TextInput::make('last_name'),
                TextInput::make('display_name')
                    ->required(),
                TextInput::make('slug')
                    ->required(),
                DatePicker::make('birth_date'),
                Toggle::make('is_active')
                    ->required(),
            ]);
    }
}
