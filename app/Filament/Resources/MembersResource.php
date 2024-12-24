<?php

namespace App\Filament\Resources;

use App\Filament\Clusters\Secretariat;
use App\Filament\Resources\MembersResource\Pages;
use App\Models\Demolay;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Pages\SubNavigationPosition;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class MembersResource extends Resource
{
    protected static ?string $model = Demolay::class;
    protected static ?string $cluster = Secretariat::class;

    protected static ?string $navigationGroup = 'Membros';

    protected static ?string $navigationLabel = 'Membros';

    protected static ?string $navigationIcon = 'heroicon-s-user-group';
    // protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->label('Nome')->required(true),
                TextInput::make('phone')->label('Telefone')
                    ->prefixIcon('heroicon-s-phone')->mask('(99) 99999-9999')->required(true)
                    ->length(15),
                TextInput::make('sisdm')->label('ID SISDM')->prefixIcon('heroicon-s-identification'),
                DatePicker::make('birthdate')->label('Data de Nascimento')->required(true)
                    ->maxDate(now()->subYears(12)->toDateString()),
                Toggle::make('is_active')->label('Ativo')->default(true)
                    ->onColor('success')->offColor('danger')->inLine(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Nome')->alignCenter()
                    ->formatStateUsing(function (string $state) {
                        $arr = explode(' ', $state);
                        $state = $arr[0] . ' ' . $arr[count($arr) - 1];

                        return $state;
                    }),
                TextColumn::make('phone')->label('Telefone')->alignCenter()
                    ->copyable()->copyMessageDuration(1000)->copyMessage('Celular Copiado!'),
                TextColumn::make('sisdm')->label('ID')->alignCenter()
                    ->copyable()->copyMessageDuration(1000)->copyMessage('ID Copiado!')
                    ->formatStateUsing(fn(?string $state): string => $state ?? '--'),
                TextColumn::make('id')->label('Idade')->alignCenter()
                    ->formatStateUsing(function (Demolay $record) {
                        return $record->getAge() . ' anos';
                    }),
                TextColumn::make('is_active')->label('Ativo')->alignCenter()->badge()
                    ->color(fn(int $state): string => match ($state) {
                        1 => 'success',
                        0 => 'danger'
                    })->formatStateUsing(fn(int $state): string => match ($state) {
                        1 => 'Sim',
                        0 => 'Não'
                    }),
            ])
            ->filters([
                SelectFilter::make('is_active')->label('Ativo')
                    ->options([
                        true => 'Sim',
                        false => 'Não',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label('Editar'),
            ])
            ->emptyStateHeading('Nenhum demolay registrado ainda.')
            ->paginated([10, 15, 20, 25, 50, 100]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMembers::route('/'),
            'create' => Pages\CreateMembers::route('/create'),
            'edit' => Pages\EditMembers::route('/{record}/edit'),
        ];
    }
}
