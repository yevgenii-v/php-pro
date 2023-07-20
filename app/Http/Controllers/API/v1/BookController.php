<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Book\BookDestroyRequest;
use App\Http\Requests\Book\BookIndexRequest;
use App\Http\Requests\Book\BookShowRequest;
use App\Http\Requests\Book\BookStoreRequest;
use App\Http\Requests\Book\BookUpdateRequest;
use App\Http\Resources\BookResource;
use App\Repositories\Books\BookIndexDTO;
use App\Repositories\Books\BookStoreDTO;
use App\Repositories\Books\BookUpdateDTO;
use App\Services\BookService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class BookController extends Controller
{

    public function __construct(
        protected BookService $bookService
    ) {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(BookIndexRequest $request): JsonResponse
    {
        $dto = new BookIndexDTO(...$request->validated());
        $service = $this->bookService->index($dto);

        $resource = BookResource::collection($service)->additional(['meta' => [
            'lastId' => $service->last()->getId(),
        ]]);

        return $resource->response()->setStatusCode(200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BookStoreRequest $request): JsonResponse
    {
        $dto = new BookStoreDTO(...$request->validated());
        $service = $this->bookService->store($dto);
        $resource = BookResource::make($service);

        return $resource->response()->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show(BookShowRequest $request): JsonResponse
    {
        $validatedData = $request->validated();
        $service = $this->bookService->show($validatedData['id']);
        $resource = BookResource::make($service);

        return $resource->response()->setStatusCode(200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BookUpdateRequest $request): JsonResponse
    {
        $dto = new BookUpdateDTO(...$request->validated());
        $service = $this->bookService->update($dto);
        $resource = BookResource::make($service);

        return $resource->response()->setStatusCode(200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BookDestroyRequest $request): Response
    {
        $validatedData = $request->validated();
        $this->bookService->destroy($validatedData['id']);

        return response()->noContent();
    }
}
