<?php

namespace App\Filament\Resources\RealMatches;

use App\Enums\RealMatchStatus;
use App\Filament\Resources\RealMatches\Pages\CreateRealMatch;
use App\Filament\Resources\RealMatches\Pages\EditRealMatch;
use App\Filament\Resources\RealMatches\Pages\ListRealMatches;
use App\Models\RealMatch;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class RealMatchResource extends Resource
{
    protected static ?string $model = RealMatch::class;

    protected static string|\UnitEnum|null $navigationGroup = 'Real Data';

    protected static ?string $navigationLabel = 'Real Matches';

    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('matchday_id')->label('Matchday')->relationship('matchday', 'name')->searchable()->preload()->required(),
            Select::make('home_season_club_id')->label('Home club')->relationship('homeSeasonClub', 'realClub.name')->searchable()->preload()->required(),
            Select::make('away_season_club_id')->label('Away club')->relationship('awaySeasonClub', 'realClub.name')->searchable()->preload()->required(),
            DateTimePicker::make('kickoff_at')->label('Kick-off')->required(),
            TextInput::make('home_score')->label('Home score')->numeric(),
            TextInput::make('away_score')->label('Away score')->numeric(),
            Select::make('status')->label('Match status')->options(RealMatchStatus::options())->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('matchday.season.realCompetition.name')->label('Competition'),
                TextColumn::make('matchday.season.name')->label('Season'),
                TextColumn::make('matchday.name')->label('Matchday')->searchable()->sortable(),
                TextColumn::make('homeSeasonClub.realClub.name')->label('Home club')->searchable()->sortable(),
                TextColumn::make('awaySeasonClub.realClub.name')->label('Away club')->searchable()->sortable(),
                TextColumn::make('kickoff_at')->label('Kickoff At')->dateTime()->sortable(),
                TextColumn::make('home_score')->label('Home Score')->searchable()->sortable(),
                TextColumn::make('away_score')->label('Away Score')->searchable()->sortable(),
                TextColumn::make('status')->label('Match status')->searchable()->sortable(),
            ])
            ->recordActions([EditAction::make()])
            ->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListRealMatches::route('/'),
            'create' => CreateRealMatch::route('/create'),
            'edit' => EditRealMatch::route('/{record}/edit'),
        ];
    }
}
