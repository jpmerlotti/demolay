<?php

namespace App\Filament\Admin\Pages;

use App\Filament\Admin\Resources\ChapterResource\Widgets\ChaptersOverview;
use App\Filament\Admin\Resources\UserResource\Widgets\UsersOverview;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;

class AdminDashboard extends BaseDashboard
{
    protected static ?string $navigationIcon = 'heroicon-s-home';

    public function getWidgets(): array
    {
        return [
            AccountWidget::class,
            FilamentInfoWidget::class,
            UsersOverview::class,
            ChaptersOverview::class,
        ];
    }

    public function getVisibleWidgets(): array
    {
        return $this->getWidgets();
    }
}
