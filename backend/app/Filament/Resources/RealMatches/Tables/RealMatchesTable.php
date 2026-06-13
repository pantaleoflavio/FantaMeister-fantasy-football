<?php

namespace App\Filament\Resources\RealMatches\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class RealMatchesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('matchday.name')
                    ->searchable(),
                TextColumn::make('homeSeasonClub.id')
                    ->searchable(),
                TextColumn::make('awaySeasonClub.id')
                    ->searchable(),
                TextColumn::make('kickoff_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('home_score')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('away_score')
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
