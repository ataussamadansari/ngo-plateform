<?php

namespace App\Filament\Widgets;

use App\Models\Donation;
use Filament\Widgets\ChartWidget;

class DonationPaymentModesChartWidget extends ChartWidget
{
    protected ?string $heading = 'Donation Channels';

    protected ?string $description = 'Verified contributions by payment method';

    protected static ?int $sort = 3;

    protected ?string $maxHeight = '280px';

    public ?string $filter = 'amount';

    protected function getFilters(): ?array
    {
        return [
            'amount' => 'By Amount (₹)',
            'count' => 'By Transaction Count',
        ];
    }

    public function getType(): string
    {
        return 'doughnut';
    }

    public function getData(): array
    {
        $byCount = $this->filter === 'count';

        $modes = [
            'upi_qr' => 'UPI QR',
            'bank_transfer' => 'Bank Transfer',
            'cash' => 'Cash',
        ];

        $labels = [];
        $data = [];

        foreach ($modes as $key => $label) {
            $query = Donation::query()
                ->where('status', 'verified')
                ->where('payment_mode', $key);

            $val = $byCount
                ? (int) $query->count()
                : (float) $query->sum('amount');

            $labels[] = $label;
            $data[] = $byCount ? $val : round($val, 2);
        }

        return [
            'datasets' => [
                [
                    'label' => $byCount ? 'Transactions' : 'Amount (₹)',
                    'data' => $data,
                    'backgroundColor' => [
                        '#10b981', // Emerald for UPI QR
                        '#0ea5e9', // Sky Blue for Bank Transfer
                        '#f59e0b', // Amber for Cash
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
            'cutout' => '65%',
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
