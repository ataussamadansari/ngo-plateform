<?php

namespace App\Filament\Resources\EventRegistrations\Tables;

use App\Models\EventRegistration;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class EventRegistrationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('participant_name')
                    ->label('Attendee Name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('participant_phone')
                    ->label('Phone')
                    ->searchable()
                    ->copyable(),
                TextColumn::make('participant_email')
                    ->label('Email')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('event.title')
                    ->label('Event')
                    ->badge()
                    ->color('info')
                    ->limit(25)
                    ->searchable()
                    ->sortable(),
                TextColumn::make('role_assigned')
                    ->label('Assigned Role')
                    ->placeholder('General Participant')
                    ->badge()
                    ->color('gray'),
                TextColumn::make('attendance_status')
                    ->label('Attendance')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'attended' => 'Attended',
                        'registered' => 'Registered',
                        'absent' => 'Absent',
                        default => ucfirst($state),
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'attended' => 'success',
                        'registered' => 'warning',
                        'absent' => 'danger',
                        default => 'gray',
                    }),
                TextColumn::make('created_at')
                    ->label('Registered On')
                    ->dateTime('d M Y, h:i A')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('event_id')
                    ->relationship('event', 'title')
                    ->label('Event'),
                SelectFilter::make('attendance_status')
                    ->options([
                        'registered' => 'Registered',
                        'attended' => 'Attended',
                        'absent' => 'Absent',
                    ]),
            ])
            ->actions([
                Action::make('mark_attended')
                    ->label('Check In')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn (EventRegistration $record): bool => $record->attendance_status !== 'attended')
                    ->action(function (EventRegistration $record) {
                        $record->update(['attendance_status' => 'attended']);
                        Notification::make()
                            ->title('Checked In')
                            ->body("{$record->participant_name} marked as attended.")
                            ->success()
                            ->send();
                    }),

                Action::make('mark_absent')
                    ->label('Mark Absent')
                    ->icon('heroicon-o-x-circle')
                    ->color('gray')
                    ->visible(fn (EventRegistration $record): bool => $record->attendance_status === 'attended')
                    ->action(function (EventRegistration $record) {
                        $record->update(['attendance_status' => 'absent']);
                        Notification::make()
                            ->title('Marked Absent')
                            ->body("{$record->participant_name} marked as absent.")
                            ->info()
                            ->send();
                    }),

                EditAction::make(),
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
