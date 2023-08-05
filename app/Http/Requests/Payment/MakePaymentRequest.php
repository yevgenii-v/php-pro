<?php

namespace App\Http\Requests\Payment;

use App\Enums\Currency;
use App\Enums\PaymentSystems;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MakePaymentRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'amount'        => ['required', 'numeric', 'min:1', 'max:9999'],
            'currency'      => ['required', Rule::enum(Currency::class)],
            'paymentSystem' => ['required', Rule::enum(PaymentSystems::class)],
            'description'   => ['sometimes', 'max:255'],
        ];
    }
}
