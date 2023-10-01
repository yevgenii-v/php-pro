<?php

namespace App\Http\Resources;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ErrorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var Exception $exception */
        $exception = $this->resource;

        return [
            'code'      => $exception->getCode(),
            'message'   => $exception->getMessage(),
        ];
    }
}
