<?php

namespace App\Http\Resources\Category;

use App\Http\Resources\Book\BookForCategoryResource;
use App\Repositories\Categories\Iterators\CategoryIterator;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

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
