<?php

namespace App\Filament\Widgets;

use Filament\Facades\Filament;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class BalanceOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total', Filament::getTenant()->vault->getBalance())->icon('heroicon-o-banknotes'),
            Stat::make('Entradas', Filament::getTenant()->vault->getEntrys()->count())
                ->icon('heroicon-o-arrow-left-end-on-rectangle'),
            Stat::make('Saídas', Filament::getTenant()->vault->getExpenses()->count())
                ->icon('heroicon-o-arrow-right-start-on-rectangle'),

        ];
    }
}
