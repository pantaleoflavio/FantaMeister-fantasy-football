<?php

namespace App\Filament\Resources\RealClubs;

use App\Filament\Resources\RealClubs\Pages\CreateRealClub;
use App\Filament\Resources\RealClubs\Pages\EditRealClub;
use App\Filament\Resources\RealClubs\Pages\ListRealClubs;
use App\Models\RealClub;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class RealClubResource extends Resource
{
    protected static ?string $model = RealClub::class;

    protected static string|\UnitEnum|null $navigationGroup = 'Real Data';

    protected static ?string $navigationLabel = 'Real Clubs';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('name')->label('Club Name')->required(),
            TextInput::make('short_name')->label('Short Name')->required(),
            TextInput::make('slug')->label('Slug')->required()->unique(ignoreRecord: true)->dehydrateStateUsing(fn (string $state): string => str($state)->slug()->lower()->toString()),
            TextInput::make('country_code')->label('Country')->length(2)->alpha()->dehydrateStateUsing(fn (?string $state): ?string => $state ? strtoupper($state) : null),
            TextInput::make('logo_path')->label('Logo path'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Club name')->searchable()->sortable(),
                TextColumn::make('short_name')->label('Short Name')->searchable()->sortable(),
                TextColumn::make('slug')->label('Slug')->searchable()->sortable(),
                TextColumn::make('country_code')->label('Country Code')->searchable()->sortable(),
            ])
            ->recordActions([EditAction::make()])
            ->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListRealClubs::route('/'),
            'create' => CreateRealClub::route('/create'),
            'edit' => EditRealClub::route('/{record}/edit'),
        ];
    }
}
