<?php

namespace App\Filament\Resources\ContactInquiries\Tables;

use App\Models\ContactInquiry;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ViewAction;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ContactInquiriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Visitor Name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->copyable(),
                TextColumn::make('phone')
                    ->label('Phone')
                    ->searchable()
                    ->placeholder('N/A'),
                TextColumn::make('subject')
                    ->label('Subject')
                    ->searchable()
                    ->limit(35),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pending' => 'Pending Review',
                        'read' => 'Read',
                        'replied' => 'Replied',
                        default => ucfirst($state),
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'read' => 'info',
                        'replied' => 'success',
                        default => 'gray',
                    }),
                TextColumn::make('created_at')
                    ->label('Received')
                    ->dateTime('d M Y, h:i A')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending Review',
                        'read' => 'Read',
                        'replied' => 'Replied',
                    ]),
            ])
            ->actions([
                ViewAction::make(),
                Action::make('mark_read')
                    ->label('Mark Read')
                    ->icon('heroicon-o-check')
                    ->color('info')
                    ->visible(fn (ContactInquiry $record): bool => $record->status === 'pending')
                    ->action(function (ContactInquiry $record) {
                        $record->update(['status' => 'read']);
                        Notification::make()
                            ->title('Inquiry Marked as Read')
                            ->success()
                            ->send();
                    }),
                Action::make('mark_replied')
                    ->label('Mark Replied')
                    ->icon('heroicon-o-chat-bubble-left-right')
                    ->color('success')
                    ->visible(fn (ContactInquiry $record): bool => $record->status !== 'replied')
                    ->action(function (ContactInquiry $record) {
                        $record->update(['status' => 'replied']);
                        Notification::make()
                            ->title('Inquiry Marked as Replied')
                            ->success()
                            ->send();
                    }),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
