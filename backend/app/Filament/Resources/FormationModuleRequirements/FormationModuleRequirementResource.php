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

    public static function getNavigationGroup(): ?string
    {
        return __('admin.navigation.groups.lookups');
    }

    public static function getNavigationLabel(): string
    {
        return __('admin.resources.formation_module_requirements.plural');
    }

    public static function getModelLabel(): string
    {
        return __('admin.resources.formation_module_requirements.singular');
    }

    public static function getPluralModelLabel(): string
    {
        return __('admin.resources.formation_module_requirements.plural');
    }

    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('formation_module_id')->label(__('admin.labels.formation_module'))->relationship('formationModule', 'label')->searchable()->preload()->required(),
            Select::make('player_role_id')->label(__('admin.labels.player_role'))->relationship('playerRole', 'label')->searchable()->preload()->required(),
            TextInput::make('required_count')->label(__('admin.labels.required_count'))->numeric(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('formationModule.label')->label(__('admin.labels.label'))->searchable()->sortable(),
                TextColumn::make('playerRole.label')->label(__('admin.labels.label'))->searchable()->sortable(),
                TextColumn::make('required_count')->label(__('admin.labels.required_count'))->searchable()->sortable(),
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
