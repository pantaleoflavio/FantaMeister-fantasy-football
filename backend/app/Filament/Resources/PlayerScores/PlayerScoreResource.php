<?php

namespace App\Filament\Resources\PlayerScores;

use App\Models\PlayerScore;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PlayerScoreResource extends Resource
{
    protected static ?string $model = PlayerScore::class;

    protected static string|\UnitEnum|null $navigationGroup = 'Scores';

    protected static ?string $navigationLabel = 'Player Scores';

    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('matchday_id')->label('Matchday')->relationship('matchday', 'name')->searchable()->preload()->required(),
            Select::make('player_season_registration_id')->label('Player registration')->relationship('playerSeasonRegistration', 'id')->searchable()->preload()->required(),
            TextInput::make('base_rating')->label('Base rating')->numeric(),
            TextInput::make('goals')->label('Goals')->numeric(),
            TextInput::make('assists')->label('Assists')->numeric(),
            TextInput::make('yellow_cards')->label('Yellow cards')->numeric(),
            TextInput::make('red_cards')->label('Red cards')->numeric(),
            TextInput::make('own_goals')->label('Own goals')->numeric(),
            TextInput::make('penalties_scored')->label('Penalties scored')->numeric(),
            TextInput::make('penalties_missed')->label('Penalties missed')->numeric(),
            TextInput::make('penalties_saved')->label('Penalties saved')->numeric(),
            TextInput::make('goals_conceded')->label('Goals conceded')->numeric(),
            Toggle::make('clean_sheet')->label('Clean sheet')->default(false),
            TextInput::make('final_score')->label('Final score')->numeric(),
            TextInput::make('status')->label('Status')->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('matchday.name')->label('Name')->searchable()->sortable(),
                TextColumn::make('playerSeasonRegistration.player.display_name')->label('Display Name')->searchable()->sortable(),
                TextColumn::make('base_rating')->label('Base Rating')->searchable()->sortable(),
                TextColumn::make('final_score')->label('Final Score')->searchable()->sortable(),
                TextColumn::make('status')->label('Status')->searchable()->sortable(),
            ])
            ->recordActions([EditAction::make()])
            ->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPlayerScores::route('/'),
            'create' => Pages\CreatePlayerScore::route('/create'),
            'edit' => Pages\EditPlayerScore::route('/{record}/edit'),
        ];
    }
}
