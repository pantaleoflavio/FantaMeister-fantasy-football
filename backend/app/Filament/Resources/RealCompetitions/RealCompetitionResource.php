<?php

namespace App\Filament\Resources\RealCompetitions;

use App\Enums\CompetitionType;
use App\Filament\Resources\RealCompetitions\Pages\CreateRealCompetition;
use App\Filament\Resources\RealCompetitions\Pages\EditRealCompetition;
use App\Filament\Resources\RealCompetitions\Pages\ListRealCompetitions;
use App\Models\RealCompetition;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
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
            TextInput::make('name')->label('Competition name')->required(),
            TextInput::make('code')->label('Competition code')->required()->unique(ignoreRecord: true)->dehydrateStateUsing(fn (string $state): string => str($state)->slug('_')->lower()->toString()),
            TextInput::make('country_code')->label('Country')->length(2)->alpha()->dehydrateStateUsing(fn (?string $state): ?string => $state ? strtoupper($state) : null),
            Select::make('type')->label('Competition type')->options(CompetitionType::options())->required(),
            Toggle::make('is_active')->label('Active')->default(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Name')->searchable()->sortable(),
                TextColumn::make('code')->label('Competition code')->searchable()->sortable(),
                TextColumn::make('country_code')->label('Country Code')->searchable()->sortable(),
                TextColumn::make('type')->label('Competition type')->formatStateUsing(fn (CompetitionType $state): string => $state->label())->searchable()->sortable(),
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
