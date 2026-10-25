<?php

namespace App\Filament\Resources\Events\RelationManagers;

use App\Models\EventRegistration;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class RegistrationsRelationManager extends RelationManager
{
    protected static string $relationship = 'registrations';

    protected static ?string $title = 'Attendee Registrations & Roster';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('participant_name')
                    ->label('Participant Name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('participant_phone')
                    ->label('Phone Number')
                    ->tel()
                    ->required()
                    ->maxLength(20),
                TextInput::make('participant_email')
                    ->label('Email Address')
                    ->email()
                    ->maxLength(255),
                TextInput::make('role_assigned')
                    ->label('Role Assigned')
                    ->placeholder('e.g. Ground Relief, Welcome Desk, Medical Assistance')
                    ->maxLength(255),
                Select::make('volunteer_id')
                    ->label('Linked Volunteer')
                    ->relationship('volunteer', 'full_name')
                    ->searchable()
                    ->preload()
                    ->placeholder('Guest / Walk-in Participant'),
                Select::make('attendance_status')
                    ->label('Attendance Status')
                    ->options([
                        'registered' => 'Registered',
                        'attended' => 'Attended',
                        'absent' => 'Absent',
                    ])
                    ->default('registered')
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('participant_name')
            ->columns([
                TextColumn::make('participant_name')
                    ->label('Participant Name')
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
                TextColumn::make('volunteer.volunteer_code')
                    ->label('Volunteer Code')
                    ->badge()
                    ->placeholder('Guest'),
                TextColumn::make('role_assigned')
                    ->label('Role')
                    ->placeholder('-'),
                TextColumn::make('attendance_status')
                    ->label('Attendance')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'attended' => 'Attended',
                        'absent' => 'Absent',
                        'registered' => 'Registered',
                        default => ucfirst($state),
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'attended' => 'success',
                        'absent' => 'danger',
                        'registered' => 'info',
                        default => 'gray',
                    }),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make()->label('Add On-Spot Participant'),
            ])
            ->actions([
                Action::make('mark_attended')
                    ->label('Mark Attended')
                    ->icon('heroicon-o-check')
                    ->color('success')
                    ->visible(fn (EventRegistration $record): bool => $record->attendance_status !== 'attended')
                    ->action(fn (EventRegistration $record) => $record->update(['attendance_status' => 'attended'])),

                Action::make('mark_absent')
                    ->label('Mark Absent')
                    ->icon('heroicon-o-x-mark')
                    ->color('danger')
                    ->visible(fn (EventRegistration $record): bool => $record->attendance_status !== 'absent')
                    ->action(fn (EventRegistration $record) => $record->update(['attendance_status' => 'absent'])),

                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
