<?php

namespace App\Services\V1;

use App\Models\Chapter;
use App\Services\Service;

class ChapterService extends Service
{
    public function create(array $data): Chapter
    {
        $data = $this->prepareData($data);

        $chapter = Chapter::create($data);
        $chapter->vault()->create();

        return $chapter;
    }

    public function prepareData(array $data): array
    {
        $wrong = ['á', 'í', 'ó', 'é', 'ã', 'õ', 'â', 'ô', 'à', ' '];
        $correct = ['a', 'i', 'o', 'e', 'a', 'o', 'a', 'o', 'a', '_'];
        $data['tenant'] = str_replace($wrong, $correct, strtolower($data['name']));

        return $data;
    }
}
