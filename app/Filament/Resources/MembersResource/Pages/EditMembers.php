<?php

namespace App\Filament\Resources\MembersResource\Pages;

use App\Filament\Resources\MembersResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMembers extends EditRecord
{

    protected static string $resource = MembersResource::class;
    protected static ?string $title = 'Editar DeMolay';

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()->label('Remover')->icon('heroicon-o-trash'),
        ];
    }
}
