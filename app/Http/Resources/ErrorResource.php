<?php

namespace App\Http\Resources;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

class ErrorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    #[OA\Schema(
        schema: 'Errors',
        description: 'The Errors',
        properties: [
            new OA\Property(property: 'message', type: 'string'),
            new OA\Property(property: 'code', type: 'integer'),
        ]
    )]
    public function toArray(Request $request): array
    {
        /** @var Exception $exception */
        $exception = $this->resource;

        return [
            'message'   => $exception->getMessage(),
            'code'      => $exception->getCode(),
        ];
    }
}
