<?php

namespace App\Filament\Resources\Matchdays;

use App\Models\Matchday;
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

class MatchdayResource extends Resource
{
    protected static ?string $model = Matchday::class;

    protected static string|\UnitEnum|null $navigationGroup = 'Real Data';

    protected static ?string $navigationLabel = 'Matchdays';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('season_id')->label('Season')->relationship('season', 'name')->searchable()->preload()->required(),
            TextInput::make('number')->label('Matchday number')->numeric()->required(),
            TextInput::make('name')->label('Round name'),
            DateTimePicker::make('starts_at')->label('Starts at')->required(),
            DateTimePicker::make('ends_at')->label('Ends at')->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('season.realCompetition.name')->label('Competition')->searchable()->sortable(),
                TextColumn::make('season.name')->label('Season')->searchable()->sortable(),
                TextColumn::make('number')->label('Matchday number')->searchable()->sortable(),
                TextColumn::make('name')->label('Round name')->searchable()->sortable(),
                TextColumn::make('starts_at')->label('Starts At')->dateTime()->sortable(),
                TextColumn::make('ends_at')->label('Ends At')->dateTime()->sortable(),
            ])
            ->recordActions([EditAction::make()])
            ->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMatchdays::route('/'),
            'create' => Pages\CreateMatchday::route('/create'),
            'edit' => Pages\EditMatchday::route('/{record}/edit'),
        ];
    }
}
