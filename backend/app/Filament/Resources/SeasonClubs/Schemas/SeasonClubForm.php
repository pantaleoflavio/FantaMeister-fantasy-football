<?php

namespace App\Filament\Resources\SeasonClubs\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class SeasonClubForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('season_id')
                    ->relationship('season', 'name')
                    ->required(),
                Select::make('real_club_id')
                    ->relationship('realClub', 'name')
                    ->required(),
                TextInput::make('display_name'),
                TextInput::make('external_id'),
                Toggle::make('is_active')
                    ->required(),
            ]);
    }
}
