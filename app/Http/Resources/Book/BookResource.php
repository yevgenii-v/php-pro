<?php

namespace App\Http\Resources\Book;

use App\Enums\Lang;
use App\Http\Resources\Author\AuthorResource;
use App\Http\Resources\Category\CategoryWithoutBooksResource;
use App\Repositories\Books\Iterators\BookIterator;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'Book',
    description: 'The Book',
    properties: [
        new OA\Property(
            property: 'id',
            type: 'integer',
        ),
        new OA\Property(
            property: 'name',
            type: 'string',
        ),
        new OA\Property(
            property: 'year',
            type: 'integer',
        ),
        new OA\Property(
            property: 'category',
            ref: '#/components/schemas/Category'
        ),
        new OA\Property(
            property: 'authors',
            ref: '#/components/schemas/Authors',
        ),
        new OA\Property(
            property: 'lang',
            type: 'string',
            enum: Lang::class,
        ),
        new OA\Property(
            property: 'pages',
            type: 'integer',
        ),
        new OA\Property(
            property: 'createdAt',
            type: 'string',
        ),
    ]
)]
class BookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var BookIterator $resource */
        $resource = $this->resource;

        return [
            'id'        => $resource->getId(),
            'name'      => $resource->getName(),
            'year'      => $resource->getYear(),
            'category'  => new CategoryWithoutBooksResource($resource->getCategory()),
            'authors'   => AuthorResource::collection($resource->getAuthors()->getIterator()->getArrayCopy()),
            'lang'      => $resource->getLang(),
            'pages'     => $resource->getPages(),
            'createdAt' => $resource->getCreatedAt(),
        ];
    }
}
