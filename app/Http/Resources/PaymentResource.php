<?php

namespace App\Http\Resources;

use App\Services\PaymentSystems\ConfirmPayment\ConfirmPaymentDTO;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var ConfirmPaymentDTO $resource */
        $resource = $this->resource;

        return [
            'status' => $resource->isPaymentSuccess()
        ];
    }
}
