<?php

namespace App\Services\PaymentSystems\ConfirmPayment\Handlers;

use App\Enums\Currency;
use App\Enums\TransactionStatus;
use App\Repositories\PaymentResults\PaymentResultRepository;
use App\Repositories\PaymentResults\PaymentResultStoreDTO;
use App\Services\OrderPaymentService;
use App\Services\PaymentSystems\ConfirmPayment\ConfirmPaymentDTO;
use App\Services\PaymentSystems\ConfirmPayment\ConfirmPaymentInterface;
use Closure;

class SavePaymentResultHandler implements ConfirmPaymentInterface
{

    public function __construct(
        protected PaymentResultRepository $paymentResultRepository,
    ) {
    }

    public function handle(ConfirmPaymentDTO $confirmPaymentDTO, Closure $next): ConfirmPaymentDTO
    {
        $service = new OrderPaymentService();
        $orderId = $service->store();

        $paymentResultStoreDTO = new PaymentResultStoreDTO(
            $confirmPaymentDTO->paymentStatus(),
            $orderId,
            $confirmPaymentDTO->getPaymentId(),
            1,
            20,
            Currency::USD
        );

        $paymentResultStoreDTO->setPaymentSystem($confirmPaymentDTO->getPaymentSystems());

        $this->paymentResultRepository->store($paymentResultStoreDTO);

        return $next($confirmPaymentDTO);
    }
}
