<?php

namespace App\Http\Controllers\API\v1;

use App\Exceptions\CategoryNameExistsException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Category\CategoryDestroyRequest;
use App\Http\Requests\Category\CategoryShowRequest;
use App\Http\Requests\Category\CategoryStoreRequest;
use App\Http\Requests\Category\CategoryUpdateRequest;
use App\Http\Resources\Category\CategoryModelResource;
use App\Http\Resources\Category\CategoryResource;
use App\Http\Resources\Category\CategoryWithoutBooksResource;
use App\Http\Resources\ErrorResource;
use App\Repositories\Categories\CategoryStoreDTO;
use App\Repositories\Categories\CategoryUpdateDTO;
use App\Services\Categories\CategoryService;
use App\Services\Categories\CategoryWithCacheService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use OpenApi\Attributes as OA;

class CategoryController extends Controller
{
    public function __construct(
        protected CategoryService $categoryService,
        protected CategoryWithCacheService $categoryWithCacheService,
    ) {
    }

    /**
     * Display a listing of the resource.
     */
    #[OA\Get(
        path: '/v1/categories',
        security: [['bearerAuth' => []]],
        tags: ['categories'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Show all categories',
                content: new OA\JsonContent(ref: '#/components/schemas/Category')
            ),
        ],
    )]
    public function index(): JsonResponse
    {
        $service = $this->categoryService->index();
        $resource = CategoryWithoutBooksResource::collection($service);

        return $resource->response()->setStatusCode(200);
    }

    /**
     * @return JsonResponse
     */
    #[OA\Get(
        path: '/v1/categoriesWithCache',
        security: [['bearerAuth' => []]],
        tags: ['categories'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Show all categories. Working with cache',
                content: new OA\JsonContent(ref: '#/components/schemas/Category')
            ),
        ]
    )]
    public function cachedIndex(): JsonResponse
    {
        $service = $this->categoryWithCacheService->getCategories();

        $resource = CategoryWithoutBooksResource::collection($service);
        return $resource->response()->setStatusCode(200);
    }

    /**
     * Store a newly created resource in storage.
     */
    #[OA\Post(
        path: '/v1/categories',
        security: [['bearerAuth' => []]],
        tags: ['categories'],
        parameters: [
            new OA\Parameter(
                name: 'name',
                in: 'query',
                required: true,
                schema: new OA\Schema(
                    type: 'string',
                )
            )
        ],
        responses: [
            new OA\Response(
                response: 201,
                description: 'Show created category',
                content: new OA\JsonContent(ref: '#/components/schemas/CategoryWithoutBooks')
            ),
            new OA\Response(
                response: 422,
                description: 'Validation errors',
                content: new OA\JsonContent(ref: '#/components/schemas/Errors')
            ),
        ],
    )]
    public function store(CategoryStoreRequest $request): JsonResponse|ErrorResource
    {
        $dto = new CategoryStoreDTO(...$request->validated());
        try {
            $service = $this->categoryService->store($dto);
            $resource = CategoryWithoutBooksResource::make($service);
            return $resource->response()->setStatusCode(201);
        } catch (CategoryNameExistsException $e) {
            return new ErrorResource($e);
        }
    }

    /**
     * Display the specified resource.
     */
    #[OA\Get(
        path: '/v1/categories/{id}',
        security: [['bearerAuth' => []]],
        tags: ['categories'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                required: true,
                schema: new OA\Schema(
                    type: 'integer',
                )
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'show category',
                content: new OA\JsonContent(ref: '#/components/schemas/Category')
            ),
        ],
    )]
    public function show(CategoryShowRequest $request): JsonResponse
    {
        $validatedData = $request->validated();
        $service = $this->categoryService->show($validatedData['id']);
        $resource = CategoryWithoutBooksResource::make($service);

        return $resource->response()->setStatusCode(200);
    }

    /**
     * @throws Exception
     */
    #[OA\Get(
        path: '/v1/categoryIterator/{id}',
        security: [['bearerAuth' => []]],
        tags: ['categories'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                required: true,
                schema: new OA\Schema(
                    type: 'integer',
                )
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'show category',
                content: new OA\JsonContent(ref: '#/components/schemas/Category')
            ),
        ],
    )]
    public function showIterator(CategoryShowRequest $request): JsonResponse
    {
        $validatedData = $request->validated();
        $service = $this->categoryService->showIterator($validatedData['id']);

        $resource = CategoryResource::collection($service->getIterator()->getArrayCopy());

        return $resource->response()->setStatusCode(200);
    }

    #[OA\Get(
        path: '/v1/categoryModel/{id}',
        security: [['bearerAuth' => []]],
        tags: ['categories'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                required: true,
                schema: new OA\Schema(
                    type: 'integer',
                )
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'show category',
                content: new OA\JsonContent(ref: '#/components/schemas/CategoryModel')
            ),
        ],
    )]
    public function showModel(CategoryShowRequest $request): JsonResponse
    {
        $validatedData = $request->validated();
        $service = $this->categoryService->showModel($validatedData['id']);

        $resource = CategoryModelResource::make($service);

        return $resource->response()->setStatusCode(200);
    }

    /**
     * Update the specified resource in storage.
     */
    #[OA\Patch(
        path: '/v1/categories/{id}',
        security: [['bearerAuth' => []]],
        tags: ['categories'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                required: true,
                schema: new OA\Schema(
                    type: 'integer',
                )
            ),
            new OA\Parameter(
                name: 'name',
                in: 'query',
                required: true,
                schema: new OA\Schema(
                    type: 'string',
                )
            ),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'updates book',
                content: new OA\JsonContent(ref: '#/components/schemas/BookWithoutAuthors')
            ),
            new OA\Response(
                response: 422,
                description: 'Validation errors',
                content: new OA\JsonContent(ref: '#/components/schemas/ValidationErrors')
            ),
        ],
    )]
    public function update(CategoryUpdateRequest $request): JsonResponse
    {
        $dto = new CategoryUpdateDTO(...$request->validated());
        $service = $this->categoryService->update($dto);
        $resource = CategoryWithoutBooksResource::make($service);

        return $resource->response()->setStatusCode(200);
    }

    /**
     * Remove the specified resource from storage.
     */
    #[OA\Delete(
        path: '/v1/categories/{id}',
        security: [['bearerAuth' => []]],
        tags: ['categories'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                required: true,
                schema: new OA\Schema(
                    type: 'integer',
                )
            ),
        ],
        responses: [
            new OA\Response(
                response: 204,
                description: 'delete a category',
                content: null,
            ),
        ],
    )]
    public function destroy(CategoryDestroyRequest $request): Response
    {
        $validatedData = $request->validated();
        $this->categoryService->destroy($validatedData['id']);

        return response()->noContent();
    }
}
