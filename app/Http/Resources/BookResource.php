<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Routing\Route;

class BookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->resource->id,
            'name'          => $this->resource->name,
            'author'        => $this->resource->author,
            'year'          => $this->resource->year,
            'countPages'    => $this->resource->countPages,
        ];
    }
}
