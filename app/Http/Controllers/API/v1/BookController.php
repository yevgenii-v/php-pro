<?php

namespace App\Http\Controllers\API\v1;

use App\Enums\Lang;
use App\Http\Controllers\Controller;
use App\Http\Requests\Book\BookDestroyRequest;
use App\Http\Requests\Book\BookIndexIteratorRequest;
use App\Http\Requests\Book\BookIndexRequest;
use App\Http\Requests\Book\BookShowRequest;
use App\Http\Requests\Book\BookStoreRequest;
use App\Http\Requests\Book\BookUpdateRequest;
use App\Http\Resources\Book\BookModelResource;
use App\Http\Resources\Book\BookResource;
use App\Http\Resources\Book\BookWithoutAuthorsResource;
use App\Repositories\Books\BookIndexDTO;
use App\Repositories\Books\BookStoreDTO;
use App\Repositories\Books\BookUpdateDTO;
use App\Services\Books\BookService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use OpenApi\Attributes as OA;

class BookController extends Controller
{
    public function __construct(
        protected BookService $bookService
    ) {
    }

    /**
     * Display a listing of the resource.
     */
    #[OA\Get(
        path: '/v1/books',
        security: [['bearerAuth' => []]],
        tags: ['books'],
        parameters: [
            new OA\Parameter(
                name: 'startDate',
                in: 'query',
                required: true,
                schema: new OA\Schema(
                    description: 'Min - 1970-01-01, max date is current year, month, day, but not after endDate',
                    type: 'string',
                )
            ),
            new OA\Parameter(
                name: 'endDate',
                in: 'query',
                required: true,
                schema: new OA\Schema(
                    description: 'Minimum is startDate and maximum endDate',
                    type: 'string',
                )
            ),
            new OA\Parameter(
                name: 'year',
                in: 'query',
                schema: new OA\Schema(
                    description: 'Minimum - 1970, maximum - current year',
                    type: 'integer',
                    minimum: 1970
                )
            ),
            new OA\Parameter(
                name: 'lang',
                in: 'query',
                schema: new OA\Schema(
                    type: 'string',
                    enum: Lang::class
                )
            ),
            new OA\Parameter(
                name: 'lastId',
                in: 'query',
                schema: new OA\Schema(
                    type: 'integer',
                )
            ),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Show all books',
                content: new OA\JsonContent(ref: '#/components/schemas/BookWithoutAuthors')
            ),
            new OA\Response(
                response: 422,
                description: 'Validation errors',
                content: new OA\JsonContent(ref: '#/components/schemas/ValidationErrors')
            ),
        ],
    )]
    public function index(BookIndexRequest $request): JsonResponse
    {
        $dto = new BookIndexDTO(...$request->validated());
        $service = $this->bookService->index($dto);

        $resource = BookWithoutAuthorsResource::collection($service)->additional(['meta' => [
            'lastId' => $service->last()->getId(),
        ]]);

        return $resource->response()->setStatusCode(200);
    }

    /**
     * @throws Exception
     */
    #[OA\Get(
        path: '/v1/booksIterator',
        security: [['bearerAuth' => []]],
        tags: ['books'],
        parameters: [
            new OA\Parameter(
                name: 'lastId',
                in: 'query',
                required: true,
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Show all books',
                content: new OA\JsonContent(ref: '#/components/schemas/Book')
            ),
            new OA\Response(
                response: 422,
                description: 'Validation errors',
                content: new OA\JsonContent(ref: '#/components/schemas/ValidationErrors')
            ),
        ],
    )]
    public function getDataByIterator(BookIndexIteratorRequest $request): JsonResponse
    {
        $validatedData = $request->validated();
        $service = $this->bookService->getDataByIterator($validatedData['lastId']);

        $resource = BookResource::collection($service->getIterator()->getArrayCopy());

        return $resource->response()->setStatusCode(200);
    }

    #[OA\Get(
        path: '/v1/booksModel',
        security: [['bearerAuth' => []]],
        tags: ['books'],
        parameters: [
            new OA\Parameter(
                name: 'lastId',
                in: 'query',
                required: true,
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Show all books',
                content: new OA\JsonContent(ref: '#/components/schemas/Book')
            ),
            new OA\Response(
                response: 422,
                description: 'Validation errors',
                content: new OA\JsonContent(ref: '#/components/schemas/ValidationErrors')
            ),
        ],
    )]
    public function getDataByModel(BookIndexIteratorRequest $request): JsonResponse
    {
        $validatedData = $request->validated();
        $service = $this->bookService->getDataByModel($validatedData['lastId']);

        $resource = BookModelResource::collection($service);

        return $resource->response()->setStatusCode(200);
    }

    /**
     * Store a newly created resource in storage.
     */
    #[OA\Post(
        path: '/v1/books',
        security: [['bearerAuth' => []]],
        tags: ['books'],
        parameters: [
            new OA\Parameter(
                name: 'name',
                in: 'query',
                required: true,
                schema: new OA\Schema(
                    description: 'maximum symbols - 255',
                    type: 'string',
                    maxLength: 255,
                )
            ),
            new OA\Parameter(
                name: 'year',
                in: 'query',
                required: true,
                schema: new OA\Schema(
                    description: 'minimum - 1970, max value is actual year',
                    type: 'integer',
                    minimum: 1970,
                )
            ),
            new OA\Parameter(
                name: 'lang',
                in: 'query',
                required: true,
                schema: new OA\Schema(
                    enum: Lang::class,
                )
            ),
            new OA\Parameter(
                name: 'pages',
                in: 'query',
                required: true,
                schema: new OA\Schema(
                    type: 'integer',
                    maximum: 55000,
                    minimum: 10,
                )
            ),
            new OA\Parameter(
                name: 'categoryId',
                in: 'query',
                required: true,
                schema: new OA\Schema(
                    type: 'integer',
                )
            ),
        ],
        responses: [
            new OA\Response(
                response: 201,
                description: 'show created book',
                content: new OA\JsonContent(ref: '#/components/schemas/Book')
            ),
            new OA\Response(
                response: 422,
                description: 'Validation errors',
                content: new OA\JsonContent(ref: '#/components/schemas/ValidationErrors')
            ),
        ],
    )]
    public function store(BookStoreRequest $request): JsonResponse
    {
        $dto = new BookStoreDTO(...$request->validated());
        $service = $this->bookService->store($dto);
        $resource = BookWithoutAuthorsResource::make($service);

        return $resource->response()->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    #[OA\Get(
        path: '/v1/books/{id}',
        security: [['bearerAuth' => []]],
        tags: ['books'],
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
                description: 'show book',
                content: new OA\JsonContent(ref: '#/components/schemas/Book')
            ),
        ],
    )]
    public function show(BookShowRequest $request): JsonResponse
    {
        $validatedData = $request->validated();
        $service = $this->bookService->show($validatedData['id']);
        $resource = BookWithoutAuthorsResource::make($service);

        return $resource->response()->setStatusCode(200);
    }

    /**
     * Update the specified resource in storage.
     */
    #[OA\Patch(
        path: '/v1/books/{id}',
        security: [['bearerAuth' => []]],
        tags: ['books'],
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
                    description: 'Should be unique',
                    type: 'string',
                    maxLength: 255,
                    minLength: 1,
                )
            ),
            new OA\Parameter(
                name: 'year',
                in: 'query',
                required: true,
                schema: new OA\Schema(
                    description: 'max value actual year',
                    type: 'integer',
                    minimum: 1970,
                )
            ),
            new OA\Parameter(
                name: 'lang',
                in: 'query',
                required: true,
                schema: new OA\Schema(
                    type: 'string',
                    enum: Lang::class,
                )
            ),
            new OA\Parameter(
                name: 'pages',
                in: 'query',
                required: true,
                schema: new OA\Schema(
                    type: 'integer',
                    maximum: 55000,
                    minimum: 10,
                )
            ),
            new OA\Parameter(
                name: 'categoryId',
                in: 'query',
                required: true,
                schema: new OA\Schema(
                    description: 'only exists categories',
                    type: 'integer',
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
    public function update(BookUpdateRequest $request): JsonResponse
    {
        $dto = new BookUpdateDTO(...$request->validated());
        $service = $this->bookService->update($dto);
        $resource = BookWithoutAuthorsResource::make($service);

        return $resource->response()->setStatusCode(200);
    }

    /**
     * Remove the specified resource from storage.
     */
    #[OA\Delete(
        path: '/v1/books/{id}',
        security: [['bearerAuth' => []]],
        tags: ['books'],
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
                description: 'delete a book',
                content: null,
            ),
        ],
    )]
    public function destroy(BookDestroyRequest $request): Response
    {
        $validatedData = $request->validated();
        $this->bookService->destroy($validatedData['id']);

        return response()->noContent();
    }
}
