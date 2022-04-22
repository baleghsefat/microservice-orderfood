<?php

namespace Tests;

use App\Models\Category;
use Illuminate\Http\Response;

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
