<?php

namespace App\Http\Resources\Book;

use App\Http\Resources\Category\CategoryWithoutBooksResource;
use App\Repositories\Books\Iterators\BookWithoutAuthorsIterator;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

/**
 * @OA\Schema(
 *     schema="BookWithoutAuthors",
 *     description="The Book",
 *     @OA\Property(property="id", type="integer"),
 *     @OA\Property(property="name", type="string"),
 *     @OA\Property(property="year", type="integer"),
 *     @OA\Property(property="category", ref="#/components/schemas/CategoryWithoutBooks"),
 *     @OA\Property(property="lang", type="string", enum={App\Enums\Lang::class}),
 *     @OA\Property(property="pages", type="integer"),
 *     @OA\Property(property="createdAt", type="string"),
 * )
 */
class BookWithoutAuthorsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var BookWithoutAuthorsIterator $resource */
        $resource = $this->resource;

        return [
            'id'        => $resource->getId(),
            'name'      => $resource->getName(),
            'year'      => $resource->getYear(),
            'category'  => CategoryWithoutBooksResource::make(
                $resource->getCategory()
            ),
            'lang'      => $resource->getLang(),
            'pages'     => $resource->getPages(),
            'createdAt' => $resource->getCreatedAt(),
            'updatedAt' => $resource->getUpdatedAt(),
        ];
    }
}
