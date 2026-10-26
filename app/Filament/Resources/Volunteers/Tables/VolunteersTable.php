<?php

namespace App\Filament\Resources\Volunteers\Tables;

use App\Models\Volunteer;
use App\Services\VolunteerCodeService;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Facades\DB;

class VolunteersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('volunteer_code')
                    ->label('ID Code')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->fontFamily('mono')
                    ->weight('bold')
                    ->placeholder('-'),
                TextColumn::make('full_name')
                    ->label('Volunteer Name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('phone')
                    ->label('Phone')
                    ->searchable()
                    ->copyable(),
                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('city')
                    ->label('City')
                    ->badge()
                    ->sortable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'approved' => 'Approved',
                        'pending' => 'Pending Review',
                        'rejected' => 'Rejected',
                        default => ucfirst($state),
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'approved' => 'success',
                        'pending' => 'warning',
                        'rejected' => 'danger',
                        default => 'gray',
                    }),
                TextColumn::make('created_at')
                    ->label('Applied On')
                    ->date('d M Y')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending Review',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                    ]),
                SelectFilter::make('city')
                    ->options(fn () => Volunteer::distinct()->whereNotNull('city')->pluck('city', 'city')->toArray()),
            ])
            ->actions([
                Action::make('inspect')
                    ->label('Inspect')
                    ->icon('heroicon-o-identification')
                    ->color('gray')
                    ->modalHeading('Volunteer Application & Identity Verification')
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Close')
                    ->modalContent(fn (Volunteer $record) => view('filament.resources.volunteers.inspect-modal', ['record' => $record])),

                Action::make('approve')
                    ->label('Approve')
                    ->icon('heroicon-o-check-badge')
                    ->color('success')
                    ->visible(fn (Volunteer $record): bool => $record->status !== 'approved')
                    ->requiresConfirmation()
                    ->modalHeading('Approve Volunteer Application')
                    ->modalDescription(fn (Volunteer $record): string => "Approve {$record->full_name} and issue official volunteer identification code?")
                    ->action(function (Volunteer $record) {
                        DB::transaction(function () use ($record) {
                            $code = $record->volunteer_code ?: app(VolunteerCodeService::class)->generateNextCode();
                            $record->update([
                                'status' => 'approved',
                                'volunteer_code' => $code,
                                'joined_at' => $record->joined_at ?: now(),
                            ]);
                        });

                        Notification::make()
                            ->title('Volunteer Approved')
                            ->body("Approved with volunteer ID: {$record->fresh()->volunteer_code}")
                            ->success()
                            ->send();
                    }),

                Action::make('reject')
                    ->label('Reject')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->visible(fn (Volunteer $record): bool => $record->status !== 'rejected')
                    ->requiresConfirmation()
                    ->modalHeading('Reject Volunteer Application')
                    ->action(function (Volunteer $record) {
                        $record->update(['status' => 'rejected']);

                        Notification::make()
                            ->title('Volunteer Application Rejected')
                            ->danger()
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
