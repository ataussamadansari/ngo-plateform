<?php

namespace App\Filament\Resources\Campaigns\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class CampaignsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('thumbnail_image')
                    ->disk('public')
                    ->square()
                    ->label('Thumbnail'),
                TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->limit(40),
                TextColumn::make('category.name')
                    ->badge()
                    ->sortable()
                    ->label('Category'),
                TextColumn::make('goal_amount')
                    ->money('INR')
                    ->sortable()
                    ->label('Goal'),
                TextColumn::make('raised_amount')
                    ->money('INR')
                    ->sortable()
                    ->label('Raised'),
                TextColumn::make('distributed_amount')
                    ->money('INR')
                    ->sortable()
                    ->label('Distributed'),
                TextColumn::make('status')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => ucfirst($state))
                    ->color(fn (string $state): string => match ($state) {
                        'active' => 'success',
                        'completed' => 'info',
                        'draft' => 'gray',
                        'paused' => 'warning',
                        default => 'gray',
                    }),
                ToggleColumn::make('is_urgent')
                    ->label('Urgent'),
                ToggleColumn::make('is_featured')
                    ->label('Featured'),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'draft' => 'Draft',
                        'active' => 'Active',
                        'completed' => 'Completed',
                        'paused' => 'Paused',
                    ]),
                SelectFilter::make('category_id')
                    ->relationship('category', 'name')
                    ->label('Category'),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
