<?php

namespace Tests;

use App\Jobs\PublishGlobalJob;
use App\Models\Category;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Bus;

class CategoryTest extends TestCase
{
    /**
     * @test
     */
    public function userWithPermissionCanStoreCategory()
    {
        $requestData = Category::factory()->make()->toArray();

        $response = $this->json('post', route('v1.categories.store'), $requestData, $this->authHeader());


        $response->assertResponseStatus(Response::HTTP_CREATED);

        $response = $response->response->getOriginalContent();

        $this->assertTrue($response instanceof Category);
        $this->assertEquals($requestData[Category::TITLE], $response[Category::TITLE]);
    }

    /**
     * @test
     */
    public function publishGlobalJobWillBeDispatchedAfterStoreCategory()
    {
        $requestData = Category::factory()->make()->toArray();

        Bus::fake();

        $response = $this->json('post', route('v1.categories.store'), $requestData, $this->authHeader());

        $response = $response->response->getOriginalContent();

        Bus::assertDispatched(function (PublishGlobalJob $job) use ($response) {
            return $job->data['event'] == 'create' && $job->data[Category::ID] == $response->{Category::ID};
        });
    }

    /**
     * @test
     */
    public function userWithPermissionCanUpdateCategory()
    {
        $requestData = Category::factory()->make()->toArray();
        $oldCategory = Category::factory()->create();

        $response = $this->json(
            'put',
            route('v1.categories.update', ['categoryId' => $oldCategory->{Category::ID}]),
            $requestData,
            $this->authHeader()
        );

        $response->assertResponseStatus(Response::HTTP_OK);

        $response = $response->response->getOriginalContent();

        $this->assertTrue($response instanceof Category);
        $this->assertEquals($requestData[Category::TITLE], $response[Category::TITLE]);
    }

    /**
     * @test
     */
    public function userWithPermissionCanDeleteCategory()
    {
        $category = Category::factory()->create();

        $response = $this->json(
            'DELETE',
            route('v1.categories.destroy', ['categoryId' => $category->{Category::ID}]),
            [],
            $this->authHeader()
        );

        $response->assertResponseStatus(Response::HTTP_NO_CONTENT);

        $this->assertTrue($category->refresh()[Category::DELETED_AT] !== null);
    }

    /**
     * @test
     */
    public function publishGlobalJobWillBeDispatchedAfterDeleteCategory()
    {
        $category = Category::factory()->create();

        Bus::fake();

        $this->json(
            'DELETE',
            route('v1.categories.destroy', ['categoryId' => $category->{Category::ID}]),
            [],
            $this->authHeader()
        );

        Bus::assertDispatched(function (PublishGlobalJob $job) use ($category) {
            return $job->data['event'] == 'delete' && $job->data[Category::ID] == $category->{Category::ID};
        });
    }

    /**
     * @test
     */
    public function userWithoutLoginCanGetCategory()
    {
        $category = Category::factory()->create();

        $response = $this->json(
            'get',
            route('v1.categories.show', ['categoryId' => $category->{Category::ID}])
        );

        $response->assertResponseStatus(Response::HTTP_OK);

        $response = $response->response->getOriginalContent();

        $this->assertTrue($response instanceof Category);
        $this->assertEquals($category[Category::TITLE], $response[Category::TITLE]);
    }

    /**
     * @test
     */
    public function userWithoutLoginCanGetAllCategories()
    {
        Category::factory()->create();

        $response = $this->json(
            'get',
            route('v1.categories.index')
        );

        $response->assertResponseStatus(Response::HTTP_OK);
    }
}
