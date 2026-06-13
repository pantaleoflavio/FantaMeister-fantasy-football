<?php

namespace App\Filament\Resources\PlayerSeasonRegistrations;

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
    protected static ?string $modelLabel = 'Player Registration';

    protected static ?string $pluralModelLabel = 'Player Registrations';

    protected static ?string $recordTitleAttribute = 'player.display_name';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('player_id')->label('Player')->relationship('player', 'display_name')->searchable()->preload()->required(),
            Select::make('season_club_id')->label('Registered club')->relationship('seasonClub', 'id')->getOptionLabelFromRecordUsing(fn ($record): string => "{$record->season->realCompetition->name} — {$record->season->name} — {$record->realClub->name}")->searchable()->preload()->required(),
            Select::make('player_role_id')->label('Player role')->relationship('playerRole', 'label')->searchable()->preload()->required(),
            TextInput::make('external_provider')->label('External provider'), TextInput::make('external_id')->label('External ID'),
            TextInput::make('shirt_number')->label('Shirt number')->numeric(), TextInput::make('quotation')->label('Quotation')->numeric(),
            Toggle::make('is_active')->label('Active')->default(true), DateTimePicker::make('registered_at')->label('Registered at'), DateTimePicker::make('released_at')->label('Released at'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('player.display_name')->label('Player')->searchable()->sortable(), TextColumn::make('seasonClub.season.realCompetition.name')->label('Competition'),
            TextColumn::make('seasonClub.season.name')->label('Season'), TextColumn::make('seasonClub.realClub.name')->label('Registered club'), TextColumn::make('playerRole.label')->label('Role'),
            TextColumn::make('quotation')->label('Quotation')->numeric(2), IconColumn::make('is_active')->label('Active')->boolean(),
        ])->recordActions([EditAction::make()])->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
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
