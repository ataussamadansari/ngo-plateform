<?php

namespace App\Filament\Resources\Volunteers\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class VolunteerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Personal & Contact Particulars')
                    ->description('Volunteer identification and location details.')
                    ->schema([
                        TextInput::make('full_name')
                            ->label('Full Name')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('phone')
                            ->label('Phone Number')
                            ->tel()
                            ->required()
                            ->maxLength(20),
                        TextInput::make('email')
                            ->label('Email Address')
                            ->email()
                            ->maxLength(255),
                        TextInput::make('occupation')
                            ->label('Occupation / Profession')
                            ->maxLength(255),
                        TextInput::make('city')
                            ->label('City / District')
                            ->required()
                            ->maxLength(255),
                        Textarea::make('address')
                            ->label('Postal Address')
                            ->rows(2)
                            ->columnSpanFull(),
                        FileUpload::make('profile_photo')
                            ->label('Profile Photograph')
                            ->disk('public')
                            ->directory('volunteers/photos')
                            ->image()
                            ->maxSize(2048)
                            ->dehydrated(fn ($state) => filled($state)),
                        FileUpload::make('id_proof_path')
                            ->label('Identity Proof Document (Aadhaar/Voter ID/Passport)')
                            ->disk('public')
                            ->directory('volunteers/id_proofs')
                            ->maxSize(2048)
                            ->dehydrated(fn ($state) => filled($state)),
                    ])->columns(2),

                Section::make('Role, Skills & Verification')
                    ->description('Screening status, expertise tags, and unique volunteer identification.')
                    ->schema([
                        TextInput::make('volunteer_code')
                            ->label('Volunteer ID Code')
                            ->placeholder('Assigned on approval (e.g. KSF-VOL-2026-0001)')
                            ->disabled()
                            ->dehydrated(false),
                        Select::make('status')
                            ->label('Application Status')
                            ->options([
                                'pending' => 'Pending Screening',
                                'approved' => 'Approved',
                                'rejected' => 'Rejected',
                            ])
                            ->default('pending')
                            ->required(),
                        Select::make('availability')
                            ->label('Availability')
                            ->options([
                                'weekends' => 'Weekends Only',
                                'weekdays' => 'Weekdays Only',
                                'flexible' => 'Flexible / On-Call',
                            ])
                            ->default('weekends'),
                        DatePicker::make('joined_at')
                            ->label('Joined / Approval Date'),
                        TagsInput::make('skills')
                            ->label('Skills & Areas of Contribution')
                            ->placeholder('Add skill and press enter')
                            ->columnSpanFull(),
                    ])->columns(2),
            ]);
    }
}
