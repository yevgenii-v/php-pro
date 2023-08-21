<?php

namespace App\Http\Controllers\API\v1;

use App\Enums\Currency;
use App\Enums\PaymentSystem;
use App\Http\Controllers\Controller;
use App\Http\Requests\PaymentConfirmRequest;
use App\Services\OrderPaymentService;
use App\Services\PaymentSystems\ConfirmPayment\ConfirmPaymentService;
use App\Services\PaymentSystems\DTO\MakePaymentDTO;
use App\Services\PaymentSystems\PaymentSystemFactory;
use App\Services\Users\UserAuthService;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\JsonResponse;

class PaymentSystemController extends Controller
{
    public function __construct(
        protected PaymentSystemFactory $paymentSystemFactory,
        protected OrderPaymentService $orderPaymentService,
        protected UserAuthService $userAuthService,
    ) {
    }

    /**
     * @throws BindingResolutionException
     */
    public function createPayment(int $system): JsonResponse
    {
        $paymentService = $this->paymentSystemFactory->getInstance(
            PaymentSystem::from($system)
        );

        $orderId = $this->orderPaymentService->store();

        $makePaymentDTO = new MakePaymentDTO(
            20.00,
            Currency::USD,
            $orderId,
        );

        $json = $paymentService->createPayment($makePaymentDTO);
        $data = json_decode($json, true);

        return response()->json([
            'order' => [
                'id'        => $data['id'],
                'sig'       => $data['sig'] ?? '',
            ],
        ]);
    }

    public function confirmPayment(
        PaymentConfirmRequest $request,
        ConfirmPaymentService $confirmPaymentService,
        int $system
    ): int {
        $data = $request->validated();

        $result = $confirmPaymentService->handle(
            PaymentSystem::from($system),
            $data['paymentId']
        );

        return $result->paymentStatus()->value;
    }
}
