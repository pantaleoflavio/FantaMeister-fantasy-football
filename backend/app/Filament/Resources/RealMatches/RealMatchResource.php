<?php

namespace App\Filament\Resources\RealMatches;

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
            Select::make('home_season_club_id')->label('Home season club')->relationship('homeSeasonClub', 'display_name')->searchable()->preload()->required(),
            Select::make('away_season_club_id')->label('Away season club')->relationship('awaySeasonClub', 'display_name')->searchable()->preload()->required(),
            DateTimePicker::make('kickoff_at')->label('Kickoff at')->required(),
            TextInput::make('home_score')->label('Home score')->numeric(),
            TextInput::make('away_score')->label('Away score')->numeric(),
            TextInput::make('status')->label('Status')->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('matchday.name')->label('Name')->searchable()->sortable(),
                TextColumn::make('homeSeasonClub.display_name')->label('Display Name')->searchable()->sortable(),
                TextColumn::make('awaySeasonClub.display_name')->label('Display Name')->searchable()->sortable(),
                TextColumn::make('kickoff_at')->label('Kickoff At')->dateTime()->sortable(),
                TextColumn::make('home_score')->label('Home Score')->searchable()->sortable(),
                TextColumn::make('away_score')->label('Away Score')->searchable()->sortable(),
                TextColumn::make('status')->label('Status')->searchable()->sortable(),
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
