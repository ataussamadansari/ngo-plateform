<?php

namespace App\Filament\Widgets;

use App\Filament\Infolists\DonationProofInfolist;
use App\Models\Donation;
use App\Services\DonationVerificationService;
use Filament\Actions\Action;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class PendingDonationsQuickActionWidget extends BaseWidget
{
    protected static ?string $heading = 'Pending Donations Awaiting Reconciliation';

    protected static ?int $sort = 6;

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Donation::query()
                    ->with(['campaign'])
                    ->where('status', 'pending')
                    ->latest()
            )
            ->columns([
                TextColumn::make('donor_name')
                    ->label('Donor')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->description(fn (Donation $record): ?string => $record->donor_phone ? "Tel: {$record->donor_phone}" : null),
                TextColumn::make('amount')
                    ->label('Amount')
                    ->money('INR')
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('payment_mode')
                    ->label('Mode')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'upi_qr' => 'UPI QR',
                        'bank_transfer' => 'Bank Transfer',
                        'cash' => 'Cash',
                        default => strtoupper($state),
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'upi_qr' => 'info',
                        'bank_transfer' => 'primary',
                        'cash' => 'success',
                        default => 'gray',
                    }),
                TextColumn::make('utr_number')
                    ->label('UTR / Reference')
                    ->searchable()
                    ->copyable()
                    ->fontFamily('mono')
                    ->badge()
                    ->placeholder('N/A'),
                TextColumn::make('campaign.title')
                    ->label('Campaign')
                    ->badge()
                    ->placeholder('General Fund')
                    ->limit(25),
                TextColumn::make('created_at')
                    ->label('Submitted')
                    ->since()
                    ->sortable(),
            ])
            ->actions([
                Action::make('inspect_proof')
                    ->label('Proof')
                    ->icon('heroicon-o-eye')
                    ->color('gray')
                    ->modalHeading('Donation Proof & Bank Matching')
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Close')
                    ->infolist(DonationProofInfolist::configure()),

                Action::make('approve')
                    ->label('Verify')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('Approve Donation & Issue 80G Receipt')
                    ->modalDescription(fn (Donation $record): string => 'Confirm receipt of ₹'.number_format((float) $record->amount, 2)." from {$record->donor_name}? This will atomically issue an 80G receipt number and update campaign balances.")
                    ->action(function (Donation $record) {
                        $verified = app(DonationVerificationService::class)->approve($record, auth()->id());
                        Notification::make()
                            ->title('Donation Verified')
                            ->body("Receipt #{$verified->receipt_number} issued successfully.")
                            ->success()
                            ->send();
                    }),

                Action::make('reject')
                    ->label('Reject')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->schema([
                        Textarea::make('admin_remarks')
                            ->label('Rejection Remarks / Reason')
                            ->required()
                            ->placeholder('e.g. UTR number not found in bank statement or payment proof invalid.'),
                    ])
                    ->modalHeading('Reject Donation Submission')
                    ->action(function (Donation $record, array $data) {
                        app(DonationVerificationService::class)->reject($record, $data['admin_remarks'], auth()->id());
                        Notification::make()
                            ->title('Donation Rejected')
                            ->body('Donation submission marked as rejected.')
                            ->danger()
                            ->send();
                    }),
            ])
            ->paginated([5, 10, 25])
            ->defaultPaginationPageOption(5);
    }
}
