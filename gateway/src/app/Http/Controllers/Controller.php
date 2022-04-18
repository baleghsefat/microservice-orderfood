<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    /**
     * @param array|null $message Message.
     * @param int $statusCode StatusCode.
     * @param array|null $heathers Headers.
     *
     * @return JsonResponse
     */
    protected function getResponse(
        ?array $message = null,
        int $statusCode = Response::HTTP_OK,
        ?array $heathers = []
    ): JsonResponse
    {
        return response()->json(['data' => $message], $statusCode, $heathers);
    }
}
