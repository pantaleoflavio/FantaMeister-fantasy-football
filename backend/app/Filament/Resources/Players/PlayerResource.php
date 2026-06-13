<?php

namespace App\Filament\Resources\Players;

use App\Models\Player;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PlayerResource extends Resource
{
    protected static ?string $model = Player::class;

    protected static string|\UnitEnum|null $navigationGroup = 'Real Data';

    protected static ?string $navigationLabel = 'Players';

    protected static ?string $recordTitleAttribute = 'display_name';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('external_id')->label('External ID'),
            TextInput::make('first_name')->label('First name'),
            TextInput::make('last_name')->label('Last name'),
            TextInput::make('display_name')->label('Display name')->required(),
            TextInput::make('slug')->label('Slug')->required()->unique(ignoreRecord: true),
            DatePicker::make('birth_date')->label('Birth date'),
            Toggle::make('is_active')->label('Active')->default(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('display_name')->label('Display Name')->searchable()->sortable(),
                TextColumn::make('first_name')->label('First Name')->searchable()->sortable(),
                TextColumn::make('last_name')->label('Last Name')->searchable()->sortable(),
                TextColumn::make('external_id')->label('External Id')->searchable()->sortable(),
                TextColumn::make('birth_date')->label('Birth Date')->dateTime()->sortable(),
                IconColumn::make('is_active')->boolean(),
            ])
            ->recordActions([EditAction::make()])
            ->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPlayers::route('/'),
            'create' => Pages\CreatePlayer::route('/create'),
            'edit' => Pages\EditPlayer::route('/{record}/edit'),
        ];
    }
}
