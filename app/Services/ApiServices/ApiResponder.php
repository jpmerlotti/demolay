<?php

namespace App\Services\ApiServices;

use App\Services\Service;
use Illuminate\Http\JsonResponse;

class ApiResponder extends Service
{
    public function success(array $data = [], string $msg = 'Success', int $code = 200): JsonResponse
    {
        return response([
            'message' => $msg,
            'data' => $data,
            'code' => $code,
        ], $code)->json();
    }

    public function error(array $errors = [], string $msg = 'Error', int $code = 500): JsonResponse
    {
        return response([
            'message' => $msg,
            'errors' => $errors,
            'code' => $code,
        ], $code)->json();
    }
}
