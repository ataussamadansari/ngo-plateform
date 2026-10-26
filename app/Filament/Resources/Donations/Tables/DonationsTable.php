<?php

namespace App\Filament\Resources\Donations\Tables;

use App\Models\Donation;
use App\Services\DonationVerificationService;
use App\Services\ReceiptPdfService;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class DonationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('receipt_number')
                    ->label('Receipt No.')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->fontFamily('mono')
                    ->weight('bold')
                    ->placeholder('Pending Review'),
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
                    ->label('Payment Mode')
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
                TextColumn::make('campaign.title')
                    ->label('Campaign')
                    ->badge()
                    ->placeholder('General Fund')
                    ->limit(25),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'verified' => 'Verified',
                        'pending' => 'Pending Review',
                        'rejected' => 'Rejected',
                        default => ucfirst($state),
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'verified' => 'success',
                        'pending' => 'warning',
                        'rejected' => 'danger',
                        default => 'gray',
                    }),
                TextColumn::make('utr_number')
                    ->label('UTR Number')
                    ->searchable()
                    ->copyable()
                    ->fontFamily('mono')
                    ->placeholder('N/A')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->label('Date')
                    ->dateTime('d M Y, h:i A')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending Review',
                        'verified' => 'Verified',
                        'rejected' => 'Rejected',
                    ]),
                SelectFilter::make('campaign_id')
                    ->relationship('campaign', 'title')
                    ->label('Campaign'),
                SelectFilter::make('payment_mode')
                    ->options([
                        'upi_qr' => 'UPI QR',
                        'bank_transfer' => 'Bank Transfer',
                        'cash' => 'Cash',
                    ]),
                Filter::make('created_at')
                    ->form([
                        DatePicker::make('created_from')->label('Donation Date From'),
                        DatePicker::make('created_until')->label('Donation Date Until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'] ?? null,
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'] ?? null,
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    }),
            ])
            ->actions([
                Action::make('inspect_proof')
                    ->label('Proof')
                    ->icon('heroicon-o-eye')
                    ->color('gray')
                    ->modalHeading('Donation Proof & Submission Details')
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Close')
                    ->modalContent(fn (Donation $record) => view('filament.resources.donations.proof-modal', ['record' => $record])),

                Action::make('approve')
                    ->label('Approve')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn (Donation $record): bool => $record->status === 'pending')
                    ->requiresConfirmation()
                    ->modalHeading('Approve Donation & Issue 80G Receipt')
                    ->modalDescription(fn (Donation $record): string => 'Confirm approval for donation of ₹'.number_format((float) $record->amount, 2)." from {$record->donor_name}? This will atomically issue an 80G receipt number and update campaign balances.")
                    ->action(function (Donation $record) {
                        $verified = app(DonationVerificationService::class)->approve($record, auth()->id());
                        Notification::make()
                            ->title('Donation Approved')
                            ->body("Receipt #{$verified->receipt_number} issued successfully.")
                            ->success()
                            ->send();
                    }),

                Action::make('reject')
                    ->label('Reject')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->visible(fn (Donation $record): bool => $record->status === 'pending')
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

                Action::make('download_receipt')
                    ->label('80G Receipt')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('info')
                    ->visible(fn (Donation $record): bool => $record->status === 'verified' && ! empty($record->receipt_number))
                    ->action(function (Donation $record) {
                        $pdf = app(ReceiptPdfService::class)->generatePdf($record);

                        return response()->streamDownload(
                            fn () => print $pdf->output(),
                            "receipt-{$record->receipt_number}.pdf",
                            ['Content-Type' => 'application/pdf']
                        );
                    }),

                EditAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
