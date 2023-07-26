<?php

namespace App\Http\Resources;

use App\Repositories\Authentication\Iterators\LoginUserIterator;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LoginResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var LoginUserIterator $resource */
        $resource = $this->resource;

        return [
            'id'        => $resource->getId(),
            'email'     => $resource->getEmail(),
        ];
    }
}
