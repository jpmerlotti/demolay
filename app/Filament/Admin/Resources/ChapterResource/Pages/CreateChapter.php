<?php

namespace App\Filament\Admin\Resources\ChapterResource\Pages;

use App\Filament\Admin\Resources\ChapterResource;
use App\Models\Chapter;
use App\Services\V1\ChapterService;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateChapter extends CreateRecord
{
    protected static string $resource = ChapterResource::class;

    protected static ?string $title = 'Adicionar Capítulo';

    protected function handleRecordCreation(array $data): Model
    {
        $service = new ChapterService();

        $record = new Chapter();

        try {
            $record = $service->create($data);
        } catch (\Exception $e) {
            Notification::make()
                ->danger()
                ->title('Erro na criação do capítulo')
                ->body($e->getMessage());
        }

        return $record;
    }
}
