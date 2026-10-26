<?php

namespace App\Filament\Infolists;

use App\Models\Volunteer;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;

class VolunteerInspectInfolist
{
    /**
     * Build the native Filament schema components for inspecting volunteer applications.
     *
     * @return array<Component>
     */
    public static function configure(): array
    {
        return [
            Grid::make(2)
                ->schema([
                    Section::make('Applicant Particulars')
                        ->description('Volunteer identification, skills, and background information.')
                        ->schema([
                            TextEntry::make('full_name')
                                ->label('Full Name')
                                ->weight('bold')
                                ->size('lg'),

                            TextEntry::make('volunteer_code')
                                ->label('Volunteer ID Code')
                                ->fontFamily('mono')
                                ->weight('bold')
                                ->color('success')
                                ->placeholder('Pending Approval'),

                            TextEntry::make('status')
                                ->label('Application Status')
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

                            TextEntry::make('phone')
                                ->label('Contact Phone')
                                ->copyable(),

                            TextEntry::make('email')
                                ->label('Email Address')
                                ->placeholder('Not Provided'),

                            TextEntry::make('city')
                                ->label('City / District')
                                ->badge(),

                            TextEntry::make('occupation')
                                ->label('Occupation / Profession')
                                ->placeholder('Not Specified'),

                            TextEntry::make('availability')
                                ->label('Availability')
                                ->badge()
                                ->formatStateUsing(fn (string $state): string => match ($state) {
                                    'weekends' => 'Weekends Only',
                                    'weekdays' => 'Weekdays Only',
                                    'flexible' => 'Flexible / On-Call',
                                    default => ucfirst($state),
                                }),

                            TextEntry::make('address')
                                ->label('Postal Address')
                                ->columnSpanFull()
                                ->placeholder('No postal address provided'),

                            TextEntry::make('skills')
                                ->label('Skills & Areas of Contribution')
                                ->badge()
                                ->color('info')
                                ->columnSpanFull(),
                        ])
                        ->columns(2),

                    Section::make('Identity Proof & Photograph')
                        ->description('Document verification for volunteer screening.')
                        ->schema([
                            ImageEntry::make('profile_photo')
                                ->label('Profile Photograph')
                                ->disk('public')
                                ->circular()
                                ->placeholder('No profile photo uploaded'),

                            ImageEntry::make('id_proof_path')
                                ->label('Government Identity Proof (Aadhaar / Voter ID / Passport)')
                                ->disk('public')
                                ->placeholder('No government ID proof attached')
                                ->extraImgAttributes([
                                    'class' => 'max-h-64 w-full object-contain mx-auto rounded-xl shadow-sm border border-slate-200 dark:border-slate-700',
                                ]),
                        ]),
                ]),
        ];
    }
}
