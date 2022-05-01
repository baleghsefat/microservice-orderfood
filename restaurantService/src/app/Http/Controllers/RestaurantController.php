<?php

namespace App\Http\Controllers;

use App\Http\Requests\RestaurantRequest;
use App\Http\Resources\RestaurantResources;
use App\Models\Restaurant;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class RestaurantController extends Controller
{
    /**
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        return RestaurantResources::collection(Restaurant::query()->paginate());
    }

    /**
     * @param int $restaurantId RestaurantId.
     * @return RestaurantResources
     */
    public function show(int $restaurantId): RestaurantResources
    {
        $restaurant = Restaurant::query()->findOrFail($restaurantId);

        return new RestaurantResources($restaurant);
    }

    /**
     * @param RestaurantRequest $restaurantRequest RestaurantRequest.
     * @return RestaurantResources
     */
    public function store(RestaurantRequest $restaurantRequest): RestaurantResources
    {
        $restaurant = Restaurant::query()->create($restaurantRequest->validated());

        return new RestaurantResources($restaurant);
    }

    /**
     * @param int $restaurantId RestaurantId.
     * @param RestaurantRequest $restaurantRequest RestaurantRequest.
     * @return RestaurantResources
     */
    public function update(int $restaurantId, RestaurantRequest $restaurantRequest): RestaurantResources
    {
        $restaurant = Restaurant::query()->findOrFail($restaurantId);
        $restaurant->update($restaurantRequest->validated());

        return new RestaurantResources($restaurant);
    }

    /**
     * @param int $restaurantId RestaurantId.
     */
    public function destroy(int $restaurantId): JsonResponse
    {
        // TODO use try catch
        $restaurant = Restaurant::query()->findOrFail($restaurantId);

        $restaurant->delete();

        return $this->getResponse([], Response::HTTP_NO_CONTENT);
    }
}
