<?php

namespace App\Filament\Resources\TransactionResource\Pages;

use App\Filament\Resources\TransactionResource;
use App\Models\Vault;
use Filament\Facades\Filament;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateTransaction extends CreateRecord
{
    protected static string $resource = TransactionResource::class;

    protected static ?string $model = Vault::class;

    protected static ?string $title = 'Adicionar Registro';

    protected function handleRecordCreation(array $data): Model
    {
        $record = new ($this->getModel())($data);

        if (
            static::getResource()::isScopedToTenant() &&
            ($tenant = Filament::getTenant())
        ) {
            return $this->associateRecordWithTenant($record, $tenant);
        }

        $record->save();

        return $record;
    }

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
