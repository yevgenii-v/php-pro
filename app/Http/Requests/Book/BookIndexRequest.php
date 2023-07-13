<?php

namespace App\Http\Requests\Book;

use App\Enums\Lang;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

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
                'date_format:Y-m-d',
                'before:endDate',
                'after_or_equal: 1970-01-01',
                'before_or_equal:' . Carbon::now()->format('Y-m-d')
                ],
            'endDate'   => [
                'required',
                'date_format:Y-m-d',
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
                new Enum(Lang::class),
            ],
        ];
    }
}
