<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;

class DonasiChart extends ChartWidget
{
    protected ?string $heading = 'Grafik Donasi';

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Donasi',
                    'data' => [
                        500000,
                        1000000,
                        2500000,
                        4000000,
                        3000000,
                        6000000,
                    ],
                ],
            ],

            'labels' => [
                'Jan',
                'Feb',
                'Mar',
                'Apr',
                'Mei',
                'Jun',
            ],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
