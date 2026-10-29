<?php

namespace App\Filament\Resources\FundDistributions\Pages;

use App\Filament\Resources\FundDistributions\FundDistributionResource;
use App\Models\FundDistribution;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListFundDistributions extends ListRecords
{
    protected static string $resource = FundDistributionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
            Action::make('export_csv')
                ->label('Export Utilization Ledger CSV')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('gray')
                ->action(function () {
                    $records = FundDistribution::with('campaign')->latest('distribution_date')->get();

                    $headers = [
                        'Content-Type' => 'text/csv; charset=UTF-8',
                        'Content-Disposition' => 'attachment; filename="fund-utilization-ledger-'.now()->format('Y-m-d').'.csv"',
                    ];

                    $callback = function () use ($records) {
                        $handle = fopen('php://output', 'w');
                        fwrite($handle, "\xEF\xBB\xBF");

                        fputcsv($handle, [
                            'Expenditure Title',
                            'Disbursement Date',
                            'Beneficiary / Vendor',
                            'Amount Disbursed (INR)',
                            'Payment Reference',
                            'Campaign / Cause',
                            'Public Status',
                            'Description',
                        ]);

                        foreach ($records as $dist) {
                            fputcsv($handle, [
                                $dist->title,
                                $dist->distribution_date?->format('Y-m-d') ?? '',
                                $dist->beneficiary_name,
                                number_format((float) $dist->amount_spent, 2, '.', ''),
                                $dist->payment_reference ?? '',
                                $dist->campaign?->title ?? 'General Humanitarian Fund',
                                $dist->is_public ? 'Public' : 'Internal',
                                $dist->description,
                            ]);
                        }

                        fclose($handle);
                    };

                    return response()->stream($callback, 200, $headers);
                }),
        ];
    }
}
