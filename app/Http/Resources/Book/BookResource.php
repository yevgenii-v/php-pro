<?php

namespace App\Http\Resources\Book;

use App\Http\Resources\Author\AuthorResource;
use App\Http\Resources\Category\CategoryWithoutBooksResource;
use App\Repositories\Books\Iterators\BookIterator;
use App\Repositories\Categories\Iterators\CategoryWithoutBooksIterator;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

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
