<?php

namespace App\Http\Requests\Book;

use App\Enums\Lang;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BookStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name'          => ['string', 'min:1', 'max:255', 'unique:books,name'],
            'year'          => ['integer', 'between:1970,' . Carbon::now()->format('Y')],
            'lang'          => [Rule::enum(Lang::class)],
            'pages'         => ['integer', 'between:10, 55000'],
            'categoryId'    => ['integer', 'exists:categories,id', 'required'],
        ];
    }

    public function validationData(): array
    {
        $validated = parent::validationData();

        $validated['lang'] = Lang::from($validated['lang']);

        return $validated;
    }
}
