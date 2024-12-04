<?php

namespace App\Filament\Resources\TransactionResource\RelationManagers;

use App\Enums\TransactionTypesEnum;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class TransactionsRelationManager extends RelationManager
{
    protected static string $relationship = 'transactions';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('id')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->heading('Entradas/Saídas')
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
                    ->prefix('R$ ')->formatStateUsing(fn ($state) => number_format($state / 100, 2, ',', ' ')),
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
}
