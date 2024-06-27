<?php

namespace App\Filament\Resources\TransactionResource\Pages;

use App\Filament\Resources\TransactionResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTransaction extends CreateRecord
{
    protected static string $resource = TransactionResource::class;
    protected static ?string $title = 'Adicionar Registro';

    protected function getRedirectUrl(): string
    {
        return self::$resource::getUrl('index');
    }

    /**
     * @return array<Action | ActionGroup>
     */
    public function getFormActions(): array
    {
        return [
            $this->getCreateFormAction()->label('Salvar'),
            ...(static::canCreateAnother() ? [$this->getCreateAnotherFormAction()->label('Salvar e criar outro')] : []),
            $this->getCancelFormAction()->label('Cancelar'),
        ];
    }
}
