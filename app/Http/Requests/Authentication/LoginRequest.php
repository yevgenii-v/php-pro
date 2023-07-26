<?php

namespace App\Http\Requests\Authentication;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'email'     => ['required', 'email', 'exists:users,email', 'max:255'],
            'password'  => ['required', 'string', 'max:255'],
        ];
    }
}
