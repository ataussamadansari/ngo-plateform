<?php

namespace App\Filament\Resources\PaymentMethods\Tables;

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

class PaymentMethodsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('type')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'upi_qr' => 'UPI QR Code',
                        'bank_account' => 'Bank Account',
                        default => $state,
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'upi_qr' => 'success',
                        'bank_account' => 'info',
                        default => 'gray',
                    }),
                TextColumn::make('label')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                ImageColumn::make('qr_image_path')
                    ->disk('public')
                    ->square()
                    ->label('QR Code'),
                TextColumn::make('upi_id')
                    ->copyable()
                    ->label('UPI ID')
                    ->placeholder('-'),
                TextColumn::make('account_number')
                    ->label('Account Number')
                    ->placeholder('-'),
                TextColumn::make('bank_name')
                    ->label('Bank')
                    ->placeholder('-'),
                ToggleColumn::make('is_active')
                    ->label('Active'),
                TextColumn::make('display_order')
                    ->sortable()
                    ->label('Order'),
            ])
            ->filters([
                SelectFilter::make('type')
                    ->options([
                        'upi_qr' => 'UPI QR Code',
                        'bank_account' => 'Bank Account',
                    ]),
                TernaryFilter::make('is_active')
                    ->label('Active Status')
                    ->placeholder('All Methods')
                    ->trueLabel('Active Only')
                    ->falseLabel('Inactive Only'),
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
