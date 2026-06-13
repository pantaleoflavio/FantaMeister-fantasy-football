<?php

namespace App\Filament\Resources\PlayerRoles\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PlayerRoleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('key')
                    ->required(),
                TextInput::make('label')
                    ->required(),
                TextInput::make('sort_order')
                    ->required()
                    ->numeric()
                    ->default(0),
            ]);
    }
}
