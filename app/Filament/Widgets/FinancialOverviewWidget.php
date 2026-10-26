<?php

namespace App\Filament\Widgets;

use App\Models\Donation;
use App\Models\FundDistribution;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class FinancialOverviewWidget extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $totalRaised = (float) Donation::where('status', 'verified')->sum('amount');
        $totalDistributed = (float) FundDistribution::sum('amount_spent');
        $netTreasury = max(0, $totalRaised - $totalDistributed);
        $pendingCount = Donation::where('status', 'pending')->count();

        return [
            Stat::make('Total Verified Raised', '₹'.number_format($totalRaised, 2))
                ->description('Audited donor funds')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),

            Stat::make('Ground Distributed', '₹'.number_format($totalDistributed, 2))
                ->description('Direct field expenditure')
                ->descriptionIcon('heroicon-m-arrow-trending-down')
                ->color('info'),

            Stat::make('Net Treasury Balance', '₹'.number_format($netTreasury, 2))
                ->description('Available unallocated treasury')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('primary'),

            Stat::make('Pending Verifications', (string) $pendingCount)
                ->description($pendingCount > 0 ? 'Awaiting UTR reconciliation' : 'Queue clear')
                ->descriptionIcon('heroicon-m-clock')
                ->color($pendingCount > 0 ? 'warning' : 'gray'),
        ];
    }
}
