<?php

namespace App\Filament\Widgets;

use App\Models\ContactInquiry;
use App\Models\EventRegistration;
use App\Models\Volunteer;
use Filament\Widgets\ChartWidget;

class CommunityEngagementChartWidget extends ChartWidget
{
    protected ?string $heading = 'Community Growth & Applications Activity';

    protected ?string $description = 'Monthly volunteer applicants, event registrations, and outreach inquiries';

    protected static ?int $sort = 4;

    protected ?string $maxHeight = '280px';

    public ?string $filter = '6m';

    protected function getFilters(): ?array
    {
        return [
            '6m' => 'Last 6 Months',
            '12m' => 'Last 12 Months',
        ];
    }

    public function getType(): string
    {
        return 'bar';
    }

    public function getData(): array
    {
        $monthsCount = $this->filter === '12m' ? 12 : 6;

        $labels = [];
        $volunteersData = [];
        $registrationsData = [];
        $inquiriesData = [];

        for ($i = $monthsCount - 1; $i >= 0; $i--) {
            $date = now()->subMonthsNoOverflow($i);
            $start = $date->copy()->startOfMonth();
            $end = $date->copy()->endOfMonth();

            $labels[] = $date->format('M Y');

            $volunteersData[] = Volunteer::query()
                ->whereBetween('created_at', [$start, $end])
                ->count();

            $registrationsData[] = EventRegistration::query()
                ->whereBetween('created_at', [$start, $end])
                ->count();

            $inquiriesData[] = ContactInquiry::query()
                ->whereBetween('created_at', [$start, $end])
                ->count();
        }

        return [
            'datasets' => [
                [
                    'label' => 'Volunteer Applicants',
                    'data' => $volunteersData,
                    'backgroundColor' => '#10b981',
                    'borderRadius' => 6,
                ],
                [
                    'label' => 'Event Registrations',
                    'data' => $registrationsData,
                    'backgroundColor' => '#6366f1',
                    'borderRadius' => 6,
                ],
                [
                    'label' => 'Public Inquiries',
                    'data' => $inquiriesData,
                    'backgroundColor' => '#f59e0b',
                    'borderRadius' => 6,
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
                        'stepSize' => 1,
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
