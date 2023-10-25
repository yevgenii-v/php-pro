<?php

namespace App\Http\Resources\Category;

use App\Http\Resources\Book\BookForCategoryResource;
use App\Repositories\Categories\Iterators\CategoryIterator;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'Category',
    description: 'The Category',
    properties: [
        new OA\Property(property: 'id', type: 'integer'),
        new OA\Property(property: 'name', type: 'string'),
        new OA\Property(
            property: 'bookForCategory',
            ref: '#/components/schemas/BookForCategory'
        ),
    ]
)]
class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     * @throws Exception
     */
    public function toArray(Request $request): array
    {
        /** @var CategoryIterator $resource */
        $resource = $this->resource;

        return [
            'id'    => $resource->getId(),
            'name'  => $resource->getName(),
            'books' => BookForCategoryResource::collection($resource->getBooks()->getIterator()->getArrayCopy()),
        ];
    }
}
