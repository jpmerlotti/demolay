<?php

namespace App\Filament\Admin\Resources\ChapterResource\Widgets;

use Filament\Widgets\ChartWidget;

class ChaptersOverview extends ChartWidget
{
    protected static ?string $heading = 'Chart';

    protected function getData(): array
    {
        return [
            //
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
