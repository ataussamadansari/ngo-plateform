<?php

namespace App\Filament\Resources\FundDistributions\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class FundDistributionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Disbursement Particulars')
                    ->description('Details of funds disbursed for ground relief or vendor procurement.')
                    ->schema([
                        TextInput::make('title')
                            ->label('Disbursement Title / Project')
                            ->placeholder('e.g. Purchase of 100 Thermal Blankets')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),
                        Select::make('campaign_id')
                            ->label('Allocated Campaign / Cause')
                            ->relationship('campaign', 'title')
                            ->searchable()
                            ->preload()
                            ->placeholder('General Humanitarian Fund (Unrestricted)'),
                        TextInput::make('beneficiary_name')
                            ->label('Beneficiary / Vendor Name')
                            ->placeholder('e.g. Assi Ghat Night Shelter or ABC Medical Store')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('amount_spent')
                            ->label('Amount Disbursed')
                            ->numeric()
                            ->prefix('₹')
                            ->minValue(1)
                            ->required(),
                        DatePicker::make('distribution_date')
                            ->label('Disbursement Date')
                            ->default(now())
                            ->required(),
                        TextInput::make('payment_reference')
                            ->label('Payment Reference / UTR / Cheque')
                            ->placeholder('e.g. CHQ-100234 or NEFT-88392019')
                            ->maxLength(255),
                        Toggle::make('is_public')
                            ->label('Display on Public Transparency Ledger')
                            ->helperText('When enabled, this expenditure will be publicly auditable on the transparency ledger.')
                            ->default(true),
                        Textarea::make('description')
                            ->label('Expenditure Description / Purpose')
                            ->placeholder('Detailed summary of goods/services procured, quantities, and relief deployment...')
                            ->required()
                            ->rows(3)
                            ->columnSpanFull(),
                    ])->columns(2),

                Section::make('Vouchers & Impact Evidence')
                    ->description('Attach verified supplier bills and on-ground relief photographs.')
                    ->schema([
                        FileUpload::make('proof_bill_image')
                            ->label('Invoice / Voucher Bill Receipt')
                            ->disk('public')
                            ->directory('distributions/bills')
                            ->image()
                            ->maxSize(2048)
                            ->dehydrated(fn ($state) => filled($state)),
                        FileUpload::make('impact_photos')
                            ->label('Ground Impact Photos')
                            ->multiple()
                            ->reorderable()
                            ->disk('public')
                            ->directory('distributions/impact')
                            ->image()
                            ->maxSize(2048)
                            ->dehydrated(fn ($state) => filled($state)),
                    ])->columns(2),
            ]);
    }
}
