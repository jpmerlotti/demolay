<?php

namespace App\Filament\Resources\MembersResource\Widgets;

use App\Models\Demolay;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class MembersOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total de Membros', Demolay::all()->count()),
            Stat::make('Membros Ativos', Demolay::where('is_active', 1)->count()),
            Stat::make('Membros Inativos', Demolay::where('is_active', 0)->count()),
        ];
    }
}
