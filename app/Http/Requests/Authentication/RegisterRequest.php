<?php

namespace App\Http\Requests\Authentication;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name'                  => ['required', 'string', 'max:255'],
            'email'                 => ['required', 'email', 'unique:users', 'max:255'],
            'password'              => ['required', 'max:255', 'confirmed', Password::min(6)
                ->mixedCase()
                ->numbers()
            ],
        ];
    }
}
