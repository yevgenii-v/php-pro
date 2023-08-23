<?php

namespace App\Http\Resources;

use App\Repositories\Books\Iterators\BooksWJIterator;
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
            'books' => $resource->getBooks()->getResource(),
        ];
    }
}
