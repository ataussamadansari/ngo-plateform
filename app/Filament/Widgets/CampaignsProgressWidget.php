<?php

namespace App\Filament\Widgets;

use App\Models\Campaign;
use Filament\Actions\Action;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class CampaignsProgressWidget extends BaseWidget
{
    protected static ?string $heading = 'Active Campaigns & Financial Progress';

    protected static ?int $sort = 4;

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Campaign::query()
                    ->where('status', 'active')
                    ->with('category')
                    ->latest()
            )
            ->columns([
                TextColumn::make('title')
                    ->label('Campaign')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->limit(35),
                TextColumn::make('category.name')
                    ->label('Category')
                    ->badge()
                    ->color('primary')
                    ->placeholder('Uncategorized'),
                TextColumn::make('goal_amount')
                    ->label('Goal')
                    ->money('INR')
                    ->sortable(),
                TextColumn::make('raised_amount')
                    ->label('Raised')
                    ->money('INR')
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('distributed_amount')
                    ->label('Distributed')
                    ->money('INR')
                    ->sortable(),
                TextColumn::make('progress_percentage')
                    ->label('Progress')
                    ->badge()
                    ->formatStateUsing(fn ($state): string => "{$state}%")
                    ->color(fn (Campaign $record): string => $record->progress_percentage >= 100 ? 'success' : ($record->progress_percentage >= 50 ? 'info' : 'warning')),
                IconColumn::make('is_urgent')
                    ->label('Urgent')
                    ->boolean(),
            ])
            ->actions([
                Action::make('view_public')
                    ->label('View Public')
                    ->icon('heroicon-o-arrow-top-right-on-square')
                    ->color('gray')
                    ->url(fn (Campaign $record): string => route('campaigns.show', $record->slug))
                    ->openUrlInNewTab(),
            ])
            ->paginated([5, 10])
            ->defaultPaginationPageOption(5);
    }
}
