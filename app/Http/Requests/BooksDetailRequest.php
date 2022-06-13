<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BooksDetailRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'id' => ['integer','exists:books,id'],
        ];
    }

    /**
     * Defined error id of validation
     *
     * @return string[]
     */
    public function errorCode(): array
    {
        return [
            'id.exists' => 'ID not found, please try again',
            'id.integer' => 'ID must be an integer',
        ];
    }
}
