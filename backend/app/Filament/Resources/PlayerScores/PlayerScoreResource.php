<?php

namespace App\Filament\Resources\PlayerScores;

use App\Models\PlayerScore;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PlayerScoreResource extends Resource
{
    protected static ?string $model = PlayerScore::class;

    public static function getNavigationGroup(): ?string
    {
        return __('admin.navigation.groups.scores');
    }

    public static function getNavigationLabel(): string
    {
        return __('admin.resources.player_scores.plural');
    }

    public static function getModelLabel(): string
    {
        return __('admin.resources.player_scores.singular');
    }

    public static function getPluralModelLabel(): string
    {
        return __('admin.resources.player_scores.plural');
    }

    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('matchday_id')->label(__('admin.labels.matchday'))->relationship('matchday', 'name')->searchable()->preload()->required(),
            Select::make('player_season_registration_id')->label(__('admin.labels.player_registration'))->relationship('playerSeasonRegistration', 'id')->searchable()->preload()->required(),
            TextInput::make('base_rating')->label(__('admin.labels.base_rating'))->numeric(),
            TextInput::make('goals')->label(__('admin.labels.goals'))->numeric(),
            TextInput::make('assists')->label(__('admin.labels.assists'))->numeric(),
            TextInput::make('yellow_cards')->label(__('admin.labels.yellow_cards'))->numeric(),
            TextInput::make('red_cards')->label(__('admin.labels.red_cards'))->numeric(),
            TextInput::make('own_goals')->label(__('admin.labels.own_goals'))->numeric(),
            TextInput::make('penalties_scored')->label(__('admin.labels.penalties_scored'))->numeric(),
            TextInput::make('penalties_missed')->label(__('admin.labels.penalties_missed'))->numeric(),
            TextInput::make('penalties_saved')->label(__('admin.labels.penalties_saved'))->numeric(),
            TextInput::make('goals_conceded')->label(__('admin.labels.goals_conceded'))->numeric(),
            Toggle::make('clean_sheet')->label(__('admin.labels.clean_sheet'))->default(false),
            TextInput::make('final_score')->label(__('admin.labels.final_score'))->numeric(),
            TextInput::make('status')->label(__('admin.labels.status'))->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('matchday.name')->label(__('admin.labels.matchday'))->searchable()->sortable(),
                TextColumn::make('playerSeasonRegistration.player.display_name')->label(__('admin.labels.display_name'))->searchable()->sortable(),
                TextColumn::make('base_rating')->label(__('admin.labels.base_rating'))->searchable()->sortable(),
                TextColumn::make('final_score')->label(__('admin.labels.final_score'))->searchable()->sortable(),
                TextColumn::make('status')->label(__('admin.labels.status'))->searchable()->sortable(),
            ])
            ->recordActions([EditAction::make()])
            ->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPlayerScores::route('/'),
            'create' => Pages\CreatePlayerScore::route('/create'),
            'edit' => Pages\EditPlayerScore::route('/{record}/edit'),
        ];
    }
}
