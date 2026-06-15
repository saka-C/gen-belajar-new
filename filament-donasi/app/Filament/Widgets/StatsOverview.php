<?php

namespace App\Filament\Widgets;

use App\Models\Campaign;
use App\Models\Donasi;
use App\Models\Donatur;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [

            Stat::make(
                'Total Campaign',
                Campaign::count()
            )
            ->description('Campaign yang tersedia'),

            Stat::make(
                'Total Donatur',
                Donatur::count()
            )
            ->description('Jumlah donatur terdaftar'),

            Stat::make(
                'Total Donasi',
                'Rp ' . number_format(
                    Donasi::sum('nominal'),
                    0,
                    ',',
                    '.'
                )
            )
            ->description('Total dana terkumpul'),

        ];
    }
}