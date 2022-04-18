<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Exception;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    /**
     * @param Request $request Request.
     * @return JsonResponse
     */
    public function login(Request $request): JsonResponse
    {
        try {
            $response = Http::post(userServiceRouter('v1/login'), $request->toArray());

            return response()->json($response->json(), $response->status());
        } catch (Exception $e) {
            Log::error($e);

            return $this->getResponse(
                ['message' => __('errors.error_occurred_tyr_again')],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
