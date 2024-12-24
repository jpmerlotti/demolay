<?php

namespace App\Filament\Resources\LeadingResource\Pages;

use App\Filament\Resources\LeadingResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLeading extends EditRecord
{
    protected static string $resource = LeadingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
