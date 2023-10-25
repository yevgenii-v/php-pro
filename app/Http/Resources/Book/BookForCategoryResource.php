<?php

namespace App\Http\Resources\Book;

use App\Enums\Lang;
use App\Repositories\Books\Iterators\BookWithoutJoinsIterator;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'BookForCategory',
    description: 'The Books',
    properties: [
        new OA\Property(property: 'id', type: 'integer'),
        new OA\Property(property: 'name', type: 'string'),
        new OA\Property(property: 'year', type: 'integer'),
        new OA\Property(property: 'lang', type: 'string', enum: Lang::class),
        new OA\Property(property: 'pages', type: 'integer'),
        new OA\Property(property: 'createdAt', type: 'string'),
    ]
)]
class BookForCategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var BookWithoutJoinsIterator $resource */
        $resource = $this->resource;

        return [
            'id'        => $resource->getId(),
            'name'      => $resource->getName(),
            'year'      => $resource->getYear(),
            'lang'      => $resource->getLang(),
            'pages'     => $resource->getPages(),
            'createdAt' => $resource->getCreatedAt(),
        ];
    }
}
