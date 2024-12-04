<?php

namespace App\Filament\Pages\Vault;

use App\Filament\Pages\CustomPage;
use App\Filament\Widgets\BalanceOverview;
use Filament\Actions\Action;
use Filament\Facades\Filament;
use Illuminate\Contracts\Support\Htmlable;

class VaultDashboard extends CustomPage
{
    protected static bool $shouldRegisterNavigation = true;

    protected static ?int $navigationSort = 9;

    protected static ?string $navigationGroup = 'Tesouraria';

    protected static ?string $navigationLabel = 'Controle de caixa';

    protected static ?string $navigationIcon = 'heroicon-s-banknotes';

    protected static ?string $title = 'Cofre';

    protected static string $view = 'filament.pages.vault.vault-dashboard';

    public function mount(): void
    {
        $this->record = Filament::getTenant()->vault;
    }

    public static function getRoutePath(): string
    {
        return '/vault';
    }

    public function getTitle(): string|Htmlable
    {
        return 'Cofre';
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('create')
                ->label('Adicionar Registro')
                ->icon('heroicon-s-plus')
                ->action(fn () => redirect(route(CreateTransaction::getRouteName(), ['tenant' => Filament::getTenant()]))),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            BalanceOverview::class,
        ];
    }
}
