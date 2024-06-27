<?php

namespace App\Filament\Resources\MembersResource\Pages;

use App\Filament\Resources\MembersResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMembers extends ListRecords
{
    protected static string $resource = MembersResource::class;
    protected static ?string $title = 'Membros';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Adicionar DeMolay')->icon('heroicon-o-plus'),
        ];
    }
}
