<?php

namespace App\Filament\Resources\TransactionResource\Widgets;

use App\Models\Transaction;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class BalanceOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total', Transaction::getBalance())->icon('heroicon-o-banknotes'),
            Stat::make('Entradas', Transaction::where('type', 'entry')->count())
                ->icon('heroicon-o-arrow-left-end-on-rectangle'),
            Stat::make('Saídas', Transaction::where('type', 'expense')->count())
                ->icon('heroicon-o-arrow-right-start-on-rectangle'),

        ];
    }
}
