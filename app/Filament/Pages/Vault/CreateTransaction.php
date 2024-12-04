<?php

namespace App\Filament\Pages\Vault;

use App\Enums\TransactionTypesEnum;
use App\Filament\Pages\CustomPage;
use App\Models\Vault;
use App\Services\V1\TransactionService;
use Filament\Facades\Filament;
use Filament\Forms\Components\Actions;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Illuminate\Contracts\Support\Htmlable;
use Leandrocfe\FilamentPtbrFormFields\Money;

class CreateTransaction extends CustomPage
{
    protected static string $view = 'filament.pages.vault.create-transaction';

    // protected static bool $shouldRegisterNavigation = false;

    protected static ?string $title = 'Adicionar Transação';

    public array $data = [];

    public function mount(): void
    {
        $this->record = Filament::getTenant()->vault;
    }

    public function getTitle(): string|Htmlable
    {
        return 'Adicionar Transação';
    }

    public static function getRoutePath(): string
    {
        return '/vault/transaction/create';
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('type')->label('Tipo da Transação')
                    ->required()
                    ->options(
                        TransactionTypesEnum::toArray()
                    )
                    ->placeholder('Selecione o tipo da transação')
                    ->columnSpan(1),
                Money::make('amount_cents')
                    ->label('Total')
                    ->required()
                    ->rules([function () {
                        return function ($state) {
                            $state = intval(str_replace('.', '', str_replace(',', '.', $state)));

                            return $state;
                        };
                    }])
                    ->formatStateUsing(fn(?string $state): string => number_format(floatval($state / 100), 2, ',', '.'))
                    ->dehydrateStateUsing(fn(?string $state): string => intval(str_replace('.', '', str_replace(',', '', $state))))
                    ->columns(1),
                Textarea::make('description')
                    ->label('Descrição')
                    ->maxLength(255)
                    ->columnSpan([
                        'sm' => 1,
                        'md' => 2
                    ]),
                Actions::make([
                    Action::make('save')
                        ->label('Salvar')
                        ->color('primary')
                        ->action(fn() => $this->create()),
                    Action::make('cancel')
                        ->label('Cancelar')
                        ->color('gray')
                        ->outlined()
                        ->action(function () {
                            $this->form->fill();

                            redirect(route(VaultDashboard::getRouteName(), ['tenant' => Filament::getTenant()]));
                        }),
                ]),
            ])->columns([
                'sm' => 1,
                'md' => 2
            ])
            ->statePath('data');
    }

    public function create(): void
    {
        $data = $this->form->getState();

        $service = new TransactionService;

        try {
            if (! $this->record instanceof Vault) {
                throw new \Exception('Cofre não encontrado');
            }

            $service->create($this->record, $data);
        } catch (\Exception $e) {
            Notification::make()
                ->danger()
                ->title('Registro não criado')
                ->body($e->getMessage())
                ->send();

            return;
        }

        $this->form->fill();

        redirect(route(VaultDashboard::getRouteName(), ['tenant' => Filament::getTenant()]));

        Notification::make()
            ->success()
            ->title('Registro criado com sucesso')
            ->send();
    }
}
