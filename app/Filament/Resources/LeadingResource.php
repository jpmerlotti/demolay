<?php

namespace App\Filament\Resources;

use App\Filament\Clusters\Secretariat;
use App\Filament\Resources\LeadingResource\Pages;
use App\Filament\Resources\LeadingResource\RelationManagers;
use App\Models\Leading;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\SubNavigationPosition;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LeadingResource extends Resource
{
    protected static ?string $model = Leading::class;
    protected static ?string $cluster = Secretariat::class;

    protected static ?string $navigationLabel = 'Gestões';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListLeadings::route('/'),
            'create' => Pages\CreateLeading::route('/create'),
            'edit' => Pages\EditLeading::route('/{record}/edit'),
        ];
    }
}
