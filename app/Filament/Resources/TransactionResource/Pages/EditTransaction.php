<?php

namespace App\Filament\Resources\TransactionResource\Pages;

use App\Filament\Resources\TransactionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTransaction extends EditRecord
{
    protected static string $resource = TransactionResource::class;
    protected static ?string $title = 'Editar Registro';

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()->label('Remover')->icon('heroicon-o-trash'),
        ];
    }

    protected function getRedirectUrl(): ?string
    {
        return self::$resource::getUrl('index');
    }

    /**
     * @return array<Action | ActionGroup>
     */
    public function getFormActions(): array
    {
        return [
            $this->getSaveFormAction()->label('Salvar'),
            $this->getCancelFormAction()->label('Cancelar'),
        ];
    }
}
