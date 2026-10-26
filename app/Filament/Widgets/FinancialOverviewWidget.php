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

        $raisedTrend = [];
        $distributedTrend = [];

        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonthsNoOverflow($i);
            $start = $month->copy()->startOfMonth();
            $end = $month->copy()->endOfMonth();

            $raisedTrend[] = (float) Donation::query()
                ->where('status', 'verified')
                ->whereBetween('created_at', [$start, $end])
                ->sum('amount');

            $distributedTrend[] = (float) FundDistribution::query()
                ->where(function ($query) use ($start, $end) {
                    $query->whereBetween('distribution_date', [$start->toDateString(), $end->toDateString()])
                        ->orWhere(function ($q) use ($start, $end) {
                            $q->whereNull('distribution_date')
                                ->whereBetween('created_at', [$start, $end]);
                        });
                })
                ->sum('amount_spent');
        }

        $treasuryTrend = array_map(
            fn (float $r, float $d): float => max(0, $r - $d),
            $raisedTrend,
            $distributedTrend
        );

        return [
            Stat::make('Total Verified Raised', '₹'.number_format($totalRaised, 2))
                ->description('Audited donor funds')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart($raisedTrend)
                ->color('success'),

            Stat::make('Ground Distributed', '₹'.number_format($totalDistributed, 2))
                ->description('Direct field expenditure')
                ->descriptionIcon('heroicon-m-arrow-trending-down')
                ->chart($distributedTrend)
                ->color('info'),

            Stat::make('Net Treasury Balance', '₹'.number_format($netTreasury, 2))
                ->description('Available unallocated treasury')
                ->descriptionIcon('heroicon-m-banknotes')
                ->chart($treasuryTrend)
                ->color('primary'),

            Stat::make('Pending Verifications', (string) $pendingCount)
                ->description($pendingCount > 0 ? 'Awaiting UTR reconciliation' : 'Queue clear')
                ->descriptionIcon('heroicon-m-clock')
                ->color($pendingCount > 0 ? 'warning' : 'gray'),
        ];
    }
}
