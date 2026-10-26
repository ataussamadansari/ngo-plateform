<?php

namespace App\Filament\Widgets;

use App\Models\Volunteer;
use App\Services\VolunteerCodeService;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\Facades\DB;

class PendingVolunteersWidget extends BaseWidget
{
    protected static ?string $heading = 'Pending Volunteer Applicants';

    protected static ?int $sort = 3;

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Volunteer::query()
                    ->where('status', 'pending')
                    ->latest()
            )
            ->columns([
                TextColumn::make('full_name')
                    ->label('Applicant Name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('phone')
                    ->label('Phone')
                    ->searchable()
                    ->copyable(),
                TextColumn::make('email')
                    ->label('Email')
                    ->searchable(),
                TextColumn::make('city')
                    ->label('City')
                    ->badge()
                    ->sortable(),
                TextColumn::make('availability')
                    ->label('Availability')
                    ->badge()
                    ->color('info')
                    ->placeholder('Flexible'),
                TextColumn::make('created_at')
                    ->label('Applied')
                    ->since()
                    ->sortable(),
            ])
            ->actions([
                Action::make('approve')
                    ->label('Approve')
                    ->icon('heroicon-o-check-badge')
                    ->color('success')
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
                    ->requiresConfirmation()
                    ->modalHeading('Reject Volunteer Application')
                    ->action(function (Volunteer $record) {
                        $record->update(['status' => 'rejected']);

                        Notification::make()
                            ->title('Volunteer Application Rejected')
                            ->danger()
                            ->send();
                    }),
            ])
            ->paginated([5, 10, 25])
            ->defaultPaginationPageOption(5);
    }
}
