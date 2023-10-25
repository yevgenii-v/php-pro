<?php

namespace App\Http\Resources;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

class ValidationErrorsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    #[OA\Schema(
        schema: 'ValidationErrors',
        description: 'Validation Errors',
        properties: [
            new OA\Property(property: 'errors', description: "each key describes error message", type: 'object'),
            new OA\Property(property: 'message', type: 'string'),
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
