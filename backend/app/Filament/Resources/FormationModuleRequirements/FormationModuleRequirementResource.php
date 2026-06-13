<?php

namespace App\Filament\Resources\FormationModuleRequirements;

use App\Models\FormationModuleRequirement;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class FormationModuleRequirementResource extends Resource
{
    protected static ?string $model = FormationModuleRequirement::class;

    protected static string|\UnitEnum|null $navigationGroup = 'Lookups';

    protected static ?string $navigationLabel = 'Formation Module Requirements';

    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('formation_module_id')->label('Formation module')->relationship('formationModule', 'label')->searchable()->preload()->required(),
            Select::make('player_role_id')->label('Player role')->relationship('playerRole', 'label')->searchable()->preload()->required(),
            TextInput::make('required_count')->label('Required count')->numeric(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('formationModule.label')->label('Label')->searchable()->sortable(),
                TextColumn::make('playerRole.label')->label('Label')->searchable()->sortable(),
                TextColumn::make('required_count')->label('Required Count')->searchable()->sortable(),
            ])
            ->recordActions([EditAction::make()])
            ->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFormationModuleRequirements::route('/'),
            'create' => Pages\CreateFormationModuleRequirement::route('/create'),
            'edit' => Pages\EditFormationModuleRequirement::route('/{record}/edit'),
        ];
    }
}
