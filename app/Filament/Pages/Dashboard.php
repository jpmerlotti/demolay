<?php

namespace App\Filament\Pages;

use App\Filament\Resources\MembersResource\Widgets\MembersOverview;
use App\Filament\Widgets\BalanceOverview;
use Filament\Actions\Action;
use Filament\Actions\StaticAction;
use Filament\Facades\Filament;
use Filament\Pages\Dashboard as Base;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;

class Dashboard extends Base
{
    public $defaultAction = 'inactiveChapterMessage';
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

    public function inactiveChapterMessageAction(): ?Action
    {
        return Action::make('inactiveChapterMessage')
            ->modalHeading("Capítulo Inativo")
            ->modalDescription('Lamentamos informar que seu capítulo está inativo, portanto as funcionalidades do sistema estão reduzidas, para corrigir isso, regularize a assinatura do sistema.')
            ->modalSubmitAction(fn() => Action::make('test')
                ->label('Regularizar')
                ->color('success')
                ->url(fn() => route('contact')))
            ->visible(fn(): bool => ! Filament::getTenant()->is_active ? true : false);
    }

    public function getVisibleWidgets(): array
    {
        return $this->getWidgets();
    }
}
