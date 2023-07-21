<?php

namespace App\Http\Requests\Book;

use App\Enums\Lang;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BookIndexRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'startDate' => [
                'required',
                'date',
                'before:endDate',
                'after_or_equal: 1970-01-01',
                'before_or_equal:' . Carbon::now()->format('Y-m-d')
                ],
            'endDate'   => [
                'required',
                'date',
                'after:startDate',
                'after_or_equal: 1970-01-01',
                'before_or_equal:' . Carbon::now()->format('Y-m-d')
            ],
            'year'      => [
                'sometimes',
                'integer',
                'min:1970',
                'max:' . Carbon::now()->format('Y')
            ],
            'lang'      => [
                'sometimes',
                Rule::enum(Lang::class)
            ],
            'lastId' => ['sometimes', 'integer', 'min:1']
        ];
    }

    public function validationData(): array
    {
        $validated = parent::validationData();

        $validated['startDate'] = new Carbon($validated['startDate']);
        $validated['endDate'] = new Carbon($validated['endDate']);

        if (isset($validated['lang'])) {
            $validated['lang'] = Lang::from($validated['lang']);
        }

        return $validated;
    }
}
