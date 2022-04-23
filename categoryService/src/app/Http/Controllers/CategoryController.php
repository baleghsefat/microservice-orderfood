<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResources;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class CategoryController extends Controller
{
    /**
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        return CategoryResources::collection(Category::query()->paginate());
    }

    /**
     * @param int $categoryId CategoryId.
     * @return CategoryResources
     */
    public function show(int $categoryId): CategoryResources
    {
        $category = Category::query()->findOrFail($categoryId);

        return new CategoryResources($category);
    }

    /**
     * @param CategoryRequest $categoryRequest CategoryRequest.
     * @return CategoryResources
     */
    public function store(CategoryRequest $categoryRequest): CategoryResources
    {
        $category = Category::query()->create($categoryRequest->validated());

        return new CategoryResources($category);
    }

    /**
     * @param int $categoryId CategoryId.
     * @param CategoryRequest $categoryRequest CategoryRequest.
     * @return CategoryResources
     */
    public function update(int $categoryId, CategoryRequest $categoryRequest): CategoryResources
    {
        $category = Category::query()->findOrFail($categoryId);
        $category->update($categoryRequest->validated());

        return new CategoryResources($category);
    }

    /**
     * @param int $categoryId CategoryId.
     */
    public function destroy(int $categoryId): JsonResponse
    {
        // TODO use try catch
        $category = Category::query()->findOrFail($categoryId);

        $category->delete();

        return $this->getResponse([], Response::HTTP_NO_CONTENT);
    }
}
