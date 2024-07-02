<?php

namespace App\Filament\Resources;

use App\Enums\TransactionTypesEnum;
use App\Filament\Resources\TransactionResource\Pages;
use App\Filament\Resources\TransactionResource\RelationManagers;
use App\Filament\Resources\TransactionResource\Widgets\BalanceOverview;
use App\Filament\Forms\Components\MoneyField;
use App\Models\Transaction;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ViewField;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\RawJs;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;
    protected static ?string $navigationGroup = 'Tesouraria';
    protected static ?string $navigationLabel = 'Controle de Caixa';
    protected static ?string $navigationIcon = 'heroicon-s-banknotes';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('type')->label('Tipo da Transação')
                ->required()
                ->options(
                    TransactionTypesEnum::class
                )
                ->placeholder('Selecione o tipo da transação'),
                // TextInput::make('amount_cents')->mask(RawJs::make(<<<'JS'
                //     $money($input, ',', ' ', 2)
                // JS))
                // ->stripCharacters(',')->prefix('R$')
                // ->numeric(),
                MoneyField::make('amount_cents')->label('Total')->rules([function () {
                    return function ($state) {
                        $state = intval(str_replace('.', '', str_replace(',', '.', $state)));
                        return $state;
                };},])->formatStateUsing(fn (?string $state): string => number_format(floatval($state / 100), 2, ',', '.'))
                ->dehydrateStateUsing(fn (?string $state): string => intval(str_replace('.', '', str_replace(',', '', $state)))),
                TextInput::make('description')->label('Descrição')
                ->maxLength(255)->datalist([
                    'Anuidade',
                    'Arrecadação',
                    'Elevação',
                    'Iniciação de novos membros',
                    'Jantar',
                    'Mensalidade das Lojas',
                    'Mensalidade Priorado Alvorecer',
                    'Mensalidade GCESP'
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('type')->label('Tipo de Transação')->alignCenter()
                ->badge()->color(fn (string $state): string => match ($state) {
                    TransactionTypesEnum::Entrada->value => 'success',
                    TransactionTypesEnum::Saída->value => 'danger'
                })->formatStateUsing(fn (string $state): string => match ($state) {
                    TransactionTypesEnum::Entrada->value => 'Entrada',
                    TransactionTypesEnum::Saída->value => 'Saída'
                }),
                TextColumn::make('amount_cents')->label('Valor Total')
                ->prefix('R$ ')->formatStateUsing(fn ($state) => number_format($state/100, 2, ',', ' ')),
                TextColumn::make('description')->label('Descrição'),
            ])
            ->filters([
                SelectFilter::make('type')->label('Tipos de transação')->options([
                    'entry' => 'Entradas',
                    'expense' => 'Saídas'
                ])
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label('Editar'),
            ])
            ->emptyStateHeading('Nenhum registro ainda.');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }


    public static function getWidgets(): array
    {
        return [
            BalanceOverview::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTransactions::route('/'),
            'create' => Pages\CreateTransaction::route('/create'),
            'edit' => Pages\EditTransaction::route('/{record}/edit'),
        ];
    }
}
