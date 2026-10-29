<?php

namespace App\Filament\Resources\Donations\Pages;

use App\Filament\Resources\Donations\DonationResource;
use App\Models\Donation;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListDonations extends ListRecords
{
    protected static string $resource = DonationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
            Action::make('export_csv')
                ->label('Export Donations (Form 10BD / CSV)')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('gray')
                ->action(function () {
                    $records = Donation::with('campaign')->latest()->get();

                    $headers = [
                        'Content-Type' => 'text/csv; charset=UTF-8',
                        'Content-Disposition' => 'attachment; filename="donations-ledger-'.now()->format('Y-m-d').'.csv"',
                    ];

                    $callback = function () use ($records) {
                        $handle = fopen('php://output', 'w');
                        fwrite($handle, "\xEF\xBB\xBF");

                        fputcsv($handle, [
                            'Receipt Number',
                            'Donation Date',
                            'Donor Name',
                            'Donor Email',
                            'Donor Phone',
                            'Donor PAN',
                            'Amount (INR)',
                            'Payment Mode',
                            'UTR Number',
                            'Campaign / Cause',
                            'Status',
                            'Verified At',
                        ]);

                        foreach ($records as $donation) {
                            fputcsv($handle, [
                                $donation->receipt_number ?? 'Pending',
                                $donation->created_at?->format('Y-m-d H:i:s'),
                                $donation->donor_name,
                                $donation->donor_email ?? '',
                                $donation->donor_phone ?? '',
                                $donation->donor_pan ?? '',
                                number_format((float) $donation->amount, 2, '.', ''),
                                $donation->payment_mode,
                                $donation->utr_number ?? '',
                                $donation->campaign?->title ?? 'General Fund',
                                ucfirst($donation->status),
                                $donation->verified_at?->format('Y-m-d H:i:s') ?? '',
                            ]);
                        }

                        fclose($handle);
                    };

                    return response()->stream($callback, 200, $headers);
                }),
        ];
    }
}
