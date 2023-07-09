<?php

namespace App\Http\Requests\Book;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Routing\Route;

class BookRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        $rules = [];

        if ($this->routeList()) {
            $rules = [
                'id' => ['numeric']
            ];
        }

        return $rules + [
            'name'          => ['string'],
            'author'        => ['string'],
            'year'          => ['numeric'],
            'countPages'    => ['numeric'],
        ];
    }

    public function prepareForValidation(): void
    {
        $this->merge([
            'id' => $this->route('book')
        ]);
    }

    private function routeList(): bool
    {
        return $this->routeIs('books.index', 'books.show', 'books.update', 'books.destroy');
    }
}
