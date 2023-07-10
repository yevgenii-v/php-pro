<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Book\BookDestroyRequest;
use App\Http\Requests\Book\BookShowRequest;
use App\Http\Requests\Book\BookStoreRequest;
use App\Http\Requests\Book\BookUpdateRequest;
use App\Http\Resources\BookResource;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Foundation\Application;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {

        return BookResource::collection([
            (object)[
            'id' => 5,
            'name' => 'Lorem Ipsum',
            'author' => 'anon',
            'year' => 123123,
            'countPages' => 234435
            ],
            (object)[
            'id' => 8,
            'name' => 'Lorem Ipsum Dolor',
            'author' => 'ano34n',
            'year' => 12233123,
            'countPages' => 2342435
            ],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BookStoreRequest $request): BookResource
    {
        $validatedData = $request->validated();
        $data = ['id' => 1] + $validatedData;

        return BookResource::make((object)$data);
    }

    /**
     * Display the specified resource.
     */
    public function show(BookShowRequest $request, string $id): AnonymousResourceCollection
    {
        $validatedData = $request->validated();

        return BookResource::collection([
            (object)[
                'id' => $validatedData['id'],
                'name' => 'Lorem Ipsum',
                'author' => 'anon',
                'year' => 123123,
                'countPages' => 234435
            ],
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BookUpdateRequest $request, string $id): BookResource
    {
        $validatedData = $request->validated();

        return BookResource::make((object)$validatedData);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BookDestroyRequest $request, string $id): Application|Response|
    \Illuminate\Contracts\Foundation\Application|ResponseFactory
    {
        $request->validated();

        return response(['message' => 'Book deleted successfully.']);
    }
}
