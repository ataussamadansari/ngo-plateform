<?php

namespace App\Filament\Resources\PaymentMethods\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

class PaymentMethodForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('General Information')
                    ->schema([
                        Select::make('type')
                            ->options([
                                'upi_qr' => 'UPI QR Code',
                                'bank_account' => 'Bank Account Transfer',
                            ])
                            ->required()
                            ->live(),
                        TextInput::make('label')
                            ->label('Display Label')
                            ->helperText('e.g. Primary UPI QR, SBI Current Account')
                            ->required()
                            ->maxLength(255),
                        Toggle::make('is_active')
                            ->label('Active for Public Donations')
                            ->default(true),
                        TextInput::make('display_order')
                            ->label('Display Priority Order')
                            ->numeric()
                            ->default(0),
                    ])->columns(2),

                Section::make('UPI Configuration')
                    ->description('Configuration details for dynamic or static UPI payment collection.')
                    ->visible(fn (Get $get): bool => $get('type') === 'upi_qr')
                    ->schema([
                        TextInput::make('upi_id')
                            ->label('UPI ID (VPA)')
                            ->placeholder('e.g. ngo@sbi')
                            ->maxLength(255),
                        FileUpload::make('qr_image_path')
                            ->label('UPI QR Code Image')
                            ->disk('public')
                            ->directory('payment_methods')
                            ->image()
                            ->maxSize(2048),
                    ])->columns(2),

                Section::make('Bank Account Configuration')
                    ->description('Bank account and branch details for NEFT/RTGS/IMPS direct transfers.')
                    ->visible(fn (Get $get): bool => $get('type') === 'bank_account')
                    ->schema([
                        TextInput::make('bank_name')
                            ->label('Bank Name')
                            ->maxLength(255),
                        TextInput::make('account_holder_name')
                            ->label('Account Holder Name')
                            ->maxLength(255),
                        TextInput::make('account_number')
                            ->label('Bank Account Number')
                            ->maxLength(255),
                        TextInput::make('ifsc_code')
                            ->label('IFSC Code')
                            ->maxLength(255),
                        TextInput::make('branch_name')
                            ->label('Branch Name / City')
                            ->maxLength(255),
                    ])->columns(2),
            ]);
    }
}
