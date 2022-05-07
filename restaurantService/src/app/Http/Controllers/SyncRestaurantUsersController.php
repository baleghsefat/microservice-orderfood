<?php

namespace App\Http\Controllers;

use App\Http\Requests\SyncRestaurantUsersRequest;
use App\Models\Restaurant;
use App\Models\RestaurantUser;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class SyncRestaurantUsersController extends Controller
{
    /**
     * @param int $restaurantId RestaurantId
     * @param SyncRestaurantUsersRequest $request Request.
     * @return JsonResponse
     */
    public function __invoke(int $restaurantId, SyncRestaurantUsersRequest $request): JsonResponse
    {
        try {
            RestaurantUser::sync($restaurantId, $request->validated()[Restaurant::USER_IDS] ?? []);

            return $this->getResponse([]);
        } catch (Exception $e) {
            Log::error($e->getMessage());

            return $this->getResponse(['message' => 'An error occurred'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
