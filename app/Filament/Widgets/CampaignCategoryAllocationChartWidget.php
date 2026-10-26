<?php

namespace App\Filament\Widgets;

use App\Models\CauseCategory;
use Filament\Widgets\ChartWidget;

class CampaignCategoryAllocationChartWidget extends ChartWidget
{
    protected ?string $heading = 'Funds Raised by Cause Category';

    protected ?string $description = 'Audited donations allocated across active mission areas';

    protected static ?int $sort = 5;

    protected ?string $maxHeight = '280px';

    public function getType(): string
    {
        return 'pie';
    }

    public function getData(): array
    {
        $categories = CauseCategory::query()
            ->withSum(['campaigns' => function ($query) {
                $query->where('status', 'active');
            }], 'raised_amount')
            ->get();

        $labels = [];
        $data = [];

        foreach ($categories as $category) {
            $raised = (float) ($category->campaigns_sum_raised_amount ?? 0);
            if ($raised > 0) {
                $labels[] = $category->name;
                $data[] = round($raised, 2);
            }
        }

        // If no active campaigns have raised funds yet, show top categories with 0.00
        if (empty($data)) {
            foreach ($categories->take(5) as $category) {
                $labels[] = $category->name;
                $data[] = 0.0;
            }
        }

        return [
            'datasets' => [
                [
                    'label' => 'Raised (₹)',
                    'data' => $data,
                    'backgroundColor' => [
                        '#10b981', // Emerald
                        '#0ea5e9', // Sky Blue
                        '#8b5cf6', // Violet
                        '#f59e0b', // Amber
                        '#ec4899', // Pink
                        '#64748b', // Slate
                    ],
                    'borderColor' => '#ffffff',
                    'borderWidth' => 2,
                    'hoverOffset' => 6,
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
                    'position' => 'bottom',
                    'labels' => [
                        'boxWidth' => 12,
                        'padding' => 16,
                    ],
                ],
            ],
        ];
    }
}
