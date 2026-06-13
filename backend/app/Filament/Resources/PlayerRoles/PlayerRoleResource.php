<?php

namespace App\Filament\Resources\PlayerRoles;

use App\Models\PlayerRole;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PlayerRoleResource extends Resource
{
    protected static ?string $model = PlayerRole::class;

    protected static string|\UnitEnum|null $navigationGroup = 'Lookups';

    protected static ?string $navigationLabel = 'Player Roles';

    protected static ?string $recordTitleAttribute = 'label';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('key')->label('Key')->required()->unique(ignoreRecord: true),
            TextInput::make('label')->label('Label')->required(),
            TextInput::make('sort_order')->label('Sort order')->numeric(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('key')->label('Key')->searchable()->sortable(),
                TextColumn::make('label')->label('Label')->searchable()->sortable(),
                TextColumn::make('sort_order')->label('Sort Order')->searchable()->sortable(),
            ])
            ->recordActions([EditAction::make()])
            ->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPlayerRoles::route('/'),
            'create' => Pages\CreatePlayerRole::route('/create'),
            'edit' => Pages\EditPlayerRole::route('/{record}/edit'),
        ];
    }
}
