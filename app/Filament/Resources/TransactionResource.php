<?php

namespace App\Filament\Resources;

use App\Enums\TransactionTypesEnum;
use App\Filament\Forms\Components\MoneyField;
use App\Filament\Resources\TransactionResource\Pages;
use App\Filament\Resources\TransactionResource\RelationManagers\TransactionsRelationManager;
use App\Filament\Widgets\BalanceOverview;
use App\Models\Vault;
use Filament\Facades\Filament;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class TransactionResource extends Resource
{
    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $model = Vault::class;

    protected static ?string $navigationGroup = 'Tesouraria';

    protected static ?string $navigationLabel = 'Controle de Caixa';

    protected static ?string $navigationIcon = 'heroicon-s-banknotes';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('type')->label('Tipo da Transação')
                    ->required()
                    ->options(function () {
                        foreach (TransactionTypesEnum::cases() as $key => $value) {
                            dd($key, $value);
                        }
                    })
                    ->placeholder('Selecione o tipo da transação')
                    ->columnSpan(1),
                MoneyField::make('amount_cents')
                    ->required()
                    ->label('Total')
                    ->rules([
                        function () {
                            return function ($state) {
                                $state = intval(str_replace('.', '', str_replace(',', '.', $state)));
                                return $state;
                            };
                        },
                    ])
                    ->formatStateUsing(fn(?string $state): string => number_format(floatval($state / 100), 2, ',', '.'))
                    ->dehydrateStateUsing(fn(?string $state): string => intval(str_replace('.', '', str_replace(',', '', $state))))
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
                    ])
            ])->columns([
                'sm' => 1,
                'md' => 2
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->heading('Entradas/Saídas')
            ->query(fn() => Filament::getTenant()->vault->transactions())
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
                Tables\Actions\EditAction::make()->label('Editar'),
            ])
            ->emptyStateHeading('Nenhum registro ainda.');
    }

    public static function getRelations(): array
    {
        return [
            TransactionsRelationManager::class,
        ];
    }

    public static function getWidgets(): array
    {
        return [
            BalanceOverview::class,
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
