<?php

namespace Tests;

use App\Jobs\PublishGlobalJob;
use App\Models\Restaurant;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Bus;

class RestaurantTest extends TestCase
{
    /**
     * @test
     */
    public function userWithPermissionCanStoreRestaurant()
    {
        $requestData = Restaurant::factory()->make()->toArray();

        $response = $this->json('post', route('v1.restaurants.store'), $requestData, $this->authHeader());


        $response->assertResponseStatus(Response::HTTP_CREATED);

        $response = $response->response->getOriginalContent();

        $this->assertTrue($response instanceof Restaurant);
        $this->assertEquals($requestData[Restaurant::NAME], $response[Restaurant::NAME]);
        $this->assertEquals($requestData[Restaurant::ADDRESS], $response[Restaurant::ADDRESS]);
    }

    /**
     * @test
     */
    public function publishGlobalJobWillBeDispatchedAfterStoreRestaurant()
    {
        $requestData = Restaurant::factory()->make()->toArray();

        Bus::fake();

        $response = $this->json('post', route('v1.restaurants.store'), $requestData, $this->authHeader());

        $response = $response->response->getOriginalContent();

        Bus::assertDispatched(function (PublishGlobalJob $job) use ($response) {
            return $job->data['event'] == 'create' && $job->data[Restaurant::ID] == $response->{Restaurant::ID};
        });
    }

    /**
     * @test
     */
    public function userWithPermissionCanUpdateRestaurant()
    {
        $requestData = Restaurant::factory()->make()->toArray();
        $oldRestaurant = Restaurant::factory()->create();

        $response = $this->json(
            'put',
            route('v1.restaurants.update', ['restaurantId' => $oldRestaurant->{Restaurant::ID}]),
            $requestData,
            $this->authHeader()
        );

        $response->assertResponseStatus(Response::HTTP_OK);

        $response = $response->response->getOriginalContent();

        $this->assertTrue($response instanceof Restaurant);
        $this->assertEquals($requestData[Restaurant::NAME], $response[Restaurant::NAME]);
        $this->assertEquals($requestData[Restaurant::ADDRESS], $response[Restaurant::ADDRESS]);
    }

    /**
     * @test
     */
    public function userWithPermissionCanDeleteRestaurant()
    {
        $restaurant = Restaurant::factory()->create();

        $response = $this->json(
            'DELETE',
            route('v1.restaurants.destroy', ['restaurantId' => $restaurant->{Restaurant::ID}]),
            [],
            $this->authHeader()
        );

        $response->assertResponseStatus(Response::HTTP_NO_CONTENT);

        $this->assertTrue($restaurant->refresh()[Restaurant::DELETED_AT] !== null);
    }

    /**
     * @test
     */
    public function publishGlobalJobWillBeDispatchedAfterDeleteRestaurant()
    {
        $restaurant = Restaurant::factory()->create();

        Bus::fake();

        $this->json(
            'DELETE',
            route('v1.restaurants.destroy', ['restaurantId' => $restaurant->{Restaurant::ID}]),
            [],
            $this->authHeader()
        );

        Bus::assertDispatched(function (PublishGlobalJob $job) use ($restaurant) {
            return $job->data['event'] == 'delete' && $job->data[Restaurant::ID] == $restaurant->{Restaurant::ID};
        });
    }

    /**
     * @test
     */
    public function userWithoutLoginCanGetRestaurant()
    {
        $restaurant = Restaurant::factory()->create();

        $response = $this->json(
            'get',
            route('v1.restaurants.show', ['restaurantId' => $restaurant->{Restaurant::ID}])
        );

        $response->assertResponseStatus(Response::HTTP_OK);

        $response = $response->response->getOriginalContent();

        $this->assertTrue($response instanceof Restaurant);
        $this->assertEquals($restaurant[Restaurant::NAME], $response[Restaurant::NAME]);
        $this->assertEquals($restaurant[Restaurant::ADDRESS], $response[Restaurant::ADDRESS]);
    }

    /**
     * @test
     */
    public function userWithoutLoginCanGetAllRestaurants()
    {
        Restaurant::factory()->create();

        $response = $this->json(
            'get',
            route('v1.restaurants.index')
        );

        $response->assertResponseStatus(Response::HTTP_OK);
    }
}
