<?php

namespace App\Filament\Resources\PlayerScores\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PlayerScoresTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('playerSeasonRegistration.id')
                    ->searchable(),
                TextColumn::make('matchday.name')
                    ->searchable(),
                TextColumn::make('base_rating')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('goals')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('assists')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('yellow_cards')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('red_cards')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('own_goals')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('penalties_scored')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('penalties_missed')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('penalties_saved')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('goals_conceded')
                    ->numeric()
                    ->sortable(),
                IconColumn::make('clean_sheet')
                    ->boolean(),
                TextColumn::make('final_score')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('status')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
