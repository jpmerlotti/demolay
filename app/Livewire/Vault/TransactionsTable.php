<?php

namespace App\Livewire\Vault;

use App\Enums\TransactionTypesEnum;
use App\Filament\Pages\Vault\EditTransaction;
use App\Models\Transaction;
use App\Models\Vault;
use Filament\Facades\Filament;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Livewire\Component;

class TransactionsTable extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    public Vault $vault;

    public function table(Table $table): Table
    {
        return $table
            ->heading('Transações')
            ->description('Listagem de todas as entradas e saídas do caixa do capítulo')
            ->emptyStateHeading('Nenhuma transação registrada')
            ->emptyStateDescription('Suas transações serão exibidas aqui')
            ->query(fn() => $this->vault->transactions()->orderBy('created_at', 'desc')->limit(5))
            ->columns([
                TextColumn::make('type')->label('Tipo de Transação')->alignCenter()
                    ->badge()->color(fn(string $state): string => match ($state) {
                        TransactionTypesEnum::Entry->value => 'success',
                        TransactionTypesEnum::Expense->value => 'danger'
                    })->formatStateUsing(fn(string $state): string => match ($state) {
                        TransactionTypesEnum::Entry->value => 'Entrada',
                        TransactionTypesEnum::Expense->value => 'Saída'
                    }),
                TextColumn::make('amount_cents')->label('Valor Total')
                    ->prefix('R$ ')->formatStateUsing(fn($state) => number_format($state / 100, 2, ',', ' ')),
                TextColumn::make('description')->label('Descrição'),
            ])
            ->filters([
                SelectFilter::make('type')->label('Tipos de transação')->options([
                    'entry' => 'Entradas',
                    'expense' => 'Saídas',
                ]),
            ])
            ->actions([
                Action::make('edit')->label('Editar')
                    ->icon('heroicon-s-pencil-square')
                    ->action(fn(Transaction $record) => redirect(route(EditTransaction::getRouteName(), ['tenant' => Filament::getTenant(), 'id' => $record->id]))),
            ])
            ->paginated(true)
            ->paginated([10, 15, 20, 50, 100]);
    }

    public function render()
    {
        return view('livewire.vault.transactions-table');
    }
}
