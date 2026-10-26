<?php

namespace App\Filament\Resources\Campaigns\RelationManagers;

use App\Models\Donation;
use App\Services\DonationVerificationService;
use App\Services\ReceiptPdfService;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class DonationsRelationManager extends RelationManager
{
    protected static string $relationship = 'donations';

    protected static ?string $title = 'Campaign Inflows (Donations)';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
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

                TextInput::make('amount')
                    ->label('Donation Amount (INR)')
                    ->numeric()
                    ->prefix('₹')
                    ->required()
                    ->minValue(1),

                Select::make('payment_mode')
                    ->label('Payment Mode')
                    ->options([
                        'upi_qr' => 'UPI QR',
                        'bank_transfer' => 'Bank Transfer',
                        'cash' => 'Cash / Offline Handover',
                    ])
                    ->default('cash')
                    ->required(),

                TextInput::make('utr_number')
                    ->label('UTR / Transaction Ref Number')
                    ->maxLength(255),

                FileUpload::make('payment_screenshot')
                    ->label('Payment Proof Screenshot')
                    ->disk('public')
                    ->directory('donations/proofs')
                    ->image()
                    ->maxSize(2048),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('donor_name')
            ->columns([
                TextColumn::make('receipt_number')
                    ->label('Receipt No.')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->fontFamily('mono')
                    ->placeholder('Pending'),

                TextColumn::make('donor_name')
                    ->label('Donor')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

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
                    }),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'verified' => 'success',
                        'pending' => 'warning',
                        'rejected' => 'danger',
                        default => 'gray',
                    }),

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
            ])
            ->headerActions([
                CreateAction::make()->label('Record Direct Offline Donation'),
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
                            ->required(),
                    ])
                    ->modalHeading('Reject Donation Submission')
                    ->action(function (Donation $record, array $data) {
                        app(DonationVerificationService::class)->reject($record, $data['admin_remarks'], auth()->id());
                        Notification::make()
                            ->title('Donation Rejected')
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
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
