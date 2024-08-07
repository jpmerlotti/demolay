<?php

namespace App\Filament\Resources\MembersResource\Pages;

use App\Filament\Resources\MembersResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateMembers extends CreateRecord
{
    protected static string $resource = MembersResource::class;
    protected static ?string $title = 'Adicionar DeMolay';

    protected function getRedirectUrl(): string
    {
        return self::$resource::getUrl('index');
    }

}
