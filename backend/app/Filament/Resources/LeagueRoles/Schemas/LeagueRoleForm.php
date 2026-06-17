<?php

namespace App\Filament\Resources\LeagueRoles\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class LeagueRoleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('key')
                    ->required(),
                TextInput::make('label')
                    ->required(),
            ]);
    }
}
