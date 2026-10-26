<?php

namespace App\Filament\Infolists;

use App\Models\Donation;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;

class DonationProofInfolist
{
    /**
     * Build the native Filament schema components for inspecting donation proof.
     *
     * @return array<Component>
     */
    public static function configure(): array
    {
        return [
            Grid::make(2)
                ->schema([
                    Section::make('Bank Matching Details')
                        ->description('Match transaction UTR and credit amount against non-profit bank account statement.')
                        ->schema([
                            TextEntry::make('utr_number')
                                ->label('UTR / Transaction Ref Number')
                                ->copyable()
                                ->fontFamily('mono')
                                ->weight('extrabold')
                                ->size('lg')
                                ->color('primary')
                                ->placeholder('NO UTR PROVIDED'),

                            TextEntry::make('amount')
                                ->label('Contribution Amount')
                                ->money('INR')
                                ->weight('extrabold')
                                ->size('lg')
                                ->color('success'),

                            TextEntry::make('payment_mode')
                                ->label('Payment Mode')
                                ->badge()
                                ->formatStateUsing(fn (string $state): string => match ($state) {
                                    'upi_qr' => 'UPI QR',
                                    'bank_transfer' => 'Bank Transfer',
                                    'cash' => 'Cash',
                                    default => strtoupper($state),
                                }),

                            TextEntry::make('status')
                                ->label('Verification Status')
                                ->badge()
                                ->formatStateUsing(fn (string $state): string => ucfirst($state))
                                ->color(fn (string $state): string => match ($state) {
                                    'verified' => 'success',
                                    'pending' => 'warning',
                                    'rejected' => 'danger',
                                    default => 'gray',
                                }),

                            TextEntry::make('donor_name')
                                ->label('Donor Full Name')
                                ->weight('bold'),

                            TextEntry::make('donor_phone')
                                ->label('Contact Phone')
                                ->copyable(),

                            TextEntry::make('donor_email')
                                ->label('Email Address')
                                ->placeholder('N/A'),

                            TextEntry::make('donor_pan')
                                ->label('Donor PAN (for 80G)')
                                ->fontFamily('mono')
                                ->placeholder('Not Provided'),

                            TextEntry::make('campaign.title')
                                ->label('Allocated Campaign')
                                ->badge()
                                ->placeholder('General Relief Fund'),

                            TextEntry::make('receipt_number')
                                ->label('Issued 80G Receipt Number')
                                ->fontFamily('mono')
                                ->color('success')
                                ->weight('bold')
                                ->visible(fn (Donation $record): bool => ! empty($record->receipt_number)),

                            TextEntry::make('admin_remarks')
                                ->label('Administrative Remarks / Reasons')
                                ->columnSpanFull()
                                ->visible(fn (Donation $record): bool => ! empty($record->admin_remarks)),
                        ])
                        ->columns(2),

                    Section::make('Uploaded Payment Proof Screenshot')
                        ->description('Digital receipt proof uploaded by donor.')
                        ->schema([
                            ImageEntry::make('payment_screenshot')
                                ->label('')
                                ->disk('public')
                                ->placeholder('No payment proof uploaded (direct cash or manual ledger entry)')
                                ->extraImgAttributes([
                                    'class' => 'max-h-96 w-full object-contain mx-auto rounded-xl shadow-sm border border-slate-200 dark:border-slate-700',
                                ]),
                        ]),
                ]),
        ];
    }
}
