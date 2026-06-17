<?php

namespace App\Filament\Resources\RealMatches\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class RealMatchForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('matchday_id')
                    ->relationship('matchday', 'name')
                    ->required(),
                Select::make('home_season_club_id')
                    ->relationship('homeSeasonClub', 'id')
                    ->required(),
                Select::make('away_season_club_id')
                    ->relationship('awaySeasonClub', 'id')
                    ->required(),
                DateTimePicker::make('kickoff_at')
                    ->required(),
                TextInput::make('home_score')
                    ->numeric(),
                TextInput::make('away_score')
                    ->numeric(),
                TextInput::make('status')
                    ->required()
                    ->default('scheduled'),
            ]);
    }
}
