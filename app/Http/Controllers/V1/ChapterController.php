<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChapterRequest;
use App\Services\ApiServices\ApiResponder;
use App\Services\V1\ChapterService;
use Illuminate\Http\JsonResponse;

class ChapterController extends Controller
{
    public function __construct(
        protected ChapterService $service,
        protected ApiResponder $responder
    ) {}

    public function store(ChapterRequest $request): JsonResponse
    {
        $response = $this->service->create($request->validated());

        return $this->responder->success($response->toArray());
    }
}
