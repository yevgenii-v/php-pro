<?php

namespace App\Http\Resources\Book;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

/**
 * @OA\Schema(
 *     schema="BookModelWithoutRelations",
 *     description="The Books",
 *     @OA\Property(property="id", type="integer"),
 *     @OA\Property(property="name", type="string"),
 *     @OA\Property(property="year", type="integer"),
 *     @OA\Property(property="lang", type="string"),
 *     @OA\Property(property="pages", type="integer"),
 *     @OA\Property(property="createdAt", type="string"),
 * )
 */
class BookModelWithoutRelationsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var Book $resource */
        $resource = $this->resource;

        return [
            'id'        => $resource->id,
            'name'      => $resource->name,
            'year'      => $resource->year,
            'lang'      => $resource->lang,
            'pages'     => $resource->pages,
            'createdAt' => $resource->created_at,
        ];
    }
}
