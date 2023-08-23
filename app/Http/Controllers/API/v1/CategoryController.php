<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\CategoryDestroyRequest;
use App\Http\Requests\Category\CategoryShowRequest;
use App\Http\Requests\Category\CategoryStoreRequest;
use App\Http\Requests\Category\CategoryUpdateRequest;
use App\Http\Resources\CategoryModelResource;
use App\Http\Resources\CategoryResource;
use App\Repositories\Categories\CategoryStoreDTO;
use App\Repositories\Categories\CategoryUpdateDTO;
use App\Services\CategoryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class CategoryController extends Controller
{

    public function __construct(
        protected CategoryService $categoryService,
    ) {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $service = $this->categoryService->index();
        $resource = CategoryResource::collection($service);

        return $resource->response()->setStatusCode(200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryStoreRequest $request): JsonResponse
    {
        $dto = new CategoryStoreDTO(...$request->validated());
        $service = $this->categoryService->store($dto);
        $resource = CategoryResource::make($service);

        return $resource->response()->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show(CategoryShowRequest $request): JsonResponse
    {
        $validatedData = $request->validated();
        $service = $this->categoryService->show($validatedData['id']);
        $resource = CategoryResource::make($service);

        return $resource->response()->setStatusCode(200);
    }

    public function showIterator(CategoryShowRequest $request): JsonResponse
    {
        $validatedData = $request->validated();
        $service = $this->categoryService->showIterator($validatedData['id']);

        $resource = CategoryResource::make($service);

        return $resource->response()->setStatusCode(200);
    }

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
    public function update(CategoryUpdateRequest $request): JsonResponse
    {
        $dto = new CategoryUpdateDTO(...$request->validated());
        $service = $this->categoryService->update($dto);
        $resource = CategoryResource::make($service);

        return $resource->response()->setStatusCode(200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CategoryDestroyRequest $request): Response
    {
        $validatedData = $request->validated();
        $this->categoryService->destroy($validatedData['id']);

        return response()->noContent();
    }
}
