<?php

namespace App\Filament\Pages\Vault;

use App\Enums\TransactionTypesEnum;
use App\Filament\Forms\Components\MoneyField;
use App\Filament\Pages\CustomPage;
use App\Models\Transaction;
use App\Services\V1\TransactionService;
use Filament\Actions\Action as ActionsAction;
use Filament\Facades\Filament;
use Filament\Forms\Components\Actions;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Illuminate\Contracts\Support\Htmlable;
use Leandrocfe\FilamentPtbrFormFields\Money;

class EditTransaction extends CustomPage
{
    protected static string $view = 'filament.pages.vault.edit-transaction';

    // protected static bool $shouldRegisterNavigation = false;

    public Transaction $transaction;

    public array $data = [
        'type' => '',
        'amount_cents' => '',
        'description' => '',
    ];

    public function getTitle(): string|Htmlable
    {
        return 'Editar Transação';
    }

    public static function getRoutePath(): string
    {
        return '/vault/transaction/{id}/edit';
    }

    public function mount(int $id): void
    {
        $this->transaction = Transaction::findOrFail($id);

        $this->data = [
            'type' => $this->transaction->type,
            'amount_cents' => $this->transaction->amount_cents,
            'description' => $this->transaction->description,
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            ActionsAction::make('delete')->label('Remover Registro')
                ->color('danger')
                ->icon('heroicon-s-x-mark')
                ->action(fn() => $this->delete()),
        ];
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('type')
                    ->label('Tipo da Transação')
                    ->required()
                    ->options(
                        TransactionTypesEnum::toArray()
                    )
                    ->placeholder('Selecione o tipo da transação'),
                MoneyField::make('amount_cents')
                    ->label('Valor Total')
                    ->required()
                    ->columnSpan(1),
                TextInput::make('description')->label('Descrição')
                    ->maxLength(255)->datalist([
                        'Anuidade',
                        'Arrecadação',
                        'Elevação',
                        'Iniciação de novos membros',
                        'Jantar',
                        'Mensalidade das Lojas',
                        'Mensalidade Priorado Alvorecer',
                        'Mensalidade GCESP',
                    ]),
                Actions::make([
                    Action::make('save')
                        ->label('Salvar')
                        ->color('warning')
                        ->action(fn() => $this->save()),
                    Action::make('cancel')
                        ->label('Cancelar')
                        ->outlined()
                        ->color('gray')
                        ->action(function () {
                            $this->form->fill();

                            redirect(route(VaultDashboard::getRouteName(), ['tenant' => Filament::getTenant()]));
                        }),
                ]),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();

        $service = new TransactionService;

        try {
            $service->update($this->transaction, $data);
        } catch (\Exception $e) {
            Notification::make()
                ->danger()
                ->title('Registro não atualizado')
                ->body($e->getMessage())
                ->send();

            return;
        }

        redirect(route(VaultDashboard::getRouteName(), ['tenant' => Filament::getTenant()]));

        Notification::make()
            ->success()
            ->title('Registro atualizado com sucesso')
            ->send();
    }

    public function delete()
    {
        $service = app(TransactionService::class);

        try {
            $service->delete($this->transaction);
        } catch (\Exception $e) {
            Notification::make()
                ->danger()
                ->title('Registro não excluído')
                ->body($e->getMessage())
                ->send();
        }

        redirect(route(VaultDashboard::getRouteName(), ['tenant' => Filament::getTenant()]));

        Notification::make()
            ->success()
            ->title('Registro excluído com sucesso')
            ->send();
    }
}
