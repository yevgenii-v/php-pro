<?php

namespace App\Http\Controllers\API\v1;

use App\Enums\PaymentSystems;
use App\Http\Controllers\Controller;
use App\Http\Requests\Payment\MakePaymentRequest;
use App\Services\PaymentSystems\DTO\MakePaymentDTO;
use App\Services\PaymentSystems\PaymentSystemFactory;
use Illuminate\Contracts\Container\BindingResolutionException;

class PaymentSystemController extends Controller
{
    public function __construct(
        protected PaymentSystemFactory $paymentSystemFactory
    ) {
    }

    /**
     * @throws BindingResolutionException
     */
    public function makePayment(MakePaymentRequest $request)
    {
        $dto = new MakePaymentDTO(...$request->validated());
        $paymentService = $this->paymentSystemFactory->getInstance(
            PaymentSystems::from((int)$request->validated('paymentSystem'))
        );

        $paymentService->makePayment($dto);
    }
}
