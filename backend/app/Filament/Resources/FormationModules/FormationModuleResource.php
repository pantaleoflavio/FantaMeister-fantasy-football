<?php

namespace App\Filament\Resources\FormationModules;

use App\Models\FormationModule;
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

class FormationModuleResource extends Resource
{
    protected static ?string $model = FormationModule::class;

    protected static string|\UnitEnum|null $navigationGroup = 'Lookups';

    protected static ?string $navigationLabel = 'Formation Modules';

    protected static ?string $recordTitleAttribute = 'label';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('name')->label('Name')->required()->unique(ignoreRecord: true),
            TextInput::make('label')->label('Label')->required(),
            Toggle::make('is_active')->label('Active')->default(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Name')->searchable()->sortable(),
                TextColumn::make('label')->label('Label')->searchable()->sortable(),
                IconColumn::make('is_active')->boolean(),
            ])
            ->recordActions([EditAction::make()])
            ->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFormationModules::route('/'),
            'create' => Pages\CreateFormationModule::route('/create'),
            'edit' => Pages\EditFormationModule::route('/{record}/edit'),
        ];
    }
}
