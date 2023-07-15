<?php

namespace App\Http\Requests\Book;

use App\Enums\Lang;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class BookUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'id'            => ['integer', 'exists:books,id'],
            'name'          => ['string', 'min:1', 'max:255', 'unique:books,name,' . $this->id],
            'year'          => ['integer', 'min:1970', 'max:' . Carbon::now()->format('Y')],
            'lang'          => [Rule::enum(Lang::class)],
            'pages'         => ['integer', 'min:10', 'max:55000'],
            'categoryId'    => ['integer', 'exists:categories,id'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'id' => $this->route('book')
        ]);
    }

    public function validationData(): array
    {
        $validated = parent::validationData();

        $validated['lang'] = Lang::from($validated['lang']);

        return $validated;
    }
}
