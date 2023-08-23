<?php

namespace App\Http\Resources;

use App\Models\Category;
use App\Repositories\Categories\Iterators\CategoryIterator;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

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
