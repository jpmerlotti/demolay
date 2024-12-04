<?php

namespace App\Filament\Pages;

use App\Filament\Resources\MembersResource\Widgets\MembersOverview;
use App\Filament\Widgets\BalanceOverview;
use Filament\Pages\Dashboard as Base;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;

class Dashboard extends Base
{
    protected static ?string $navigationIcon = 'heroicon-s-home';

    public function getWidgets(): array
    {
        return [
            AccountWidget::class,
            FilamentInfoWidget::class,
            MembersOverview::class,
            BalanceOverview::class,
        ];
    }

    public function getVisibleWidgets(): array
    {
        return $this->getWidgets();
    }
}
