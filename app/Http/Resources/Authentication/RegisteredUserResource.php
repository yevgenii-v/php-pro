<?php

namespace App\Http\Resources\Authentication;

use App\Repositories\Authentication\Iterators\RegisteredUserIterator;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RegisteredUserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var RegisteredUserIterator $resource */
        $resource = $this->resource;

        return [
            'id'            => $resource->getId(),
            'name'          => $resource->getName(),
            'email'         => $resource->getEmail(),
            'createdAt'     => $resource->getCreatedAt()
        ];
    }
}
