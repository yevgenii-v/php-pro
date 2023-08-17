<?php

namespace App\Services\PaymentSystems\ConfirmPayment\Handlers;

use App\Services\PaymentSystems\ConfirmPayment\ConfirmPaymentDTO;
use App\Services\PaymentSystems\ConfirmPayment\ConfirmPaymentInterface;
use App\Services\PaymentSystems\ConfirmPayment\PaymentInfoDTO;
use App\Services\PaymentSystems\PaymentSystemFactory;
use Closure;
use Illuminate\Contracts\Container\BindingResolutionException;

class CheckPaymentResultHandler implements ConfirmPaymentInterface
{

    public function __construct(
        protected PaymentSystemFactory $paymentSystemFactory,
    ) {
    }

    /**
     * @throws BindingResolutionException
     */
    public function handle(ConfirmPaymentDTO $confirmPaymentDTO, Closure $next): ConfirmPaymentDTO
    {
        $paymentService = $this->paymentSystemFactory->getInstance(
            $confirmPaymentDTO->getPaymentSystems()
        );

        $data = $paymentService->validatePayment($confirmPaymentDTO->getPaymentId());

        $confirmPaymentDTO->setPaymentStatus($data->getStatus());

        return $next($confirmPaymentDTO);
    }
}
