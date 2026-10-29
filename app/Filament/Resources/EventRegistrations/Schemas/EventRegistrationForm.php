<?php

namespace App\Filament\Resources\EventRegistrations\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class EventRegistrationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Attendee Particulars')
                    ->description('Registration details, assigned roles, and ground attendance status.')
                    ->schema([
                        Select::make('event_id')
                            ->relationship('event', 'title')
                            ->label('Event')
                            ->required()
                            ->searchable()
                            ->preload(),
                        Select::make('volunteer_id')
                            ->relationship('volunteer', 'full_name')
                            ->label('Linked Volunteer (Optional)')
                            ->searchable()
                            ->preload()
                            ->placeholder('Non-volunteer participant / Guest'),
                        TextInput::make('participant_name')
                            ->label('Participant Full Name')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('participant_phone')
                            ->label('Contact Phone')
                            ->tel()
                            ->required()
                            ->maxLength(20),
                        TextInput::make('participant_email')
                            ->label('Email Address')
                            ->email()
                            ->maxLength(255),
                        TextInput::make('role_assigned')
                            ->label('Assigned Ground Role')
                            ->placeholder('e.g. Logistics Team Lead, First Aid, General Attendee')
                            ->maxLength(255),
                        Select::make('attendance_status')
                            ->label('Attendance Status')
                            ->options([
                                'registered' => 'Registered / Confirmed',
                                'attended' => 'Attended / Checked In',
                                'absent' => 'Absent / No Show',
                            ])
                            ->default('registered')
                            ->required(),
                    ])->columns(2),
            ]);
    }
}
