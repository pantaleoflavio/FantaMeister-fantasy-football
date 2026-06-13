<?php

namespace App\Filament\Resources\PlayerSeasonRegistrations;

use App\Models\PlayerSeasonRegistration;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PlayerSeasonRegistrationResource extends Resource
{
    protected static ?string $model = PlayerSeasonRegistration::class;

    protected static string|\UnitEnum|null $navigationGroup = 'Real Data';

    protected static ?string $navigationLabel = 'Player Registrations';

    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('player_id')->label('Player')->relationship('player', 'display_name')->searchable()->preload()->required(),
            Select::make('season_id')->label('Season')->relationship('season', 'name')->searchable()->preload()->required(),
            Select::make('real_club_id')->label('Real club')->relationship('realClub', 'name')->searchable()->preload()->required(),
            TextInput::make('external_id')->label('External ID'),
            TextInput::make('shirt_number')->label('Shirt number')->numeric(),
            TextInput::make('quotation')->label('Quotation')->numeric(),
            Toggle::make('is_active')->label('Active')->default(true),
            DateTimePicker::make('registered_at')->label('Registered at'),
            DateTimePicker::make('released_at')->label('Released at'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('player.display_name')->label('Display Name')->searchable()->sortable(),
                TextColumn::make('season.name')->label('Name')->searchable()->sortable(),
                TextColumn::make('realClub.name')->label('Name')->searchable()->sortable(),
                TextColumn::make('shirt_number')->label('Shirt Number')->searchable()->sortable(),
                TextColumn::make('quotation')->label('Quotation')->searchable()->sortable(),
                IconColumn::make('is_active')->boolean(),
            ])
            ->recordActions([EditAction::make()])
            ->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPlayerSeasonRegistrations::route('/'),
            'create' => Pages\CreatePlayerSeasonRegistration::route('/create'),
            'edit' => Pages\EditPlayerSeasonRegistration::route('/{record}/edit'),
        ];
    }
}
