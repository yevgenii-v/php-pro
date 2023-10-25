<?php

namespace App\Http\Resources\Category;

use App\Http\Resources\Book\BookModelWithoutRelationsResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

/**
 * @OA\Schema(
 *     schema="CategoryModel",
 *     description="The Category",
 *     @OA\Property(property="id", type="integer"),
 *     @OA\Property(property="name", type="string"),
 *     @OA\Property(property="books", ref="#/components/schemas/BookModelWithoutRelations"),
 * )
 */
class CategoryModelResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var Category $resource */

        $resource = $this->resource;

        return [
            'id'    => $resource->id,
            'name'  => $resource->name,
            'books' => BookModelWithoutRelationsResource::collection($resource->books),
        ];
    }
}
