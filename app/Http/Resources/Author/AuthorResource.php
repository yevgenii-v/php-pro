<?php

namespace App\Http\Resources\Author;

use App\Repositories\Authors\Iterators\AuthorIterator;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'Authors',
    description: 'The Authors, WARNING: Many-to-many relation',
    properties: [
        new OA\Property(
            property: 'id',
            type: 'integer',
        ),
        new OA\Property(
            property: 'name',
            type: 'string',
        ),
    ]
)]
class AuthorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var AuthorIterator $resource */
        $resource = $this->resource;

        return [
            'id'    => $resource->getId(),
            'name'  => $resource->getName(),
        ];
    }
}
