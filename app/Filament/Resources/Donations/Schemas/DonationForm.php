<?php

namespace App\Filament\Resources\Donations\Schemas;

use App\Models\Donation;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

class DonationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Donor Particulars')
                    ->description('Personal identification and tax exemption details.')
                    ->schema([
                        TextInput::make('donor_name')
                            ->label('Donor Full Name')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('donor_phone')
                            ->label('Phone Number')
                            ->tel()
                            ->required()
                            ->maxLength(20),
                        TextInput::make('donor_email')
                            ->label('Email Address')
                            ->email()
                            ->maxLength(255),
                        TextInput::make('donor_pan')
                            ->label('PAN Card Number')
                            ->placeholder('ABCDE1234F')
                            ->maxLength(10)
                            ->extraInputAttributes(['style' => 'text-transform: uppercase']),
                        Textarea::make('donor_address')
                            ->label('Postal Address (Required on 80G Receipt)')
                            ->rows(2)
                            ->columnSpanFull(),
                        Toggle::make('is_anonymous')
                            ->label('Anonymous Donation')
                            ->helperText('Hide donor name from public donor roll and wall of gratitude.')
                            ->default(false),
                    ])->columns(2),

                Section::make('Payment & Financial Particulars')
                    ->description('Amount, payment channel, campaign allocation, and bank reference.')
                    ->schema([
                        TextInput::make('amount')
                            ->label('Donation Amount')
                            ->numeric()
                            ->prefix('₹')
                            ->required()
                            ->minValue(1)
                            ->disabled(fn (?Donation $record): bool => (bool) $record?->isVerified()),
                        Select::make('payment_mode')
                            ->label('Payment Mode')
                            ->options([
                                'cash' => 'Cash (Direct Handover)',
                                'upi_qr' => 'UPI QR Transfer',
                                'bank_transfer' => 'NEFT / RTGS / Bank Transfer',
                            ])
                            ->default('cash')
                            ->required()
                            ->live()
                            ->disabled(fn (?Donation $record): bool => (bool) $record?->isVerified()),
                        Select::make('campaign_id')
                            ->label('Allocated Campaign / Cause')
                            ->relationship('campaign', 'title')
                            ->searchable()
                            ->preload()
                            ->placeholder('General Humanitarian Fund (Unrestricted)')
                            ->disabled(fn (?Donation $record): bool => (bool) $record?->isVerified()),
                        TextInput::make('utr_number')
                            ->label('UTR / Bank Transaction Reference')
                            ->placeholder('e.g. 12-digit bank reference number')
                            ->maxLength(255)
                            ->visible(fn (Get $get): bool => in_array($get('payment_mode'), ['upi_qr', 'bank_transfer']))
                            ->disabled(fn (?Donation $record): bool => (bool) $record?->isVerified()),
                        FileUpload::make('payment_screenshot')
                            ->label('Payment Screenshot Proof')
                            ->disk('public')
                            ->directory('donations/proofs')
                            ->image()
                            ->maxSize(2048)
                            ->columnSpanFull()
                            ->visible(fn (Get $get): bool => in_array($get('payment_mode'), ['upi_qr', 'bank_transfer'])),
                        Textarea::make('admin_remarks')
                            ->label('Admin Notes / Verification Remarks')
                            ->placeholder('Add internal notes, offline handover details, or bank statement matching reference.')
                            ->rows(2)
                            ->default('Direct offline entry verified by administrator.')
                            ->columnSpanFull(),
                    ])->columns(2),
            ]);
    }
}
