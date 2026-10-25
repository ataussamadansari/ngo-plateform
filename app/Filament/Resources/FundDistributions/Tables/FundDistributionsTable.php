<?php

namespace App\Filament\Resources\FundDistributions\Tables;

use App\Models\Campaign;
use App\Models\FundDistribution;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class FundDistributionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('distribution_date')
                    ->label('Date')
                    ->date('d M Y')
                    ->sortable(),
                TextColumn::make('title')
                    ->label('Disbursement Title')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->limit(35),
                TextColumn::make('beneficiary_name')
                    ->label('Beneficiary / Vendor')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('campaign.title')
                    ->label('Campaign')
                    ->badge()
                    ->placeholder('General Fund')
                    ->limit(25),
                TextColumn::make('amount_spent')
                    ->label('Amount Disbursed')
                    ->money('INR')
                    ->sortable()
                    ->weight('bold'),
                ToggleColumn::make('is_public')
                    ->label('Public'),
                ImageColumn::make('proof_bill_image')
                    ->disk('public')
                    ->square()
                    ->label('Bill'),
            ])
            ->filters([
                SelectFilter::make('campaign_id')
                    ->relationship('campaign', 'title')
                    ->label('Campaign'),
                TernaryFilter::make('is_public')
                    ->label('Public Ledger'),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make()->before(function (FundDistribution $record) {
                    if ($record->campaign_id) {
                        Campaign::where('id', $record->campaign_id)->decrement('distributed_amount', (float) $record->amount_spent);
                    }
                }),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('distribution_date', 'desc');
    }
}
