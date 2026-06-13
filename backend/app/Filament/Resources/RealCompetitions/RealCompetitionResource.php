<?php

namespace App\Filament\Resources\RealCompetitions;

use App\Filament\Resources\RealCompetitions\Pages\CreateRealCompetition;
use App\Filament\Resources\RealCompetitions\Pages\EditRealCompetition;
use App\Filament\Resources\RealCompetitions\Pages\ListRealCompetitions;
use App\Models\RealCompetition;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class RealCompetitionResource extends Resource
{
    protected static ?string $model = RealCompetition::class;

    protected static string|\UnitEnum|null $navigationGroup = 'Competitions';

    protected static ?string $navigationLabel = 'Real Competitions';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('name')->label('Name')->required(),
            TextInput::make('code')->label('Code')->required()->unique(ignoreRecord: true),
            TextInput::make('country_code')->label('Country code'),
            TextInput::make('type')->label('Type')->required(),
            Toggle::make('is_active')->label('Active')->default(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Name')->searchable()->sortable(),
                TextColumn::make('code')->label('Code')->searchable()->sortable(),
                TextColumn::make('country_code')->label('Country Code')->searchable()->sortable(),
                TextColumn::make('type')->label('Type')->searchable()->sortable(),
                IconColumn::make('is_active')->boolean(),
            ])
            ->recordActions([EditAction::make()])
            ->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListRealCompetitions::route('/'),
            'create' => CreateRealCompetition::route('/create'),
            'edit' => EditRealCompetition::route('/{record}/edit'),
        ];
    }
}
