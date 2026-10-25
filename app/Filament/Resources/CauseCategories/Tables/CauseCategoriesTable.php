<?php

namespace App\Filament\Resources\CauseCategories\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class CauseCategoriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('slug')
                    ->searchable()
                    ->sortable()
                    ->color('gray'),
                TextColumn::make('campaigns_count')
                    ->counts('campaigns')
                    ->label('Campaigns')
                    ->badge()
                    ->color('info')
                    ->sortable(),
                ToggleColumn::make('is_active')
                    ->label('Active'),
            ])
            ->filters([
                TernaryFilter::make('is_active')
                    ->label('Active Status')
                    ->placeholder('All Categories')
                    ->trueLabel('Active Only')
                    ->falseLabel('Inactive Only'),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make()
                    ->before(function (DeleteAction $action, $record) {
                        if ($record->campaigns()->count() > 0) {
                            Notification::make()
                                ->danger()
                                ->title('Cannot Delete Category')
                                ->body("Category '{$record->name}' has active campaigns associated with it.")
                                ->send();

                            $action->cancel();
                        }
                    }),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
