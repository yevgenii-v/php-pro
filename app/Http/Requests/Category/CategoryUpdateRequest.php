<?php

namespace App\Http\Requests\Category;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CategoryUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'id' => ['integer', 'exists:categories,id'],
            'name' => ['string', 'unique:categories,name,' . $this->id],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'id' => $this->category,
        ]);
    }
}
