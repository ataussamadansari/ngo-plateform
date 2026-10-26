<?php

namespace App\Filament\Widgets;

use App\Models\Donation;
use App\Models\FundDistribution;
use Filament\Widgets\ChartWidget;

class MonthlyActivityChartWidget extends ChartWidget
{
    protected ?string $heading = 'Monthly Activity & Financial Flow';

    protected ?string $description = 'Verified donations (inflow) vs ground distributions (outflow)';

    protected static ?int $sort = 2;

    protected ?string $maxHeight = '280px';

    public ?string $filter = '6m';

    protected function getFilters(): ?array
    {
        return [
            '6m' => 'Last 6 Months',
            '12m' => 'Last 12 Months',
            'ytd' => 'Year to Date',
        ];
    }

    public function getType(): string
    {
        return 'line';
    }

    public function getData(): array
    {
        $monthsCount = match ($this->filter) {
            '12m' => 12,
            'ytd' => max(1, (int) now()->month),
            default => 6,
        };

        $labels = [];
        $donationsData = [];
        $distributionsData = [];

        for ($i = $monthsCount - 1; $i >= 0; $i--) {
            $date = now()->subMonthsNoOverflow($i);
            $start = $date->copy()->startOfMonth();
            $end = $date->copy()->endOfMonth();

            $labels[] = $date->format('M Y');

            $monthlyDonations = (float) Donation::query()
                ->where('status', 'verified')
                ->whereBetween('created_at', [$start, $end])
                ->sum('amount');

            $monthlyDistributions = (float) FundDistribution::query()
                ->where(function ($query) use ($start, $end) {
                    $query->whereBetween('distribution_date', [$start->toDateString(), $end->toDateString()])
                        ->orWhere(function ($q) use ($start, $end) {
                            $q->whereNull('distribution_date')
                                ->whereBetween('created_at', [$start, $end]);
                        });
                })
                ->sum('amount_spent');

            $donationsData[] = round($monthlyDonations, 2);
            $distributionsData[] = round($monthlyDistributions, 2);
        }

        return [
            'datasets' => [
                [
                    'label' => 'Verified Donations (₹)',
                    'data' => $donationsData,
                    'borderColor' => '#10b981',
                    'backgroundColor' => 'rgba(16, 185, 129, 0.12)',
                    'fill' => true,
                    'tension' => 0.35,
                    'pointBackgroundColor' => '#10b981',
                    'pointBorderColor' => '#ffffff',
                    'pointBorderWidth' => 2,
                    'pointRadius' => 4,
                    'pointHoverRadius' => 6,
                ],
                [
                    'label' => 'Funds Distributed (₹)',
                    'data' => $distributionsData,
                    'borderColor' => '#0ea5e9',
                    'backgroundColor' => 'rgba(14, 165, 233, 0.08)',
                    'fill' => true,
                    'tension' => 0.35,
                    'pointBackgroundColor' => '#0ea5e9',
                    'pointBorderColor' => '#ffffff',
                    'pointBorderWidth' => 2,
                    'pointRadius' => 4,
                    'pointHoverRadius' => 6,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getOptions(): array
    {
        return [
            'responsive' => true,
            'maintainAspectRatio' => false,
            'plugins' => [
                'legend' => [
                    'display' => true,
                    'position' => 'top',
                ],
            ],
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'ticks' => [
                        'precision' => 0,
                    ],
                ],
                'x' => [
                    'grid' => [
                        'display' => false,
                    ],
                ],
            ],
        ];
    }
}
