<?php

namespace App\Services\PaymentSystems\ConfirmPayment;

use App\Enums\PaymentSystem;
use App\Services\PaymentSystems\ConfirmPayment\Handlers\CheckPaymentResultHandler;
use App\Services\PaymentSystems\ConfirmPayment\Handlers\SavePaymentResultHandler;
use Illuminate\Pipeline\Pipeline;

class ConfirmPaymentService
{

    public const HANDLER = [
        CheckPaymentResultHandler::class,
        SavePaymentResultHandler::class,
    ];

    public function __construct(
        protected Pipeline $pipeline,
    ) {
    }

    public function handle(PaymentSystem $paymentSystems, string $paymentId): ConfirmPaymentDTO
    {
        $dto = new ConfirmPaymentDTO($paymentSystems, $paymentId);

        return $this->pipeline
            ->send($dto)
            ->through(self::HANDLER)
            ->then(function (ConfirmPaymentDTO $confirmPaymentDTO) {
                return $confirmPaymentDTO;
            });
    }
}
